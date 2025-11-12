<template>
  <div id="app">
    <nav class="navbar">
      <div class="container">
        <router-link to="/" class="logo">⚽ Koora</router-link>
        <div class="nav-links">
          <router-link to="/">Home</router-link>
          <router-link to="/matches/live">Live</router-link>
          <router-link to="/matches/upcoming">Upcoming</router-link>
          <router-link to="/matches/results">Results</router-link>
          <router-link to="/news">News</router-link>
          <router-link to="/api-info">API</router-link>
        </div>
      </div>
    </nav>
    <router-view />
    <footer class="footer">
      <div class="container">
        <p>&copy; 2024 Koora - Your Soccer Platform</p>
      </div>
    </footer>
  </div>
</template>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  background: #f5f5f5;
}

#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.navbar {
  background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
  color: white;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.navbar .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar .logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: white;
  text-decoration: none;
}

.nav-links {
  display: flex;
  gap: 2rem;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  transition: opacity 0.2s;
}

.nav-links a:hover,
.nav-links a.router-link-active {
  opacity: 0.8;
  border-bottom: 2px solid white;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 2rem;
}

main {
  flex: 1;
}

.footer {
  background: #2c3e50;
  color: white;
  padding: 2rem 0;
  margin-top: 3rem;
  text-align: center;
}

@media (max-width: 768px) {
  .navbar .container {
    flex-direction: column;
    gap: 1rem;
  }
  
  .nav-links {
    gap: 1rem;
    flex-wrap: wrap;
    justify-content: center;
  }
  
  .nav-links a {
    font-size: 0.9rem;
  }
}
</style>
