<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name</label>
        <input type="text" id="name" v-model="form.name" required />
      </div>

      <div>
        <label for="email">Email</label>
        <input type="email" id="email" v-model="form.email" required />
      </div>

      <div>
        <label for="password">Password</label>
        <input type="password" id="password" v-model="form.password" required />
      </div>

      <div>
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" id="password_confirmation" v-model="form.password_confirmation" required />
      </div>

      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: {}  // For capturing validation errors
    };
  },
  methods: {
    submitForm() {
      this.$inertia.post('/register', this.form)
        .then(() => {
          // Optionally redirect on success, show a success message, or redirect to login
          this.$inertia.visit('/login'); // Redirect to login page after registration (optional)
        })
        .catch((err) => {
          // Capture and show validation errors
          if (err.response && err.response.data.errors) {
            this.errors = err.response.data.errors;
          } else {
            console.error('Error during registration', err);
          }
        });
    },
  },
};
</script>