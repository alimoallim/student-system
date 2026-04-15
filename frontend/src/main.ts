import { createApp } from 'vue'
import App from './App.vue'
import router from './router'   // ✅ IMPORTANT
import './style.css'

createApp(App)
  .use(router)                  // ✅ IMPORTANT
  .mount('#app')