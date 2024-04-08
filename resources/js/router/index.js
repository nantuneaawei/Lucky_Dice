import { createRouter, createWebHistory } from 'vue-router';
import RouletteBettingArea from '../components/RouletteBetArea.vue';
import RegisterForm from '../components/RegisterForm.vue';
import LoginForm from '../components/LoginForm.vue';

const routes = [
  { path: '/roulette', component: RouletteBettingArea },
  { path: '/register', component: RegisterForm },
  { path: '/login', component: LoginForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
