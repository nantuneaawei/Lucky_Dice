import './bootstrap';
import { createApp } from 'vue';
import RouletteBettingArea from './components/RouletteBetArea.vue';
import RegisterForm from './components/RegisterForm.vue';

const app = createApp({});
app.component('roulette-betting-area', RouletteBettingArea);
app.component('register-form', RegisterForm);

app.mount('#app');
