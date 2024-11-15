<template>
  <div class="dashboard-layout">
    <!-- Header Section -->
    <header class="dashboard-header">
      <h1>Channels</h1>
      <!-- Logout Button -->
      <form @submit.prevent="logout" method="POST">
        <button type="submit" class="logout-button">Logout</button>
      </form>
    </header>

    <!-- Sidebar Section -->
    <aside class="dashboard-sidebar">
      <nav>
        <ul>
          <li><a href="/subscribers">Subscribers</a></li>
          <li><a href="/channels">Channels</a></li>
          <li><a href="/campaigns">Campaigns</a></li>
          <li><a href="/email-templates">Email Templates</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">
      <div class="button-container">
        <button class="button" @click="openCreateModal">Create New Channel</button>
      </div>

      <table class="styled-table">
        <thead>
          <tr>
            <th>Email</th>
            <th>SMS</th>
            <th>Social Media</th>
            <th>Source</th>
            <th>Subscribers</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="channel in channels" :key="channel.ulid">
            <td>{{ channel.email ? 'Yes' : 'No' }}</td>
            <td>{{ channel.sms ? 'Yes' : 'No' }}</td>
            <td>{{ channel.social_media ? 'Yes' : 'No' }}</td>
            <td>{{ channel.source }}</td>
            <td>{{ channel.subscribers_count }}</td>
            <td>
              <button class="edit-button" @click="editChannel(channel.ulid)">Edit</button>
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
    </main>
  </div>
</template>

<script>
import { ref, defineComponent } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default defineComponent({
  props: {
    channels: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  setup(props) {
    const showModal = ref(false);
    const editMode = ref(false);
    const channelData = ref({
      id: null,
      ulid: null,
      email: false,
      sms: false,
      social_media: false,
      source: '',
    });

    const closeModal = () => {
      showModal.value = false;
      channelData.value = {
        id: null,
        ulid: null,
        email: false,
        sms: false,
        social_media: false,
        source: '',
      };
      editMode.value = false;
    };

    const openCreateModal = () => {
      editMode.value = false;
      channelData.value = {
        id: null,
        ulid: null,
        email: false,
        sms: false,
        social_media: false,
        source: '',
      };
      showModal.value = true;
    };

    const editChannel = (ulid) => {
      editMode.value = true;
      const channel = props.channels.find(c => c.ulid === ulid);

      if (channel) {
        channelData.value = {
          id: channel.id,
          ulid: channel.ulid,
          email: channel.email,
          sms: channel.sms,
          social_media: channel.social_media,
          source: channel.source,
        };
        showModal.value = true;
      } else {
        console.error('Channel not found for ULID:', ulid);
      }
    };

    const deleteChannel = async (ulid) => {
      if (confirm('Are you sure you want to delete this channel?')) {
        try {
          await Inertia.delete(`/channels/${ulid}`, {
            onSuccess: () => {
              closeModal();
            },
          });
        } catch (error) {
          console.error('Error deleting channel:', error);
          alert('There was an error deleting the channel. Please try again later.');
        }
      }
    };

    const handleSubmit = async () => {
      try {
        if (editMode.value) {
          const updateData = {
            email: channelData.value.email,
            sms: channelData.value.sms,
            social_media: channelData.value.social_media,
            source: channelData.value.source,
          };

          await Inertia.put(`/channels/${channelData.value.id}`, updateData);
        } else {
          const createData = {
            email: channelData.value.email,
            sms: channelData.value.sms,
            social_media: channelData.value.social_media,
            source: channelData.value.source,
          };

          await Inertia.post('/channels', createData);
        }
        closeModal();
      } catch (error) {
        console.error('Error submitting form:', error);
      }
    };

    return {
      showModal,
      editMode,
      channelData,
      openCreateModal,
      closeModal,
      editChannel,
      deleteChannel,
      handleSubmit,
    };
  },
});
</script>

<style scoped>
.dashboard-layout {
  display: grid;
  grid-template-areas:
    "header header"
    "sidebar content";
  grid-template-columns: 250px 1fr;
  grid-template-rows: auto 1fr;
  min-height: 100vh;
}

.dashboard-header {
  grid-area: header;
  background-color: #f8f9fa;
  padding: 1rem;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.dashboard-sidebar {
  grid-area: sidebar;
  background-color: #343a40;
  color: #fff;
  padding: 1rem;
}

.dashboard-sidebar ul {
  list-style: none;
  padding: 0;
}

.dashboard-sidebar ul li {
  margin-bottom: 1rem;
}

.dashboard-sidebar ul li a {
  color: #fff;
  text-decoration: none;
}

.dashboard-sidebar ul li a:hover {
  text-decoration: underline;
}

.dashboard-content {
  grid-area: content;
  padding: 2rem;
  background-color: #f1f3f5;
}

.logout-button {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  cursor: pointer;
  font-size: 1rem;
  border-radius: 4px;
}

.logout-button:hover {
  background-color: #c82333;
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
