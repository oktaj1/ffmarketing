import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    resolve: name => {
        if (name === 'Dashboard') {
            return import(`./Pages/dashboardlayout.vue`); // Updated path for DashboardLayout
        } else if (name === 'Subscribers') {
            return import(`./Pages/Subscribers/Index.vue`);
        } else if (name.startsWith('Subscribers/')) {
            return import(`./Pages/Subscribers/${name.replace('Subscribers/', '')}.vue`);
        } else if (name.startsWith('Channels/')) {
            return import(`./Pages/Channels/${name.replace('Channels/', '')}.vue`);
        } else if (name.startsWith('Campaigns/')) {
            return import(`./Pages/Campaigns/${name.replace('Campaigns/', '')}.vue`);
        } else if (name.startsWith('EmailTemplates/')) { // New condition for EmailTemplates
            return import(`./Pages/EmailTemplates/${name.replace('EmailTemplates/', '')}.vue`);
        } else if (name === 'Login') {
            return import(`./Pages/Login/Login.vue`);
        } else if (name === 'Signup' || name === 'Auth/Register') {
            return import(`./Pages/Auth/Register.vue`); // Adjusted path
        } else {
            return import(`./Pages/${name}.vue`);
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});

InertiaProgress.init();

