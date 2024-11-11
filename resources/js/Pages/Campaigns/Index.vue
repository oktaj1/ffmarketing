<template>
  <div class="container">
    <div class="button-container">
      <button @click="navigateTo('subscribers')">Subscribers</button>
      <button @click="navigateTo('channels')">Channels</button>
      <button @click="navigateTo('campaigns')">Campaigns</button>
      <button @click="navigateTo('settings')">Settings</button>
      <button @click="logout">Logout</button>
    </div>

    <h1>Campaigns</h1>

    <button class="button" @click="openCreateModal">Create New Campaign</button>

    <table class="styled-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Type</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="campaign in localCampaigns" :key="campaign.ulid">
          <td>{{ campaign.name }}</td>
          <td>{{ campaign.description }}</td>
          <td>{{ campaign.type }}</td>
          <td>{{ campaign.start_date }}</td>
          <td>{{ campaign.end_date }}</td>
          <td>{{ campaign.status }}</td>
          <td>
            <button class="edit-button" @click="editCampaign(campaign.id)">Edit</button>
            <button class="delete-button" @click="deleteCampaign(campaign.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- <child-component :campaigns.sync="campaigns" /> -->
    <!-- Modal for creating or editing a campaign -->
    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <h2>{{ editMode ? 'Edit Campaign' : 'Create New Campaign' }}</h2>
        <form @submit.prevent="handleSubmit">
          <div class="form-group">
            <label for="name">Campaign Name</label>
            <input v-model="campaignData.name" type="text" id="name" class="input-field" required />
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea v-model="campaignData.description" id="description" class="input-field"></textarea>
          </div>

          <div class="form-group">
            <label for="type">Campaign Type</label>
            <select v-model="campaignData.type" id="type" class="input-field" @change="updateTemplateOptions">
              <option value="email">Email</option>
              <option value="sms">SMS</option>
            </select>
          </div>

          <div v-if="campaignData.type === 'email'" class="form-group">
            <label for="email-template">Email Template</label>
            <select v-model="campaignData.email_template_id" id="email-template" class="input-field">
              <option value="">Select an Email Template</option>
              <option v-for="template in emailTemplates" :key="template.ulid" :value="template.ulid">
                {{ template.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="channels">Select Channels</label>
            <div v-for="channel in channels" :key="channel.ulid" class="checkbox-group">
              <input type="checkbox" :id="`channel-${channel.ulid}`" :value="channel.ulid"
                v-model="campaignData.channels" />
              <label :for="`channel-${channel.ulid}`">{{ channel.source }}</label>
            </div>
          </div>

          <div class="form-group">
            <label for="start-date">Start Date</label>
            <input v-model="campaignData.start_date" type="date" id="start-date" class="input-field" required />
          </div>

          <div class="form-group">
            <label for="end-date">End Date</label>
            <input v-model="campaignData.end_date" type="date" id="end-date" class="input-field" />
          </div>

          <div class="form-group">
            <label for="status">Status</label>
            <select v-model="campaignData.status" id="status" class="input-field">
              <option value="active">Active</option>
              <option value="paused">Paused</option>
              <option value="completed">Completed</option>
            </select>
          </div>

          <button type="submit" class="btn">{{ editMode ? 'Update' : 'Create Campaign' }}</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    campaigns: Array,
    emailTemplates: Array,
    channels: Array
  },
  data() {
    return {
      showModal: false,
      editMode: false,
      campaignData: {
        ulid: null,
        name: '',
        description: '',
        type: 'email',
        start_date: '',
        end_date: '',
        status: 'active',
        email_template_id: null,
        channels: [],
        campaigns: []
      },
      localCampaigns: []
    };
  },
  created() {
    this.localCampaigns = [...this.campaigns];
  },
  watch: {
    campaigns(newVal) {
      this.localCampaigns = [...newVal];
    }
  },
  methods: {
    openCreateModal() {
      this.editMode = false;
      this.resetCampaignData();
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.resetCampaignData();
    },
    async deleteCampaign(id) {
      if (confirm('Are you sure you want to delete this campaign?')) {
        await this.$inertia.delete(`/campaigns/${id}`);
      }
    },
    editCampaign(id) {
  const campaignToEdit = this.campaigns.find(campaign => campaign.id === id);
  if (campaignToEdit) {
    this.campaignData = {
      ...campaignToEdit,
      channels: Array.isArray(campaignToEdit.channels)
        ? campaignToEdit.channels.map(channel => channel.id)
        : [],
      ulid: campaignToEdit.id // Ensure the ulid is set
    };
    this.editMode = true;
    this.showModal = true;
  }
},

onCampaignsUpdated(updatedCampaigns) {
      this.campaigns = updatedCampaigns;
    },
    async handleSubmit() {
      console.log(this.campaignData);
  if (this.editMode) {
    await this.$inertia.patch(`/campaigns/${this.campaignData.ulid}`, this.campaignData);
  } else {
    await this.$inertia.post('/campaigns', this.campaignData);
  }
  this.closeModal();
},
    resetCampaignData() {
      this.campaignData = {
        ulid: null, // Reset ulid as well
        name: '',
        description: '',
        type: 'email',
        start_date: '',
        end_date: '',
        status: 'active',
        email_template_id: null,
        channels: []
      };
    }
  }
};
</script>


<style scoped>
/* Styles remain unchanged */
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
  background-color: #28a745;
  color: white;
  border: none;
  padding: 8px 12px;
  border-radius: 5px;
  cursor: pointer;
}

.edit-button {
  background-color: #ffc107;
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

.delete-button {
  background-color: #dc3545;
}

.delete-button:hover {
  background-color: #c82333;
}

.edit-button:hover {
  background-color: #e0a800;
}

/* Modal styles */
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fefefe;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  width: 80%;
  max-width: 500px;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.input-field {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  border-radius: 5px;
  border: 1px solid #ccc;
}

.checkbox-group {
  display: flex;
  align-items: center;
}

.checkbox-group input {
  margin-right: 10px;
}

.btn {
  padding: 10px 15px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: #218838;
}
</style>