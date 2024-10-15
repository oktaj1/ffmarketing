<template>
  <div>
    <nav>
      <ul>
        <li><Link :href="route('dashboard')">Dashboard</Link></li>
        <li><Link :href="route('subscribers.index')">Subscribers</Link></li>
        <li><Link :href="route('channels.index')">Channels</Link></li>
        <li><Link :href="route('campaigns.index')">Campaigns</Link></li>
        <li><Link :href="route('settings.index')">Settings</Link></li>
        <li><a href="#" @click.prevent="logout">Logout</a></li>
      </ul>
    </nav>
    <slot></slot>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$inertia.post(route('logout'));
    }
  }
};
</script>
