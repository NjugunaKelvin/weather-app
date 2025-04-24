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
        ]);
        $this->apiKey = env('OPENWEATHER_API_KEY');
    }

    public function getWeatherData($lat, $lon, $exclude = '')
    {
        try {
            $url = "https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric";

            $response = $this->client->get($url);
            $data = json_decode($response->getBody(), true);

            if (empty($data)) {
                throw new \Exception("Empty API response");
            }

            return $data;

        } catch (RequestException $e) {
            Log::error("Weather API Request Failed: " . $e->getMessage());
            return ['error' => 'Weather service unavailable'];
        } catch (\Exception $e) {
            Log::error("Weather Error: " . $e->getMessage());
            return ['error' => 'Failed to fetch weather data'];
        }
    }

    public function getHistoricalWeatherData($lat, $lon, $timestamp)
    {
        try {
            $url = "https://api.openweathermap.org/data/2.5/onecall?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric";

            $response = $this->client->get($url);
            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            Log::error("Historical Weather Error: " . $e->getMessage());
            return ['error' => 'Failed to fetch historical data'];
        }
    }
}
