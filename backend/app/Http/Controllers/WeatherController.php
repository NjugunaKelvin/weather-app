<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    protected $weatherService;
    protected $client;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false // Temporary for development
        ]);
    }

    /**
     * Get weather by coordinates
     */
    public function getWeather(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required_without:city|numeric|between:-90,90',
            'lon' => 'required_without:city|numeric|between:-180,180',
            'city' => 'required_without_all:lat,lon|string',
            'units' => 'sometimes|in:metric,imperial'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid parameters',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            // Handle city name search
            if ($request->has('city')) {
                $location = $this->geocodeCity($request->city);
                $request->merge([
                    'lat' => $location['lat'],
                    'lon' => $location['lon']
                ]);
            }

            $data = $this->weatherService->getWeatherData(
                $request->lat,
                $request->lon,
                $request->units ?? 'metric'
            );

            return response()->json([
                'location' => $data['name'] ?? 'Unknown',
                'temperature' => $data['main']['temp'],
                'conditions' => $data['weather'][0]['main'],
                'details' => $data['weather'][0]['description'],
                'icon' => $data['weather'][0]['icon'],
                'humidity' => $data['main']['humidity'],
                'wind' => $data['wind']['speed'],
                'forecast' => $this->getForecast($request->lat, $request->lon)
            ]);

        } catch (\Exception $e) {
            Log::error("Weather Error: " . $e->getMessage());
            return response()->json([
                'error' => 'Weather service unavailable',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Geocode city name to coordinates
     */
    protected function geocodeCity(string $city): array
    {
        $response = $this->client->get('http://api.openweathermap.org/geo/1.0/direct', [
            'query' => [
                'q' => $city,
                'limit' => 1,
                'appid' => env('OPENWEATHER_API_KEY')
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if (empty($data)) {
            throw new \Exception("City not found");
        }

        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon'],
            'name' => $data[0]['name']
        ];
    }

    /**
     * Get 3-day forecast
     */
    protected function getForecast(float $lat, float $lon): array
    {
        $response = $this->client->get('https://api.openweathermap.org/data/2.5/forecast', [
            'query' => [
                'lat' => $lat,
                'lon' => $lon,
                'appid' => env('OPENWEATHER_API_KEY'),
                'units' => 'metric',
                'cnt' => 24 * 3 // 3 days of data
            ]
        ]);

        return json_decode($response->getBody(), true)['list'];
    }
}
