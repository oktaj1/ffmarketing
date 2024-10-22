import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    resolve: name => {
        if (name.startsWith('Subscribers/')) {
            return import(`./Pages/Subscribers/${name.replace('Subscribers/', '')}.vue`);
        } else if (name.startsWith('Channels/')) {
            return import(`./Pages/Channels/${name.replace('Channels/', '')}.vue`);
        } else if (name.startsWith('Campaigns/')) {  // Ensure "Campaigns" matches the folder name
            return import(`./Pages/Campaigns/${name.replace('Campaigns/', '')}.vue`);
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

