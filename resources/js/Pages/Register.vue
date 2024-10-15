<template>
  <div class="register-container" :class="{ shake: shakeForm }">
    <h1 class="register-title">Register</h1>
    <form @submit.prevent="register" class="register-form">
      <input v-model="form.first_name" type="text" placeholder="First Name" required class="form-input" />
      <input v-model="form.last_name" type="text" placeholder="Last Name" required class="form-input" />
      <input v-model="form.email" type="email" placeholder="Email" required class="form-input" />
      <input v-model="form.channel" type="text" placeholder="Channel" required class="form-input" />
      <input v-model="form.prompt" type="text" placeholder="Prompt (optional)" class="form-input" />
      <input v-model="form.phone_number" type="text" placeholder="Phone Number" class="form-input" />
      <button type="submit" class="register-button">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        email: '',
        channel: '',
        prompt: '',
        phone_number: ''
      },
      shakeForm: false // State for shake effect
    };
  },
  methods: {
    register() {
      this.$inertia.post('/register', this.form)
        .then(() => {
          // Reset shake effect on successful registration
          this.shakeForm = false;
        })
        .catch((error) => {
          // If there's an error, shake the form
          this.shakeForm = true;
          setTimeout(() => {
            this.shakeForm = false; // Reset after a short duration
          }, 1000);
          console.error(error);
        });
    }
  }
};
</script>

<style scoped>
.register-container {
  background-color: #f0f0f0; /* Light grey background */
  border-radius: 8px;
  padding: 20px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  max-width: 400px;
  margin: auto;
  transition: transform 0.3s; /* Smooth transitions for shake effect */
}

.register-title {
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-bottom: 20px;
  color: #333; /* Darker text for better contrast */
}

.register-form {
  display: flex;
  flex-direction: column;
}

.form-input {
  border: 1px solid #ccc; /* Light grey border */
  border-radius: 4px;
  padding: 10px;
  margin-bottom: 15px;
  font-size: 16px;
  transition: border-color 0.3s, box-shadow 0.3s; /* Added box-shadow transition */
}

.form-input:focus {
  border-color: #000; /* Black border on focus */
  outline: none;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); /* Shadow on focus */
}

.register-button {
  background-color: #000; /* Black background */
  color: #fff; /* White text */
  border: none;
  border-radius: 4px;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.register-button:hover {
  background-color: #333; /* Darker shade on hover */
}

/* Shake effect */
.shake {
  animation: shake 0.5s ease-in-out; /* Shake animation */
}

@keyframes shake {
  0% { transform: translate(0); }
  25% { transform: translate(-5px); }
  50% { transform: translate(5px); }
  75% { transform: translate(-5px); }
  100% { transform: translate(0); }
}
</style>
