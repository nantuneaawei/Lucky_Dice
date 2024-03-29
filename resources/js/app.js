import { createApp } from 'vue'
import './bootstrap'
import Roulette from './components/Roulette.vue'

const app = createApp({})
app.component('roulette', Roulette)

app.mount('#app')