<template>
  <div class="container">
    <div class="button-container">
      <button @click="navigateTo('subscribers')">Subscribers</button>
      <button @click="navigateTo('channels')">Channels</button>
      <button @click="navigateTo('campaigns')">Campaigns</button>
      <button @click="navigateTo('settings')">Settings</button>
      <button @click="logout">Logout</button>
    </div>
    <h1>Subscribers</h1>

    <button class="button" @click="openCreateModal">Create New Subscriber</button>

    <!-- Filter Section -->
    <div class="filter-section">
      <label>Filter by Channel:</label>
      <select v-model="filters.channel_id">
        <option value="">All Channels</option>
        <option v-for="channel in channels" :key="channel.id" :value="channel.id">
          {{ channel.source }}
        </option>
      </select>

      <label>Filter by Email:</label>
      <input type="text" v-model="filters.email" placeholder="Enter email" />

      <!-- <label>Created At (From):</label>
      <input type="date" v-model="filters.created_from" />

      <label>Created At (To):</label>
      <input type="date" v-model="filters.created_to" /> -->

      <!-- Search Button to trigger filter -->
      <button @click="applyFilters">Search</button>
      <button @click="resetFilters">Reset Filters</button>
    </div>

    <!-- Subscribers Table -->
    <table class="styled-table">
      <thead>
        <tr>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Channel</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Avatar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="subscriber in subscribers" :key="subscriber.id">
          <td>{{ subscriber.email }}</td>
          <td>{{ subscriber.first_name }}</td>
          <td>{{ subscriber.last_name }}</td>
          <td>{{ subscriber.channel ? subscriber.channel.source : 'No Channel' }}</td>
          <td>{{ subscriber.phone_number }}</td>
          <td>{{ subscriber.address }}</td>
          <td><img :src="subscriber.avatar_image" alt="Avatar" class="avatar-img" /></td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for creating a new subscriber -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>Create New Subscriber</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label>Email:</label>
            <input type="email" v-model="formData.email" required />
          </div>
          <div class="form-group">
            <label>First Name:</label>
            <input type="text" v-model="formData.first_name" required />
          </div>
          <div class="form-group">
            <label>Last Name:</label>
            <input type="text" v-model="formData.last_name" required />
          </div>
          <div class="form-group">
            <label>Channel:</label>
            <select v-model="formData.channel_id" required>
              <option v-for="channel in channels" :value="channel.id" :key="channel.id">
                {{ channel.source }}
              </option>
            </select>
          </div>
          <button type="submit" class="submit-button" :disabled="isLoading">
            <span v-if="isLoading">Loading...</span>
            <span v-else>Create</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { debounce } from "lodash";
export default {
  props: {
    subscribers: Array,
    channels: Array,
  },
  data() {
    return {
      showModal: false,
      isLoading: false,
      formData: {
        email: '',
        first_name: '',
        last_name: '',
        channel_id: null,
      },
      filters: {
        channel_id: '',
        email: '',
        created_from: '',
        created_to: '',
      },
    };
  },
  methods: {
    openCreateModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    resetForm() {
      this.formData = {
        email: '',
        first_name: '',
        last_name: '',
        channel_id: null,
      };
    },
    applyFilters() {
      this.$inertia.get('/subscribers', { ...this.filters });
    },
    resetFilters() {
      this.filters = { channel_id: "", email: "", created_from: "", created_to: "" };
      this.applyFilters();
    },
    async handleSubmit() {
      this.isLoading = true;
      await this.$inertia.post('/subscribers', this.formData);
      this.isLoading = false;
      this.closeModal();
    },
    async deleteSubscriber(id) {
      if (confirm('Are you sure you want to delete this subscriber?')) {
        this.isLoading = true;
        await this.$inertia.delete(`/subscribers/${id}`);
        this.isLoading = false;
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2rem;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
  transition: background-color 0.3s;
}

.button:hover {
  background-color: #0056b3;
}

/* Additional styling omitted for brevity */
</style>


<style scoped>
.container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  font-family: Arial, sans-serif;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 2rem;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px 15px;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px;
  transition: background-color 0.3s;
}

.button:hover {
  background-color: #0056b3;
}

.styled-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.styled-table th,
.styled-table td {
  border: 1px solid #ddd;
  padding: 12px;
  text-align: left;
}

.styled-table th {
  background-color: #007bff;
  color: white;
}

.styled-table tr:hover {
  background-color: #f1f1f1;
}

.delete-button {
  background-color: #dc3545;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
}

.delete-button:hover {
  background-color: #c82333;
}

/* Modal styles */
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  margin: 15% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
}

.form-group {
  margin-bottom: 15px;
}

.button-container {
  margin-top: 20px;
}

button {
  margin: 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #007BFF;
  color: white;
  cursor: pointer;
}

.avatar-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

button:hover {
  background-color: #0056b3;
}

label {
  display: block;
  margin-bottom: 5px;
}

input,
select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.submit-button {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

.submit-button:hover {
  background-color: #218838;
}
</style>