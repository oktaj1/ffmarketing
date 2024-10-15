<template>
    <div class="container mt-5 text-center">
        <h1>Welcome to the Dashboard</h1>
        <p>This is your dashboard area. Please choose an option below:</p>
        <div class="mt-4">
            <inertia-link href="/subscribers" class="btn btn-primary">Subscribers</inertia-link>
            <inertia-link href="/channels" class="btn btn-primary">Channels</inertia-link>
            <inertia-link href="/campaigns" class="btn btn-primary">Campaigns</inertia-link>
            <inertia-link href="/settings" class="btn btn-primary">Settings</inertia-link>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    // Component logic goes here if needed
}
</script>

<style scoped>
/* Add any component-specific styles here */
</style>
