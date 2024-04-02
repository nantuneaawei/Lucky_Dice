import './bootstrap';
import { createApp } from 'vue';
import RouletteBettingArea from './components/RouletteBetArea.vue';
import { placeBet } from './bet';

const app = createApp({});
app.component('roulette-betting-area', RouletteBettingArea);

app.mount('#app');

const betButton = document.querySelector('#betButton');
betButton.addEventListener('click', () => {
  const type = 'number';
  const value = 10;
  const amount = 100;
  placeBet(type, value, amount)
    .then(data => {
      console.log('Bet placed successfully:', data);
    })
    .catch(error => {
      console.error('Error placing bet:', error);
    });
});
