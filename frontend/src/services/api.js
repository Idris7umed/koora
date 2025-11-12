import axios from 'axios';

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

export default {
  // Leagues
  getLeagues() {
    return api.get('/leagues');
  },
  getLeague(id) {
    return api.get(`/leagues/${id}`);
  },

  // Teams
  getTeams() {
    return api.get('/teams');
  },
  getTeam(id) {
    return api.get(`/teams/${id}`);
  },

  // Matches
  getMatches(params = {}) {
    return api.get('/matches', { params });
  },
  getMatch(id) {
    return api.get(`/matches/${id}`);
  },
  getUpcomingMatches() {
    return api.get('/matches/upcoming/list');
  },
  getLiveMatches() {
    return api.get('/matches/live/list');
  },
  getResults() {
    return api.get('/matches/results/list');
  },

  // News
  getNews() {
    return api.get('/news');
  },
  getNewsItem(id) {
    return api.get(`/news/${id}`);
  },

  // External API
  getExternalApiInfo() {
    return api.get('/external/info');
  },
  fetchExternalLeagues() {
    return api.post('/external/fetch-leagues');
  },
  fetchExternalTeams(params) {
    return api.post('/external/fetch-teams', params);
  },
  fetchExternalMatches(params) {
    return api.post('/external/fetch-matches', params);
  }
};
