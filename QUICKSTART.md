# Quick Start Guide - Koora Soccer Platform

## 🚀 Getting Started in 5 Minutes

### Step 1: Start the Backend (Terminal 1)

```bash
cd backend
php artisan serve
```

The backend API will be running at `http://localhost:8000`

### Step 2: Start the Frontend (Terminal 2)

```bash
cd frontend
npm run dev
```

The frontend will be running at `http://localhost:5173`

### Step 3: Access the Application

Open your browser and navigate to: `http://localhost:5173`

## 📱 Available Pages

- **Home** - `/` - Overview and latest news
- **Live Matches** - `/matches/live` - Currently ongoing matches
- **Upcoming Matches** - `/matches/upcoming` - Scheduled future matches
- **Results** - `/matches/results` - Completed matches with scores
- **News** - `/news` - Latest soccer news
- **API Info** - `/api-info` - External API integration information

## 🎯 Sample Data

The application comes pre-seeded with sample data:
- 5 Leagues (Premier League, La Liga, Serie A, Bundesliga, Ligue 1)
- 8 Teams (Manchester United, Liverpool, Chelsea, Arsenal, Real Madrid, Barcelona, Atletico Madrid, Sevilla)
- 5 Matches (past, live, and upcoming)
- 4 News articles

## 🔌 Optional: Import Real Data

To fetch real data from API-Football:

1. Visit: https://rapidapi.com/api-sports/api/api-football
2. Sign up and get a free API key (500 requests/day)
3. Add to `backend/.env`:
   ```
   FOOTBALL_API_KEY=your_api_key_here
   ```
4. Go to the API Info page in the frontend
5. Click the import buttons to fetch real data

### Example: Import Premier League Data

Using the API Info page or via curl:

```bash
# Import teams for Premier League (ID: 39)
curl -X POST "http://localhost:8000/api/external/fetch-teams" \
  -H "Content-Type: application/json" \
  -d '{"league_id": 39, "season": 2024, "db_league_id": 1}'

# Import matches
curl -X POST "http://localhost:8000/api/external/fetch-matches" \
  -H "Content-Type: application/json" \
  -d '{"league_id": 39, "season": 2024, "db_league_id": 1}'
```

## 🐳 Using Docker (Alternative)

If you prefer Docker:

```bash
# Build and start all services
docker-compose up --build

# Backend will be at: http://localhost:8000
# Frontend will be at: http://localhost:5173
```

## 🔧 Troubleshooting

### Backend Issues

**Port 8000 already in use?**
```bash
php artisan serve --port=8001
```
Don't forget to update `VITE_API_URL` in `frontend/.env`

**Database errors?**
```bash
cd backend
php artisan migrate:fresh --seed
```

### Frontend Issues

**Port 5173 already in use?**
```bash
npm run dev -- --port 3000
```

**Module not found errors?**
```bash
rm -rf node_modules package-lock.json
npm install
```

**API connection errors?**
- Make sure the backend is running
- Check `VITE_API_URL` in `frontend/.env` matches your backend URL

## 📊 API Testing

Test the API endpoints:

```bash
# Get all leagues
curl http://localhost:8000/api/leagues

# Get upcoming matches
curl http://localhost:8000/api/matches/upcoming/list

# Get live matches
curl http://localhost:8000/api/matches/live/list

# Get results
curl http://localhost:8000/api/matches/results/list

# Get news
curl http://localhost:8000/api/news
```

## 🎨 Features Overview

### Backend Features
- ✅ RESTful API with Laravel 11
- ✅ SQLite database (easy setup, no configuration needed)
- ✅ CRUD operations for Leagues, Teams, Matches, and News
- ✅ Specialized endpoints for match filtering (live, upcoming, results)
- ✅ External API integration with API-Football
- ✅ Sample data seeding
- ✅ CORS enabled for frontend communication

### Frontend Features
- ✅ Vue.js 3 with Composition API
- ✅ Vue Router for navigation
- ✅ Responsive design
- ✅ Real-time data fetching with Axios
- ✅ Clean and modern UI
- ✅ Match status indicators (Live, Upcoming, Finished)
- ✅ League filtering
- ✅ News section
- ✅ API integration management

## 🆘 Need Help?

Check the main README.md for detailed documentation:
```bash
cat README.md
```

Or check the API documentation:
- Visit http://localhost:5173/api-info in the frontend
- Or curl http://localhost:8000/api/external/info

## 🎉 You're Ready!

Your soccer platform is now running! Start exploring matches, results, and news.
