interface WeatherData {
    location: string;
    current: {
      temp: number;
      feels_like: number;
      conditions: string;
      description: string;
      icon: string;
      humidity: number;
      wind: number;
    };
    forecast: Array<{
      date: string;
      day: string;
      min_temp: number;
      max_temp: number;
      icon: string;
    }>;
  }