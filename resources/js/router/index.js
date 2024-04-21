import { createRouter, createWebHistory } from 'vue-router';
import store from '../store';
import RouletteBettingArea from '../components/RouletteBetArea.vue';
import RegisterForm from '../components/RegisterForm.vue';
import LoginForm from '../components/LoginForm.vue';

const routes = [
  { path: '/roulette', component: RouletteBettingArea, meta: { requiresAuth: true } },
  { path: '/register', component: RegisterForm },
  { path: '/login', component: LoginForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!isLoggedIn()) {
      next({ name: 'Login' });
      return;
    }
  }

  next();
});


function isLoggedIn() {
  return store.state.isLoggedIn;
}

export default router;
