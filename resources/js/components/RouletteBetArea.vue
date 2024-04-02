<template>
  <div class="betting-area">
    <h2>輪盤遊戲下注區</h2>
    <div class="number-bets">
      <h3>Numbers</h3>
      <div class="numbers">
        <button v-for="num in numbers" :key="num" @click="placeBet('number', num)">
          {{ num }}
        </button>
      </div>
    </div>
    <div class="color-bets">
      <h3>Color</h3>
      <button @click="placeBet('color', 'red')">Red</button>
      <button @click="placeBet('color', 'black')">Black</button>
    </div>
    <div class="parity-bets">
      <h3>Odd/Even</h3>
      <button @click="placeBet('parity', 'odd')">Odd</button>
      <button @click="placeBet('parity', 'even')">Even</button>
    </div>
    <div class="bet-amount">
      <label for="amount">Bet Amount:</label>
      <input type="number" id="amount" v-model="betAmount" min="100" step="100" />
    </div>
    <button @click="placeBet('amount')">開始遊戲</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      numbers: Array.from({ length: 37 }, (_, index) => index),
      betAmount: 0,
    };
  },
  methods: {
    placeBet(type, value = null) {
      console.log('Placing bet:', type, value, 'Amount:', this.betAmount);
    },
  },
};
</script>

<style scoped>
.betting-area {
  margin: 20px;
}

.bet-options {
  display: flex;
  justify-content: space-around;
  margin-bottom: 20px;
}

.numbers {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}

button {
  padding: 5px 10px;
  margin: 5px;
}
</style>
