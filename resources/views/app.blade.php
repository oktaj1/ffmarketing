<template>
  <div class="register-form">
    <h1>Sign Up</h1>
    <form @submit.prevent="submit">
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="form.email" required />
      </div>
      <div>
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" v-model="form.first_name" />
      </div>
      <div>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" v-model="form.last_name" />
      </div>
      <div>
        <label for="channel">Channel:</label>
        <input type="text" id="channel" v-model="form.channel" required />
      </div>
      <div>
        <label for="prompt">Prompt:</label>
        <textarea id="prompt" v-model="form.prompt"></textarea>
      </div>
      <div>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" v-model="form.phone_number" />
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
  email: '',
  first_name: '',
  last_name: '',
  channel: '',
  prompt: '',
  phone_number: ''
})

const submit = () => {
  form.post(route('register'))
}
</script>

<style scoped>
.register-form {
  max-width: 500px;
  margin: 0 auto;
}

form {
  display: flex;
  flex-direction: column;
}

div {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input, textarea {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

button {
  padding: 10px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}
</style>