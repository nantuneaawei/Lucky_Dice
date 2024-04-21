import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      isLoggedIn: false,
    };
  },
  mutations: {
    setLoggedIn(state, value) {
      state.isLoggedIn = value;
    },
  },
  actions: {
    loginSuccess({ commit }) {
      commit('setLoggedIn', true);
    },
  },
});

export default store;
