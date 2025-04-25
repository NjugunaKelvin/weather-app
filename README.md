# 🌦️ Weather App

A decoupled weather application with Next.js frontend and Laravel API backend, powered by OpenWeatherMap.

## ✨ Features

- Real-time weather data
- 3-day forecast
- City search with autocomplete
- Temperature unit toggle (°C/°F)
- Responsive design
- Modern UI with NextUI components

## 🛠️ Tech Stack

| Frontend          | Backend         |
|-------------------|-----------------|
| Next.js 14        | Laravel 11      |
| TypeScript        | PHP 8.2+        |
| Tailwind CSS      | API Resources   |
| NextUI            | Laravel Sanctum |
| OpenWeatherMap API| Guzzle HTTP     |

## 🚀 Quick Start

### Prerequisites
```bash
# Verify installations
node -v  # Requires v18+
php -v   # Requires v8.2+
composer -v
```

### 1. Clone repository
```bash
git clone https://github.com/yourusername/weather-app.git
cd weather-app
```

### 2. Frontend setup
```bash
cd frontend && \
npm install && \
cp .env.example .env.local
```

### 3. Backend setup
```bash
cd ../backend && \
composer install && \
cp .env.example .env && \
php artisan key:generate
```

### 4. Configure environment

Frontend (`.env.local`):
```bash
echo "NEXT_PUBLIC_OWM_API_KEY=your_key_here
NEXT_PUBLIC_API_URL=http://localhost:8000/api
" > .env.local
```

Backend (`.env`):
```bash
echo "OWM_API_KEY=your_key_here
DB_CONNECTION=sqlite
" > .env
```

### 5. Initialize database
```bash
touch database/database.sqlite && \
php artisan migrate
```

### 6. Run the application

In separate terminals:

**Terminal 1 (Frontend):**
```bash
cd frontend && npm run dev
```

**Terminal 2 (Backend):**
```bash
cd backend && php artisan serve
```

Access at: [http://localhost:3000](http://localhost:3000)