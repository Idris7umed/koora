# ⚽ Koora - Soccer Platform

A full-stack web application for soccer matches, results, and news built with Laravel and Vue.js.

## Features

- 🔴 **Live Matches** - View currently ongoing matches
- 📅 **Upcoming Matches** - See scheduled future matches
- 📊 **Match Results** - Browse completed match results
- 📰 **Soccer News** - Stay updated with latest soccer news
- 🏆 **League & Team Management** - Browse leagues and teams
- 🔌 **External API Integration** - Import real data from API-Football

## Tech Stack

### Backend
- **Laravel 11** - PHP framework
- **SQLite** - Database
- **RESTful API** - JSON API endpoints

### Frontend
- **Vue.js 3** - Progressive JavaScript framework
- **Vue Router** - Client-side routing
- **Axios** - HTTP client

## Project Structure

```
koora/
├── backend/          # Laravel backend
│   ├── app/
│   │   ├── Http/Controllers/
│   │   └── Models/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── routes/
│       └── api.php
└── frontend/         # Vue.js frontend
    ├── src/
    │   ├── components/
    │   ├── views/
    │   ├── router/
    │   └── services/
    └── public/
```

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js 16+ and npm
- SQLite

### Backend Setup

1. Navigate to the backend directory:
```bash
cd backend
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Run migrations and seed database:
```bash
php artisan migrate --seed
```

6. Start the development server:
```bash
php artisan serve
```

The backend API will be available at `http://localhost:8000`

### Frontend Setup

1. Navigate to the frontend directory:
```bash
cd frontend
```

2. Install dependencies:
```bash
npm install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Start the development server:
```bash
npm run dev
```

The frontend will be available at `http://localhost:5173`

## API Endpoints

### Leagues
- `GET /api/leagues` - Get all leagues
- `GET /api/leagues/{id}` - Get specific league
- `POST /api/leagues` - Create new league
- `PUT /api/leagues/{id}` - Update league
- `DELETE /api/leagues/{id}` - Delete league

### Teams
- `GET /api/teams` - Get all teams
- `GET /api/teams/{id}` - Get specific team
- `POST /api/teams` - Create new team
- `PUT /api/teams/{id}` - Update team
- `DELETE /api/teams/{id}` - Delete team

### Matches
- `GET /api/matches` - Get all matches
- `GET /api/matches/{id}` - Get specific match
- `GET /api/matches/live/list` - Get live matches
- `GET /api/matches/upcoming/list` - Get upcoming matches
- `GET /api/matches/results/list` - Get finished matches
- `POST /api/matches` - Create new match
- `PUT /api/matches/{id}` - Update match
- `DELETE /api/matches/{id}` - Delete match

### News
- `GET /api/news` - Get all news
- `GET /api/news/{id}` - Get specific news item
- `POST /api/news` - Create new news
- `PUT /api/news/{id}` - Update news
- `DELETE /api/news/{id}` - Delete news

### External API Integration
- `GET /api/external/info` - Get API configuration info
- `POST /api/external/fetch-leagues` - Import leagues from API-Football
- `POST /api/external/fetch-teams` - Import teams from API-Football
- `POST /api/external/fetch-matches` - Import matches from API-Football

## Using External API (Optional)

The platform can import real data from API-Football:

1. Sign up for a free account at [RapidAPI - API-Football](https://rapidapi.com/api-sports/api/api-football)
2. Subscribe to the free tier (500 requests/day)
3. Copy your RapidAPI key
4. Add it to `backend/.env`:
```
FOOTBALL_API_KEY=your_api_key_here
```
5. Use the API Info page in the frontend to import data

**Note:** The system works with sample data even without an external API key.

## Database Schema

### Leagues Table
- `id` - Primary key
- `name` - League name
- `country` - Country name
- `logo` - Logo URL
- `timestamps`

### Teams Table
- `id` - Primary key
- `name` - Team name
- `league_id` - Foreign key to leagues
- `logo` - Logo URL
- `stadium` - Stadium name
- `timestamps`

### Matches Table
- `id` - Primary key
- `home_team_id` - Foreign key to teams
- `away_team_id` - Foreign key to teams
- `league_id` - Foreign key to leagues
- `home_score` - Home team score
- `away_score` - Away team score
- `match_date` - Match date and time
- `status` - Match status (upcoming, live, finished)
- `venue` - Venue name
- `timestamps`

### News Table
- `id` - Primary key
- `title` - News title
- `content` - News content
- `image` - Image URL
- `author` - Author name
- `timestamps`

## Development

### Backend Testing
```bash
cd backend
php artisan test
```

### Frontend Development
```bash
cd frontend
npm run dev
```

### Build for Production
```bash
cd frontend
npm run build
```

## License

This project is open-source and available under the MIT License.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.