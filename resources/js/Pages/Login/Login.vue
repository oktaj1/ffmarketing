<template>
  <form @submit.prevent="login">
    <input type="email" v-model="form.email" placeholder="Email" />
    <input type="password" v-model="form.password" placeholder="Password" />
    <button type="submit">Login</button>
  </form>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    login() {
      Inertia.post('/login', this.form).then(() => {
        // Optionally, you can add any logic you want here after successful login.
      });
    },
  },
};
</script>
