import {createApp} from 'vue'

require('./bootstrap')
import App from './App.vue'
import axios from 'axios'
import router from './router'
import store from './state/store.js'

const app = createApp(App)
app.config.globalProperties.$axios = axios;
app.use(router)
app.use(store)

store.dispatch('initializeAuth');

app.mount('#app')
