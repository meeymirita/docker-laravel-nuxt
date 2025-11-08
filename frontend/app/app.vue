<template>
  <div>
    <header class="site-header">
      <nav class="nav">
        <ul>
          <li><NuxtLink to="/">Main</NuxtLink></li>
          <li><NuxtLink to="/email">Email</NuxtLink></li>
          <li><NuxtLink to="/password">Password</NuxtLink></li>
          <li><NuxtLink to="/registration">Registration</NuxtLink></li>
        </ul>
      </nav>
    </header>

    <NuxtPage />
  </div>
</template>

<script setup>

</script>

<style scoped>
.site-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  padding: 15px 40px;
  display: flex;
  justify-content: center;
  align-items: center;

  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(20px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.3);

  z-index: 1000;
}

.nav ul {
  display: flex;
  gap: 40px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.nav a {
  color: white;
  text-decoration: none;
  font-family: "Turret Road";
  font-size: 20px;
  transition: all 0.3s ease;
}

.nav a:hover {
  border-bottom: 1px solid white;
  text-shadow: 0 0 5px white;
}

body {
  padding-top: 80px;
}
</style>