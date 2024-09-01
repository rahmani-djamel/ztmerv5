import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp,Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';


const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    progress: {
        // The delay after which the progress bar will appear, in milliseconds...
        delay: 250,
    
        // The color of the progress bar...
        color: '#29d',
    
        // Whether to include the default NProgress styles...
        includeCSS: true,
    
        // Whether the NProgress spinner will be shown...
        showSpinner: false,
      },
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component("Link", Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
