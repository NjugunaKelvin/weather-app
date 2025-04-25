<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10, // Prevents hanging requests
            'verify' => false, // Disable SSL certificate verification (not recommended for production)
        ]);
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeatherData($lat, $lon, $exclude = '')
    {
        try {
            $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric";

            // Log the full URL being used
            Log::debug("[WeatherService] Attempting API call to: " . $url);

            // Send the GET request
            $response = $this->client->get($url);

            // Log the raw response
            $responseBody = $response->getBody()->getContents();
            Log::debug("[WeatherService] API Response: " . $responseBody);

            // Decode JSON response
            $data = json_decode($responseBody, true);

            if (empty($data)) {
                throw new \Exception("Empty API response");
            }

            return $data;

        } catch (RequestException $e) {
            // Log detailed error information
            Log::error("Weather API Request Failed: " . $e->getMessage());
            if ($e->hasResponse()) {
                Log::error("Weather API Error Response: " . $e->getResponse()->getBody()->getContents());
            }
            return ['error' => 'Weather service unavailable'];
        } catch (\Exception $e) {
            Log::error("Weather Error: " . $e->getMessage());
            return ['error' => 'Failed to fetch weather data'];
        }
    }
}
