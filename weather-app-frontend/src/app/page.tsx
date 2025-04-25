'use client';

import { useState, useEffect } from 'react';
import { fetchWeather } from '../services/weather';
import WeatherCard from '../components/WeatherCard';
import SearchBar from '../components/SearchBar';
import { Button } from 'rippleui';

export default function Home() {
  const [weather, setWeather] = useState<WeatherData | null>(null);
  const [loading, setLoading] = useState(true);
  const [units, setUnits] = useState<'metric' | 'imperial'>('metric');

  useEffect(() => {
    fetchDefaultWeather();
  }, []);

  const fetchDefaultWeather = async () => {
    try {
      setLoading(true);
      const data = await fetchWeather('London', undefined, undefined, units);
      setWeather(data);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const handleSearch = async (city: string) => {
    try {
      setLoading(true);
      const data = await fetchWeather(city, undefined, undefined, units);
      setWeather(data);
    } catch (err) {
      console.error(err);
    } finally {
      setLoading(false);
    }
  };

  const toggleUnits = () => {
    setUnits(units === 'metric' ? 'imperial' : 'metric');
    if (weather) {
      handleSearch(weather.location);
    }
  };

  if (loading && !weather) return <div>Loading...</div>;

  return (
    <main className="min-h-screen p-8">
      <div className="max-w-4xl mx-auto">
        <div className="flex justify-end mb-4">
          <Button size="sm" onClick={toggleUnits}>
            Switch to {units === 'metric' ? '°F' : '°C'}
          </Button>
        </div>

        <SearchBar onSearch={handleSearch} isLoading={loading} />

        {weather && <WeatherCard weather={weather} />}
      </div>
    </main>
  );
}