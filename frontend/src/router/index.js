import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import MatchesView from '../views/MatchesView.vue';
import NewsView from '../views/NewsView.vue';
import ApiInfoView from '../views/ApiInfoView.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/matches',
    name: 'matches',
    component: MatchesView,
    props: { type: 'all' }
  },
  {
    path: '/matches/live',
    name: 'live-matches',
    component: MatchesView,
    props: { type: 'live' }
  },
  {
    path: '/matches/upcoming',
    name: 'upcoming-matches',
    component: MatchesView,
    props: { type: 'upcoming' }
  },
  {
    path: '/matches/results',
    name: 'results',
    component: MatchesView,
    props: { type: 'results' }
  },
  {
    path: '/news',
    name: 'news',
    component: NewsView
  },
  {
    path: '/api-info',
    name: 'api-info',
    component: ApiInfoView
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

export default router;
