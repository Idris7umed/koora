<template>
  <div class="matches">
    <h1>{{ title }}</h1>

    <div class="filters">
      <select v-model="selectedLeague" @change="fetchMatches">
        <option value="">All Leagues</option>
        <option v-for="league in leagues" :key="league.id" :value="league.id">
          {{ league.name }}
        </option>
      </select>
    </div>

    <div v-if="loading" class="loading">Loading matches...</div>
    <div v-else-if="matches.length === 0" class="no-matches">
      No matches found
    </div>
    <div v-else class="matches-list">
      <div v-for="match in matches" :key="match.id" class="match-card">
        <div class="match-header">
          <span class="league-name">{{ match.league?.name }}</span>
          <span :class="['status', match.status]">{{ formatStatus(match.status) }}</span>
        </div>
        <div class="match-body">
          <div class="team home">
            <img :src="match.home_team?.logo || 'https://via.placeholder.com/50'" :alt="match.home_team?.name" />
            <span class="team-name">{{ match.home_team?.name }}</span>
          </div>
          <div class="score">
            <span class="score-value">{{ match.home_score ?? '-' }}</span>
            <span class="separator">:</span>
            <span class="score-value">{{ match.away_score ?? '-' }}</span>
          </div>
          <div class="team away">
            <img :src="match.away_team?.logo || 'https://via.placeholder.com/50'" :alt="match.away_team?.name" />
            <span class="team-name">{{ match.away_team?.name }}</span>
          </div>
        </div>
        <div class="match-footer">
          <span class="date">{{ formatDate(match.match_date) }}</span>
          <span class="venue">{{ match.venue }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: 'MatchesView',
  props: {
    type: {
      type: String,
      default: 'all'
    }
  },
  data() {
    return {
      matches: [],
      leagues: [],
      selectedLeague: '',
      loading: true
    };
  },
  computed: {
    title() {
      const titles = {
        live: '🔴 Live Matches',
        upcoming: '📅 Upcoming Matches',
        results: '📊 Match Results',
        all: '⚽ All Matches'
      };
      return titles[this.type] || titles.all;
    }
  },
  mounted() {
    this.fetchLeagues();
    this.fetchMatches();
  },
  methods: {
    async fetchLeagues() {
      try {
        const response = await api.getLeagues();
        this.leagues = response.data;
      } catch (error) {
        console.error('Error fetching leagues:', error);
      }
    },
    async fetchMatches() {
      this.loading = true;
      try {
        let response;
        const params = this.selectedLeague ? { league_id: this.selectedLeague } : {};
        
        switch (this.type) {
          case 'live':
            response = await api.getLiveMatches();
            break;
          case 'upcoming':
            response = await api.getUpcomingMatches();
            break;
          case 'results':
            response = await api.getResults();
            break;
          default:
            response = await api.getMatches(params);
        }
        
        this.matches = response.data;
      } catch (error) {
        console.error('Error fetching matches:', error);
      } finally {
        this.loading = false;
      }
    },
    formatStatus(status) {
      const statusMap = {
        upcoming: 'Upcoming',
        live: 'LIVE',
        finished: 'Finished'
      };
      return statusMap[status] || status;
    },
    formatDate(date) {
      return new Date(date).toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
};
</script>

<style scoped>
.matches {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

h1 {
  margin-bottom: 2rem;
}

.filters {
  margin-bottom: 2rem;
}

.filters select {
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
  min-width: 200px;
}

.loading, .no-matches {
  text-align: center;
  padding: 3rem;
  color: #666;
}

.matches-list {
  display: grid;
  gap: 1.5rem;
}

.match-card {
  background: white;
  border-radius: 10px;
  padding: 1.5rem;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.match-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #eee;
}

.league-name {
  font-weight: bold;
  color: #333;
}

.status {
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: bold;
}

.status.live {
  background: #ff4444;
  color: white;
  animation: pulse 2s infinite;
}

.status.upcoming {
  background: #ffa500;
  color: white;
}

.status.finished {
  background: #28a745;
  color: white;
}

@keyframes pulse {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.7; }
}

.match-body {
  display: grid;
  grid-template-columns: 1fr auto 1fr;
  gap: 2rem;
  align-items: center;
  margin: 1.5rem 0;
}

.team {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.5rem;
}

.team img {
  width: 50px;
  height: 50px;
  object-fit: contain;
}

.team-name {
  font-weight: bold;
  text-align: center;
}

.score {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 2rem;
  font-weight: bold;
}

.score-value {
  min-width: 40px;
  text-align: center;
}

.match-footer {
  display: flex;
  justify-content: space-between;
  padding-top: 0.75rem;
  border-top: 1px solid #eee;
  color: #666;
  font-size: 0.875rem;
}

@media (max-width: 768px) {
  .match-body {
    gap: 1rem;
  }
  
  .team img {
    width: 40px;
    height: 40px;
  }
  
  .team-name {
    font-size: 0.875rem;
  }
  
  .score {
    font-size: 1.5rem;
  }
}
</style>
