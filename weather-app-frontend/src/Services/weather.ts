import axios from 'axios';

const API_BASE_URL = 'http://localhost:8000/api';

export const fetchWeather = async (
  city?: string,
  lat?: number,
  lon?: number,
  units: 'metric' | 'imperial' = 'metric'
): Promise<WeatherData> => {
  const params = new URLSearchParams();
  
  if (city) params.append('city', city);
  if (lat) params.append('lat', lat.toString());
  if (lon) params.append('lon', lon.toString());
  params.append('units', units);

  const response = await axios.get(`${API_BASE_URL}/weather`, { params });
  return response.data;
};