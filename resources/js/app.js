require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { InertiaProgress } from '@inertiajs/progress';

import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m.js';

const appName = process.env.APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = require.context('./Pages', true, /\.vue$/i);
        return pages(`./` + name.replace('.', '/') + '.vue').default;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ 
    color: '#4F46E5',
    showSpinner: true,
});