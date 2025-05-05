import './bootstrap';
import '../css/app.css';



import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import Layout from './Layouts/Layout.vue'

createInertiaApp({
    // resolve options, resolve directory for view components 
    //tells inertia to look for vue components in the Pages dir

    //defaut title for all pages
    title: title => `UPme Onboard | ${title}`,

    resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]

    //default layout for all pages, using Layout.vue
    page.default.layout = page.default.layout || Layout;
    
    return page;
  },

  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue) // ZiggyVue is a package that allows you to use Ziggy routes in Vue components or in short proper routing
      .component('Head', Head) // global import for each page done in this way
      .component('Link', Link)
      .mount(el)
  },
  //progress bar for loading
  progress: {
    // The color of the progress bar...
    color: 'red',

    // Whether to include the default NProgress styles...
    includeCSS: true,

    // Whether the NProgress spinner will be shown...
    showSpinner: false
  }
})