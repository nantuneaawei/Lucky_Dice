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
    },
  },
});

export default store;
