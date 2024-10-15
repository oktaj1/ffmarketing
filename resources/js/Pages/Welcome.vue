<template>
    <div class="welcome-container">
        <h1>Welcome to the Marketing Dashboard</h1>
        <p>Manage your subscribers, channels, campaigns, and settings from here.</p>

        <div class="button-container">
            <button @click="navigateTo('subscribers')">Subscribers</button>
            <button @click="navigateTo('channels')">Channels</button>
            <button @click="navigateTo('campaigns')">Campaigns</button>
            <button @click="navigateTo('settings')">Settings</button>
            <button @click="logout">Logout</button>
        </div>
    </div>
</template>

<script>
export default {
    methods: {
        navigateTo(page) {
            this.$inertia.visit(`/${page}`);
        },
        logout() {
            this.$inertia.post('/logout');
        }
    }
}
</script>

<style scoped>
.welcome-container {
    text-align: center;
    margin: 50px;
}

.button-container {
    margin-top: 20px;
}

button {
    margin: 10px;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: #007BFF;
    color: white;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
</style>
