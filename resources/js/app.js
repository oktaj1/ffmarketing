import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';


// Start the Inertia progress bar
InertiaProgress.init();

createInertiaApp({
    resolve: name => {
        // Define correct paths for each page
        if (name.includes('Subscribers')) {
            return import(`./Pages/Subscribers/${name.split('/').pop()}.vue`);
        } else if (name.includes('Channels')) {
            return import(`./Pages/${name.split('/').pop()}.vue`);
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
