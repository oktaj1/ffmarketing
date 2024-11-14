<template>
  <div class="auth-container">
    <form class="auth-form" @submit.prevent="submitForm">
      <h2>Register</h2>
      <div class="form-group">
        <label for="name">Name</label>
        <input 
          type="text" 
          id="name" 
          v-model="form.name" 
          class="auth-input" 
          required 
        />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="form.email" 
          class="auth-input" 
          required 
        />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input 
          type="password" 
          id="password" 
          v-model="form.password" 
          class="auth-input" 
          required 
        />
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input 
          type="password" 
          id="password_confirmation" 
          v-model="form.password_confirmation" 
          class="auth-input" 
          required 
        />
      </div>
      <button type="submit" class="auth-button">Register</button>
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
      errors: {},
    };
  },
  methods: {
    submitForm() {
      this.$inertia.post('/register', this.form).catch((err) => {
        if (err.response && err.response.data.errors) {
          this.errors = err.response.data.errors;
        }
      });
    },
  },
};
</script>

<style scoped>
.auth-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f4f6f8;
}

.auth-form {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.auth-form h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
}

.form-group {
  margin-bottom: 1rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  color: #555;
  font-weight: bold;
}

.auth-input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.auth-input:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.auth-button {
  width: 100%;
  padding: 0.75rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.3s;
}

.auth-button:hover {
  background-color: #0056b3;
}
</style>
