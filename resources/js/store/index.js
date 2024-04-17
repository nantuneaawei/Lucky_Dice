import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      player: null,
    };
  },
  mutations: {
    setPlayer(state, playerInfo) {
      state.player = playerInfo;
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
