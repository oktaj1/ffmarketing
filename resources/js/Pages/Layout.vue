<template>
    <div>
        <nav>
            <router-link :to="{ name: 'register' }">Sign Up</router-link>
            <!-- Add other navigation links as needed -->
        </nav>
        <slot></slot>
    </div>
</template>
