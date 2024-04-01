import './bootstrap';
import { createApp } from 'vue';
import RouletteBettingArea from './components/RouletteBetArea.vue';

const app = createApp({});
app.component('roulette-betting-area', RouletteBettingArea);

app.mount('#app');
