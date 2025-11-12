<template>
  <div class="home">
    <h1>⚽ Koora - Soccer Platform</h1>
    <p class="subtitle">Your source for soccer matches, results, and news</p>

    <div class="quick-links">
      <router-link to="/matches/live" class="quick-link live">
        <span class="icon">🔴</span>
        <span>Live Matches</span>
      </router-link>
      <router-link to="/matches/upcoming" class="quick-link">
        <span class="icon">📅</span>
        <span>Upcoming</span>
      </router-link>
      <router-link to="/matches/results" class="quick-link">
        <span class="icon">📊</span>
        <span>Results</span>
      </router-link>
      <router-link to="/news" class="quick-link">
        <span class="icon">📰</span>
        <span>News</span>
      </router-link>
    </div>

    <div class="featured-section">
      <h2>Latest News</h2>
      <div v-if="loading" class="loading">Loading...</div>
      <div v-else class="news-grid">
        <div v-for="item in latestNews" :key="item.id" class="news-card">
          <img :src="item.image" :alt="item.title" />
          <div class="news-content">
            <h3>{{ item.title }}</h3>
            <p>{{ truncate(item.content, 100) }}</p>
            <router-link :to="`/news/${item.id}`" class="read-more">Read More →</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: 'HomeView',
  data() {
    return {
      latestNews: [],
      loading: true
    };
  },
  mounted() {
    this.fetchLatestNews();
  },
  methods: {
    async fetchLatestNews() {
      try {
        const response = await api.getNews();
        this.latestNews = response.data.slice(0, 3);
      } catch (error) {
        console.error('Error fetching news:', error);
      } finally {
        this.loading = false;
      }
    },
    truncate(text, length) {
      return text.length > length ? text.substring(0, length) + '...' : text;
    }
  }
};
</script>

<style scoped>
.home {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

h1 {
  font-size: 2.5rem;
  margin-bottom: 0.5rem;
  text-align: center;
}

.subtitle {
  text-align: center;
  color: #666;
  margin-bottom: 2rem;
}

.quick-links {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;
  margin-bottom: 3rem;
}

.quick-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 1.5rem;
  background: white;
  border-radius: 10px;
  text-decoration: none;
  color: #333;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.quick-link:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.quick-link.live {
  background: linear-gradient(135deg, #ff4444 0%, #cc0000 100%);
  color: white;
}

.quick-link .icon {
  font-size: 2rem;
  margin-bottom: 0.5rem;
}

.featured-section h2 {
  margin-bottom: 1.5rem;
}

.news-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
}

.news-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.news-card:hover {
  transform: translateY(-5px);
}

.news-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.news-content {
  padding: 1.5rem;
}

.news-content h3 {
  margin-bottom: 0.5rem;
}

.news-content p {
  color: #666;
  margin-bottom: 1rem;
}

.read-more {
  color: #007bff;
  text-decoration: none;
  font-weight: bold;
}

.loading {
  text-align: center;
  padding: 2rem;
  color: #666;
}
</style>
