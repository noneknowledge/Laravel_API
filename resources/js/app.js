import './bootstrap'

import 'bootstrap/dist/css/bootstrap.min.css'
// // import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.js'
// import 'bootstrap/dist/js/bootstrap.min.js'
// import 'bootstrap'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { useToken } from './stores'

const [token, setToken] = useToken()

const app = createApp(App)

app.provide('token', [token, setToken])
app.use(router)
// app.use(bootstrap)

app.mount('#app')
