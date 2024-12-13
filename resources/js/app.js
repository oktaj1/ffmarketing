import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    resolve: name => {
        if (name.startsWith('EmailTemplates/')) {
            // Use a cleaner fallback for EmailTemplates pages
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
            // Import the Index.vue for the Subscribers page
            return import('./Pages/Subscribers/Index.vue');
        } else if (name.startsWith('Subscribers/')) {
            // Handle any other Subscribers sub-pages dynamically
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
            // Handle any Settings sub-pages dynamically
            const pageName = name.replace('Settings/', '');
            return import(`./Pages/Settings/${pageName}.vue`);
        } else if (name === 'Settings') {
            // Import the Index.vue for the Settings page
            return import('./Pages/Settings/Index.vue');
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

// Initialize the Inertia.js progress bar
InertiaProgress.init();
