import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    resolve: name => {
        if (name.startsWith('Subscribers/')) {
            return import(`./Pages/Subscribers/${name.replace('Subscribers/', '')}.vue`);
        } else if (name.startsWith('Channels/')) {
            return import(`./Pages/Channels/${name.replace('Channels/', '')}.vue`);  // Fix for Channels folder
        } else if (name.startsWith('Campaigns/')) {
            return import(`./Pages/Campaigns/${name.replace('Campaigns/', '')}.vue`);
        } else {
            return import(`./Pages/${name}.vue`);  // Default for single-level files like Index.vue
        }
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});