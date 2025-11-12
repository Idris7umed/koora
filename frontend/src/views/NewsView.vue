<template>
  <div class="news">
    <h1>📰 Latest Soccer News</h1>

    <div v-if="loading" class="loading">Loading news...</div>
    <div v-else class="news-list">
      <div v-for="item in news" :key="item.id" class="news-item">
        <img :src="item.image" :alt="item.title" class="news-image" />
        <div class="news-content">
          <h2>{{ item.title }}</h2>
          <p class="news-meta">
            <span v-if="item.author">By {{ item.author }}</span>
            <span>{{ formatDate(item.created_at) }}</span>
          </p>
          <p class="news-excerpt">{{ item.content.substring(0, 200) }}...</p>
          <router-link :to="`/news/${item.id}`" class="read-more-btn">Read Full Article →</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/services/api';

export default {
  name: 'NewsView',
  data() {
    return {
      news: [],
      loading: true
    };
  },
  mounted() {
    this.fetchNews();
  },
  methods: {
    async fetchNews() {
      try {
        const response = await api.getNews();
        this.news = response.data;
      } catch (error) {
        console.error('Error fetching news:', error);
      } finally {
        this.loading = false;
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    }
  }
};
</script>

<style scoped>
.news {
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

.news-list {
  display: grid;
  gap: 2rem;
}

.news-item {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 2rem;
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s;
}

.news-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.news-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.news-content {
  padding: 2rem;
  display: flex;
  flex-direction: column;
}

.news-content h2 {
  margin-bottom: 0.5rem;
  color: #333;
}

.news-meta {
  color: #666;
  font-size: 0.875rem;
  margin-bottom: 1rem;
  display: flex;
  gap: 1rem;
}

.news-excerpt {
  color: #666;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  flex-grow: 1;
}

.read-more-btn {
  align-self: flex-start;
  padding: 0.75rem 1.5rem;
  background: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background 0.2s;
}

.read-more-btn:hover {
  background: #0056b3;
}

@media (max-width: 768px) {
  .news-item {
    grid-template-columns: 1fr;
  }
  
  .news-image {
    height: 200px;
  }
}
</style>
