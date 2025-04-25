import { 
    SunIcon,
    CloudIcon,
    CloudSunIcon,
    CloudRainIcon,
    BoltIcon,
    SnowflakeIcon,
    FogIcon 
  } from '@heroicons/react/24/solid';
  
  export function getWeatherIcon(iconCode: string, className = 'text-5xl') {
    const iconMap: Record<string, JSX.Element> = {
      '01d': <SunIcon className={`${className} text-yellow-400`} />,
      '01n': <SunIcon className={`${className} text-yellow-200`} />,
      // Add other icon mappings
    };
  
    return iconMap[iconCode] || iconMap[iconCode.substring(0, 2)] || iconMap['01d'];
  }