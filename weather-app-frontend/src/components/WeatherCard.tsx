import { Card, Metric, Flex, Badge } from 'rippleui';
import { WeatherData } from '../types/weather';
import { getWeatherIcon } from './WeatherIcons';
import { format } from 'date-fns';

export default function WeatherCard({ weather }: { weather: WeatherData }) {
  return (
    <Card className="max-w-md mx-auto">
      <Flex justifyContent="between" alignItems="center">
        <div>
          <Metric>{Math.round(weather.current.temp)}°</Metric>
          <p>{weather.current.description}</p>
          <p>{format(new Date(), 'EEEE, d MMMM yyyy')}</p>
          <p>{weather.location}</p>
        </div>
        {getWeatherIcon(weather.current.icon)}
      </Flex>

      <div className="mt-6 grid grid-cols-3 gap-4">
        {weather.forecast.map((day) => (
          <div key={day.date}>
            <p>{day.day}</p>
            {getWeatherIcon(day.icon, 'text-3xl')}
            <p>{Math.round(day.min_temp)}° / {Math.round(day.max_temp)}°</p>
          </div>
        ))}
      </div>

      <div className="mt-6 flex justify-between">
        <Badge color="blue" size="sm" className="gap-2">
          <Icon name="Wind" size="18" /> {weather.current.wind} km/h
        </Badge>
        <Badge color="blue" size="sm" className="gap-2">
          <Icon name="Droplet" size="18" /> {weather.current.humidity}%
        </Badge>
      </div>
    </Card>
  );
}