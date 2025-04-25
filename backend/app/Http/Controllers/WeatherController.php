<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function getWeather(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
            'exclude' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            Log::warning('Invalid weather request', $validator->errors()->toArray());
            return response()->json([
                'error' => 'Invalid coordinates',
                'details' => $validator->errors()
            ], 400);
        }

        try {
            // Call the WeatherService to get the weather data
            $data = $this->weatherService->getWeatherData(
                $request->lat,
                $request->lon,
                $request->exclude ?? ''
            );

            return response()->json($data);

        } catch (\Exception $e) {
            Log::error("Unexpected weather error: " . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch weather data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
