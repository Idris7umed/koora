# External API Integration Guide

This guide explains how to integrate real soccer data from API-Football into your Koora platform.

## 🔌 Overview

Koora supports importing real-time soccer data from [API-Football](https://www.api-football.com/), a comprehensive soccer data API that provides:

- ✅ Live match scores and statistics
- ✅ Upcoming fixtures and schedules
- ✅ Historical match results
- ✅ Team information and rosters
- ✅ League standings and tables
- ✅ Player statistics
- ✅ And much more!

## 🆓 Free Tier

API-Football offers a free tier through RapidAPI:
- **500 requests per day**
- Access to all endpoints
- No credit card required for signup
- Perfect for development and small projects

## 📝 Setup Instructions

### Step 1: Get Your API Key

1. Go to [RapidAPI - API-Football](https://rapidapi.com/api-sports/api-api-football)
2. Click "Sign Up" if you don't have an account
3. Click "Subscribe to Test" button
4. Select the **Basic (Free)** plan
5. Copy your **X-RapidAPI-Key** from the API dashboard

### Step 2: Configure Your Application

Add your API key to the backend environment file:

```bash
cd backend
echo "FOOTBALL_API_KEY=your_api_key_here" >> .env
```

Or manually edit `backend/.env` and add:
```
FOOTBALL_API_KEY=your_actual_key_here
```

### Step 3: Verify Configuration

Check if the API is configured correctly:

```bash
curl http://localhost:8000/api/external/info
```

You should see `"api_configured": true` in the response.

## 🎯 Importing Data

### Using the Frontend (Recommended)

1. Navigate to `http://localhost:5173/api-info`
2. You'll see the API status and import buttons
3. Fill in the required fields:
   - **League ID**: The API-Football league ID (e.g., 39 for Premier League)
   - **Season**: The year (e.g., 2024)
   - **DB League ID**: Your local database league ID (1-5 from seed data)
4. Click the import buttons to fetch data

### Using API Endpoints

#### Import Leagues

```bash
curl -X POST http://localhost:8000/api/external/fetch-leagues \
  -H "Content-Type: application/json"
```

#### Import Teams

```bash
curl -X POST http://localhost:8000/api/external/fetch-teams \
  -H "Content-Type: application/json" \
  -d '{
    "league_id": 39,
    "season": 2024,
    "db_league_id": 1
  }'
```

Parameters:
- `league_id`: API-Football league ID
- `season`: Year of the season
- `db_league_id`: Your local database league ID to associate teams with

#### Import Matches

```bash
curl -X POST http://localhost:8000/api/external/fetch-matches \
  -H "Content-Type: application/json" \
  -d '{
    "league_id": 39,
    "season": 2024,
    "db_league_id": 1
  }'
```

## 🏆 Popular League IDs

Here are some popular league IDs from API-Football:

| League | Country | ID |
|--------|---------|-----|
| Premier League | England | 39 |
| La Liga | Spain | 140 |
| Serie A | Italy | 135 |
| Bundesliga | Germany | 78 |
| Ligue 1 | France | 61 |
| Champions League | Europe | 2 |
| Europa League | Europe | 3 |
| World Cup | International | 1 |

For a complete list, visit the API-Football documentation.

## 📊 Import Workflow Example

Here's a complete workflow to import Premier League data:

### 1. Import Teams First
```bash
curl -X POST http://localhost:8000/api/external/fetch-teams \
  -H "Content-Type: application/json" \
  -d '{
    "league_id": 39,
    "season": 2024,
    "db_league_id": 1
  }'
```

### 2. Then Import Matches
```bash
curl -X POST http://localhost:8000/api/external/fetch-matches \
  -H "Content-Type: application/json" \
  -d '{
    "league_id": 39,
    "season": 2024,
    "db_league_id": 1
  }'
```

### 3. View the Results
```bash
# Check imported teams
curl http://localhost:8000/api/teams

# Check imported matches
curl http://localhost:8000/api/matches
```

## ⚙️ Advanced Configuration

### Rate Limiting

The free tier has 500 requests/day. To avoid hitting limits:

1. Import data in batches
2. Cache responses when possible
3. Only import what you need
4. Use the pre-seeded sample data for development

### Custom Import Logic

You can modify the import logic in:
```
backend/app/Http/Controllers/ApiFootballController.php
```

The controller handles:
- API authentication
- Data transformation
- Database insertion
- Error handling

### Updating Existing Data

The import endpoints use `updateOrCreate()`, which means:
- New data is inserted
- Existing data is updated
- No duplicates are created

## 🔄 Keeping Data Fresh

To keep your data up-to-date:

### Option 1: Manual Updates
Run the import commands periodically to refresh data.

### Option 2: Scheduled Tasks (Future Enhancement)
You can set up Laravel scheduled tasks to automatically import data:

```php
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Update matches daily
    $schedule->call(function () {
        // Your import logic here
    })->daily();
}
```

## ❓ Troubleshooting

### "API key not configured" error
- Make sure `FOOTBALL_API_KEY` is set in `backend/.env`
- Restart the Laravel server after adding the key

### "Failed to fetch data" error
- Check your internet connection
- Verify your API key is valid
- Check if you've hit the rate limit (500/day)
- Ensure the league ID and season are valid

### "Teams not found" error when importing matches
- Import teams before importing matches
- Make sure the league_id matches between teams and matches
- Verify teams were successfully imported

### Rate limit exceeded
- Free tier: 500 requests/day
- Wait 24 hours or upgrade to a paid plan
- Use sample data for development

## 📚 Additional Resources

- [API-Football Documentation](https://www.api-football.com/documentation-v3)
- [RapidAPI Dashboard](https://rapidapi.com/developer/dashboard)
- [API-Football Endpoints](https://rapidapi.com/api-sports/api/api-football)

## 💡 Tips

1. **Start Small**: Import one league at a time to avoid rate limits
2. **Use Sample Data**: The seeded data is perfect for development
3. **Plan Your Imports**: 500 requests can cover several leagues if planned well
4. **Monitor Usage**: Check your RapidAPI dashboard for usage statistics
5. **Handle Errors**: The API includes error handling, but always check responses

## 🎉 You're Ready!

You can now import real soccer data into your Koora platform. Start with a small league and expand as needed!
