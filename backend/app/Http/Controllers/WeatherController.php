<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;
use Illuminate\Http\Request;
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
            return response()->json([
                'error' => 'Invalid coordinates',
                'details' => $validator->errors()
            ], 400);
        }

        $data = $this->weatherService->getWeatherData(
            $request->lat,
            $request->lon,
            $request->exclude ?? ''
        );

        return response()->json($data);
    }

    public function getHistoricalWeather(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric|between:-90,90',
            'lon' => 'required|numeric|between:-180,180',
            'timestamp' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $data = $this->weatherService->getHistoricalWeatherData(
            $request->lat,
            $request->lon,
            $request->timestamp
        );

        return response()->json($data);
    }
}
