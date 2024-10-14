<template>
  <div>
    <h1>Register</h1>
    <form @submit.prevent="register">
      <input v-model="form.first_name" type="text" placeholder="First Name" required />
      <input v-model="form.last_name" type="text" placeholder="Last Name" required />
      <input v-model="form.email" type="email" placeholder="Email" required />
      <input v-model="form.channel" type="text" placeholder="Channel" required />
      <input v-model="form.prompt" type="text" placeholder="Prompt (optional)" />
      <input v-model="form.phone_number" type="text" placeholder="Phone Number" />
      <button type="submit">Register</button>
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
      }
    };
  },
  methods: {
    register() {
      this.$inertia.post('/register', this.form); // Send the form data via Inertia.js
    }
  }
};
</script>
