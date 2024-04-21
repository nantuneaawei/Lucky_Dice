import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      player: null,
      isLoggedIn: false,
    };
  },
  mutations: {
    setPlayer(state, playerInfo) {
      state.player = playerInfo;
    },
    setLoggedIn(state, value) {
      state.isLoggedIn = value;
    },
  },
  actions: {
    loginSuccess({ commit }, playerInfo) {
      commit('setPlayer', playerInfo);
      commit('setLoggedIn', true);
    },
  },
});


export default store;
