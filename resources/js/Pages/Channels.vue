<template>
  <div>
    <h1>Channels</h1>
    <button @click="openCreateModal" class="btn btn-primary mb-3">Create New Channel</button>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Email</th>
          <th>SMS</th>
          <th>Social Media</th>
          <th>Source</th>
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
          <td>
            <button @click="editChannel(channel.id)" class="btn btn-warning">Edit</button>
            <button @click="confirmDelete(channel.id)" class="btn btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for creating or editing a channel -->
    <div v-if="showModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editMode ? 'Edit Channel' : 'Create Channel' }}</h5>
            <button type="button" class="close" @click="closeModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="handleSubmit">
              <div>
                <label>Email:</label>
                <input type="checkbox" v-model="channelData.email" />
              </div>
              <div>
                <label>SMS:</label>
                <input type="checkbox" v-model="channelData.sms" />
              </div>
              <div>
                <label>Social Media:</label>
                <input type="checkbox" v-model="channelData.social_media" />
              </div>
              <div>
                <label>Source:</label>
                <input type="text" v-model="channelData.source" />
              </div>
              <button type="submit">{{ editMode ? 'Update' : 'Create' }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Delete</h5>
            <button type="button" class="close" @click="closeDeleteModal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this channel?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeDeleteModal">Cancel</button>
            <button type="button" class="btn btn-danger" @click="deleteChannel">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    channels: Array, // Receive channels from props
  },
  data() {
    return {
      showModal: false,
      showDeleteModal: false,
      editMode: false,
      channelData: {
        email: false,
        sms: false,
        social_media: false,
        source: '',
      },
      channelToDelete: null, // Store channel ID to delete
    };
  },
  methods: {
    openCreateModal() {
      this.editMode = false;
      this.showModal = true;
      this.channelData = { email: false, sms: false, social_media: false, source: '' };
    },
    editChannel(id) {
      this.editMode = true;
      const channel = this.channels.find(c => c.id === id);
      this.channelData = { ...channel };
      this.showModal = true;
    },
    confirmDelete(id) {
      this.channelToDelete = id; // Set the channel ID to delete
      this.showDeleteModal = true;
    },
    closeDeleteModal() {
      this.showDeleteModal = false;
      this.channelToDelete = null; // Clear the channel ID
    },
    closeModal() {
      this.showModal = false;
    },
    async deleteChannel() {
      await this.$inertia.delete(`/channels/${this.channelToDelete}`);
      this.closeDeleteModal(); // Close modal after deletion
    },
    async handleSubmit() {
      if (this.editMode) {
        await this.$inertia.put(`/channels/${this.channelData.id}`, this.channelData);
      } else {
        await this.$inertia.post('/channels', this.channelData);
      }
      this.showModal = false;
    },
  },
};
</script>

<style scoped>
/* Add your CSS styling here */
h1 {
  font-size: 2rem;
  color: black;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th, td {
  border: 1px solid black;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f2f2f2;
}

button {
  background-color: black;
  color: white;
  border: none;
  padding: 8px 12px;
  cursor: pointer;
  margin-right: 5px; /* Space between buttons */
}

button:hover {
  background-color: #555;
}

.modal {
  display: block; /* Show the modal */
  position: fixed; /* Stay in place */
  z-index: 1050; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
}
.modal-content {
  background-color: white; /* White background */
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}
</style>
