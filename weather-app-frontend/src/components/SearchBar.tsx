'use client';

import { Input, Button, Icon } from 'rippleui';
import { useState } from 'react';

export default function SearchBar({ 
  onSearch,
  isLoading 
}: {
  onSearch: (city: string) => void;
  isLoading: boolean;
}) {
  const [city, setCity] = useState('');

  return (
    <div className="flex gap-2 max-w-md mx-auto mb-6">
      <Input
        type="text"
        placeholder="Search city..."
        value={city}
        onChange={(e) => setCity(e.target.value)}
        className="flex-1"
      />
      <Button 
        onClick={() => onSearch(city)}
        loading={isLoading}
      >
        <Icon name="Search" size="18" className="mr-2" />
        Search
      </Button>
    </div>
  );
}