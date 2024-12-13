import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Notifications from '@kyvg/vue3-notification'

createInertiaApp({
    resolve: name => {
        if (name.startsWith('EmailTemplates/')) {
            const pageName = name.replace('EmailTemplates/', '');
            switch (pageName) {
                case 'Create':
                    return import('./Pages/EmailTemplates/Create.vue');
                case 'Edit':
                    return import('./Pages/EmailTemplates/Edit.vue');
                case 'Show':
                    return import('./Pages/EmailTemplates/Show.vue');
                default:
                    return import(`./Pages/EmailTemplates/${pageName}.vue`);
            }
        } else if (name === 'Dashboard') {
            return import('./Pages/dashboardlayout.vue');
        } else if (name === 'Subscribers') {
            return import('./Pages/Subscribers/Index.vue');
        } else if (name.startsWith('Subscribers/')) {
            const pageName = name.replace('Subscribers/', '');
            return import(`./Pages/Subscribers/${pageName}.vue`);
        } else if (name.startsWith('Channels/')) {
            return import(`./Pages/Channels/${name.replace('Channels/', '')}.vue`);
        } else if (name.startsWith('Campaigns/')) {
            return import(`./Pages/Campaigns/${name.replace('Campaigns/', '')}.vue`);
        } else if (name === 'Login') {
            return import('./Pages/Login/Login.vue');
        } else if (name === 'Signup' || name === 'Auth/Register') {
            return import('./Pages/Auth/Register.vue');
        } else if (name.startsWith('Settings/')) {
            const pageName = name.replace('Settings/', '');
            return import(`./Pages/Settings/${pageName}.vue`);
        } else if (name === 'Settings') {
            return import('./Pages/Settings/Index.vue');
        } else {
            return import(`./Pages/${name}.vue`);
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(Notifications)
            .mount(el)
    },
});

// Initialize the Inertia.js progress bar
InertiaProgress.init({
    color: '#29d',   // Change the progress bar color
    showSpinner: true // Show the spinner when loading
});
