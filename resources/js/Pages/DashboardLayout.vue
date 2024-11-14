<template>
  <div class="dashboard-layout">
    <!-- Header Section -->
    <header class="dashboard-header">
      <h1>Dashboard</h1>
      <!-- Logout Button -->
      <form @submit.prevent="logout" method="POST">
        <button type="submit" class="logout-button">Logout</button>
      </form>
    </header>

    <!-- Sidebar Section -->
    <aside class="dashboard-sidebar">
      <nav>
        <ul>
          <li><a href="/dashboard">Home</a></li>
          <li><a href="/subscribers">Subscribers</a></li>
          <li><a href="/campaigns">Campaigns</a></li>
          <li><a href="/channels">Channels</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">
      <slot></slot>
    </main>
  </div>
</template>

<script>
export default {
  name: 'DashboardLayout',
  methods: {
    logout() {
      // Perform logout by submitting the form
      this.$inertia.post('/logout');
    },
  },
};
</script>

<style scoped>
.dashboard-layout {
  display: grid;
  grid-template-areas:
    "header header"
    "sidebar content";
  grid-template-columns: 250px 1fr;
  grid-template-rows: auto 1fr;
  min-height: 100vh;
}

.dashboard-header {
  grid-area: header;
  background-color: #f8f9fa;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dashboard-sidebar {
  grid-area: sidebar;
  background-color: #343a40;
  color: #fff;
  padding: 1rem;
}

.dashboard-sidebar ul {
  list-style: none;
  padding: 0;
}

.dashboard-sidebar ul li {
  margin-bottom: 1rem;
}

.dashboard-sidebar ul li a {
  color: #fff;
  text-decoration: none;
}

.dashboard-sidebar ul li a:hover {
  text-decoration: underline;
}

.dashboard-content {
  grid-area: content;
  padding: 2rem;
  background-color: #f1f3f5;
}

.logout-button {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  cursor: pointer;
  font-size: 1rem;
  border-radius: 4px;
}

.logout-button:hover {
  background-color: #c82333;
}
</style>
