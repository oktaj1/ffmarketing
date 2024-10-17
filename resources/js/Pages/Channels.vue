<template>
  <div class="container">
            <div class="button-container">
            <button @click="navigateTo('subscribers')">Subscribers</button>
            <button @click="navigateTo('channels')">Channels</button>
            <button @click="navigateTo('campaigns')">Campaigns</button>
            <button @click="navigateTo('settings')">Settings</button>
            <button @click="logout">Logout</button>
        </div>
    <h1>Channels</h1>
    <button class="button" @click="openCreateModal">Create New Channel</button>

    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>SMS</th>
          <th>Social Media</th>
          <th>Source</th>
          <th>Subscribers</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="channel in channels" :key="channel.id">
          <td>{{ channel.id }}</td>
          <td>{{ channel.email ? 'Yes' : 'No' }}</td>
          <td>{{ channel.sms ? 'Yes' : 'No' }}</td>
          <td>{{ channel.social_media ? 'Yes' : 'No' }}</td>
          <td>{{ channel.source }}</td>
          <td>{{ channel.subscriber_count }}</td>
          <td>
            <button class="edit-button" @click="editChannel(channel.id)">Edit</button>
            <button class="delete-button" @click="deleteChannel(channel.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for creating or editing a channel -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ editMode ? 'Edit Channel' : 'Create Channel' }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label>Email:</label>
            <input type="checkbox" v-model="channelData.email" />
          </div>
          <div class="form-group">
            <label>SMS:</label>
            <input type="checkbox" v-model="channelData.sms" />
          </div>
          <div class="form-group">
            <label>Social Media:</label>
            <input type="checkbox" v-model="channelData.social_media" />
          </div>
          <div class="form-group">
            <label>Source:</label>
            <input type="text" v-model="channelData.source" required />
          </div>
          <button type="submit" class="submit-button">{{ editMode ? 'Update' : 'Create' }}</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    channels: Array, // Receive channels from props, including subscriber_count
  },
  data() {
    return {
      showModal: false,
      editMode: false,
      channelData: {
        email: false,
        sms: false,
        social_media: false,
        source: '',
      },
    };
  },
  methods: {
    openCreateModal() {
      this.editMode = false;
      this.showModal = true;
      this.resetForm();
    },
    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    resetForm() {
      this.channelData = { email: false, sms: false, social_media: false, source: '' };
    },
    editChannel(id) {
      this.editMode = true;
      const channel = this.channels.find(c => c.id === id);
      this.channelData = { ...channel };
      this.showModal = true;
    },
    async deleteChannel(id) {
      if (confirm('Are you sure you want to delete this channel?')) {
        await this.$inertia.delete(`/channels/${id}`);
      }
    },
    async handleSubmit() {
      if (this.editMode) {
        await this.$inertia.put(`/channels/${this.channelData.id}`, this.channelData);
      } else {
        await this.$inertia.post('/channels', this.channelData);
      }
      this.closeModal();
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

.edit-button,
.delete-button {
  padding: 8px 12px;
  border: none;
  border-radius: 5px;
  color: white;
  cursor: pointer;
  margin-right: 5px;
}

.edit-button {
  background-color: #28a745;
}

.delete-button {
  background-color: #dc3545;
}

.edit-button:hover {
  background-color: #218838;
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

button:hover {
    background-color: #0056b3;
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

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

input[type="checkbox"] {
  margin-left: 10px;
}

.submit-button {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 10px;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
}

.submit-button:hover {
  background-color: #0056b3;
}
</style>
