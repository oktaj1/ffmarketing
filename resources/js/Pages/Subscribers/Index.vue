<template>
  <div>
    <h1>Channels</h1>
    <button @click="openCreateModal">Create New Channel</button>

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
            <button @click="editChannel(channel.id)">Edit</button>
            <button @click="deleteChannel(channel.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Modal for creating or editing a channel -->
    <div v-if="showModal">
      <h2>{{ editMode ? 'Edit Channel' : 'Create Channel' }}</h2>
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
</template>

<script>
export default {
  data() {
    return {
      channels: [], // Store channels data
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
        // Call the delete route
        await this.$inertia.delete(`/channels/${id}`);
        // Refresh the channels list
        this.fetchChannels();
      }
    },
    async handleSubmit() {
      if (this.editMode) {
        // Call the update route with the channel data
        await this.$inertia.put(`/channels/${this.channelData.id}`, this.channelData);
      } else {
        // Call the store route to create a new channel
        await this.$inertia.post('/channels', this.channelData);
      }
      this.showModal = false;
      this.fetchChannels(); // Refresh the channels after submission
    },
    async fetchChannels() {
      const response = await this.$inertia.get('/channels');
      this.channels = response.props.channels; // Access the channels correctly
    },
  },
  mounted() {
    this.fetchChannels(); // Fetch channels when the component mounts
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
</style>
