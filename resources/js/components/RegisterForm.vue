<template>
  <div>
    <h2>註冊帳號</h2>
    <form @submit.prevent="register">
      <div>
        <label for="username">名稱:</label>
        <input type="text" id="username" v-model="username" required>
      </div>
      <div>
        <label for="email">信箱:</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div>
        <label for="password">密碼:</label>
        <input type="password" id="password" v-model="password" required>
      </div>
      <button type="submit">註冊</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      email: '',
      password: '',
      errorMessage: '',
    };
  },
  methods: {
    register() {
      const registerData = {
        username: this.username,
        email: this.email,
        password: this.password,
      };
      axios.post('/api/register', registerData)
        .then(response => {
          console.log(response.data);
        })
        .catch(error => {
          this.errorMessage = 'Registration failed. Please try again.';
        });
    },
  },
};
</script>

<style>
.error {
  color: red;
}
</style>
