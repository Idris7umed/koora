<template>
  <div class="api-info">
    <h1>🔌 External API Integration</h1>
    
    <div v-if="loading" class="loading">Loading...</div>
    <div v-else class="info-content">
      <div class="status-card" :class="{ configured: apiInfo.api_configured }">
        <h2>API Status</h2>
        <p class="status">
          {{ apiInfo.api_configured ? '✅ Configured' : '⚠️ Not Configured' }}
        </p>
      </div>

      <div class="instructions-card">
        <h2>{{ apiInfo.message }}</h2>
        <ol>
          <li v-for="(step, index) in apiInfo.steps" :key="index">{{ step }}</li>
        </ol>
      </div>

      <div v-if="apiInfo.api_configured" class="actions-card">
        <h2>Import Data from External API</h2>
        <p>Click the buttons below to fetch real data from API-Football</p>
        
        <div class="action-buttons">
          <button @click="fetchLeagues" :disabled="fetchingLeagues" class="fetch-btn">
            {{ fetchingLeagues ? 'Fetching...' : 'Fetch Leagues' }}
          </button>
          
          <div class="fetch-group">
            <input v-model="leagueId" type="number" placeholder="League ID (e.g., 39)" />
            <input v-model="season" type="number" placeholder="Season (e.g., 2024)" />
            <input v-model="dbLeagueId" type="number" placeholder="DB League ID" />
            <button @click="fetchTeams" :disabled="fetchingTeams" class="fetch-btn">
              {{ fetchingTeams ? 'Fetching...' : 'Fetch Teams' }}
            </button>
          </div>
          
          <div class="fetch-group">
            <input v-model="leagueId" type="number" placeholder="League ID (e.g., 39)" />
            <input v-model="season" type="number" placeholder="Season (e.g., 2024)" />
            <input v-model="dbLeagueId" type="number" placeholder="DB League ID" />
            <button @click="fetchMatches" :disabled="fetchingMatches" class="fetch-btn">
              {{ fetchingMatches ? 'Fetching...' : 'Fetch Matches' }}
            </button>
          </div>
        </div>

        <div v-if="message" class="message" :class="messageType">
          {{ message }}
        </div>
      </div>

      <div class="endpoints-card">
        <h2>Available Endpoints</h2>
        <div class="endpoint" v-for="(description, endpoint) in apiInfo.endpoints" :key="endpoint">
          <code>{{ endpoint }}</code>
          <p>{{ description }}</p>
        </div>
      </div>

      <div class="note-card">
        <p><strong>Note:</strong> {{ apiInfo.note }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: 'ApiInfoView',
  data() {
    return {
      apiInfo: {},
      loading: true,
      fetchingLeagues: false,
      fetchingTeams: false,
      fetchingMatches: false,
      leagueId: 39,
      season: 2024,
      dbLeagueId: 1,
      message: '',
      messageType: 'success'
    };
  },
  mounted() {
    this.fetchApiInfo();
  },
  methods: {
    async fetchApiInfo() {
      try {
        const response = await api.getExternalApiInfo();
        this.apiInfo = response.data;
      } catch (error) {
        console.error('Error fetching API info:', error);
      } finally {
        this.loading = false;
      }
    },
    async fetchLeagues() {
      this.fetchingLeagues = true;
      this.message = '';
      try {
        const response = await api.fetchExternalLeagues();
        this.message = response.data.message;
        this.messageType = 'success';
      } catch (error) {
        this.message = error.response?.data?.error || 'Failed to fetch leagues';
        this.messageType = 'error';
      } finally {
        this.fetchingLeagues = false;
      }
    },
    async fetchTeams() {
      this.fetchingTeams = true;
      this.message = '';
      try {
        const response = await api.fetchExternalTeams({
          league_id: this.leagueId,
          season: this.season,
          db_league_id: this.dbLeagueId
        });
        this.message = response.data.message;
        this.messageType = 'success';
      } catch (error) {
        this.message = error.response?.data?.error || 'Failed to fetch teams';
        this.messageType = 'error';
      } finally {
        this.fetchingTeams = false;
      }
    },
    async fetchMatches() {
      this.fetchingMatches = true;
      this.message = '';
      try {
        const response = await api.fetchExternalMatches({
          league_id: this.leagueId,
          season: this.season,
          db_league_id: this.dbLeagueId
        });
        this.message = response.data.message;
        this.messageType = 'success';
      } catch (error) {
        this.message = error.response?.data?.error || 'Failed to fetch matches';
        this.messageType = 'error';
      } finally {
        this.fetchingMatches = false;
      }
    }
  }
};
</script>

<style scoped>
.api-info {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

h1 {
  margin-bottom: 2rem;
}

.loading {
  text-align: center;
  padding: 3rem;
  color: #666;
}

.info-content {
  display: grid;
  gap: 2rem;
}

.status-card, .instructions-card, .actions-card, .endpoints-card, .note-card {
  background: white;
  border-radius: 10px;
  padding: 2rem;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.status-card {
  border-left: 4px solid #ffa500;
}

.status-card.configured {
  border-left: 4px solid #28a745;
}

.status {
  font-size: 1.5rem;
  font-weight: bold;
}

.instructions-card ol {
  padding-left: 1.5rem;
}

.instructions-card li {
  margin-bottom: 0.5rem;
  line-height: 1.6;
}

.actions-card {
  border-left: 4px solid #007bff;
}

.action-buttons {
  display: grid;
  gap: 1.5rem;
  margin-top: 1.5rem;
}

.fetch-group {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.fetch-group input {
  flex: 1;
  min-width: 150px;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 1rem;
}

.fetch-btn {
  padding: 0.75rem 1.5rem;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}

.fetch-btn:hover:not(:disabled) {
  background: #0056b3;
}

.fetch-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.message {
  margin-top: 1rem;
  padding: 1rem;
  border-radius: 5px;
}

.message.success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.message.error {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.endpoint {
  margin-bottom: 1.5rem;
}

.endpoint code {
  display: block;
  background: #f4f4f4;
  padding: 0.75rem;
  border-radius: 5px;
  margin-bottom: 0.5rem;
  font-family: 'Courier New', monospace;
}

.endpoint p {
  color: #666;
}

.note-card {
  background: #fff3cd;
  border-left: 4px solid #ffc107;
}
</style>
