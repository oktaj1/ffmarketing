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
          <th>ID</th>
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
        <tr v-for="campaign in campaigns" :key="campaign.id">
          <td>{{ campaign.id }}</td>
          <td>{{ campaign.name }}</td>
          <td>{{ campaign.description }}</td>
          <td>{{ campaign.type }}</td>
          <td>{{ campaign.start_date }}</td>
          <td>{{ campaign.end_date }}</td>
          <td>{{ campaign.status }}</td>
          <td>
          <button class="edit-button" @click="editCampaign(campaign.ulid)">Edit</button>
          <button class="delete-button" @click="deleteCampaign(campaign.ulid)">Delete</button>
         </td>
        </tr>
      </tbody>
    </table>

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
              <option v-for="template in emailTemplates" :key="template.id" :value="template.id">
                {{ template.name }}
              </option>
            </select>
          </div>

          <div class="form-group">
            <label for="channels">Select Channels</label>
                <select v-model="campaignData.channels" id="channels" class="input-field" multiple>
                  <option value="" disabled>Select Channels</option>
                  <option v-for="channel in channels" :key="channel.id" :value="channel.id">
                    {{ channel.source }}
                  </option>
                </select>
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
    channels: Array // Make sure this is included
  },
  data() {
    return {
      showModal: false,
      editMode: false,
      campaignData: {
        name: '',
        description: '',
        type: 'email',
        start_date: '',
        end_date: '',
        status: 'active',
        email_template_id: null, // Holds selected email template ID
        channels: [] // Initialize channels as an array
      }
    };
  },
  methods: {
    openCreateModal() {
      this.editMode = false;
      this.showModal = true;
      this.resetForm();
    },
editCampaign(ulid) {
  this.editMode = true;

  // Find the campaign by its ULID
  const campaign = this.campaigns.find(c => c.ulid === ulid);

  // If the campaign is found, set the campaignData with necessary adjustments
  if (campaign) {
    this.campaignData = {
      ...campaign,
      email_template_id: campaign.email_template_id || null, // Default email template to null if not present
      channels: campaign.channels.map(channel => channel.id) // Convert channels to an array of IDs
    };
    this.showModal = true; // Open the modal for editing
  }
},


    closeModal() {
      this.showModal = false;
      this.resetForm();
    },
    resetForm() {
      this.campaignData = {
        name: '',
        description: '',
        type: 'email',
        start_date: '',
        end_date: '',
        status: 'active',
        email_template_id: null,
        channels: [] // Reset channels when the form is closed
      };
    },
    async handleSubmit() {
      if (this.editMode) {
        await this.$inertia.put(`/campaigns/${this.campaignData.ulidid}`, this.campaignData);
      } else {
        await this.$inertia.post('/campaigns', this.campaignData);
      }
      this.closeModal();
    },
    async deleteCampaign(id) {
      if (confirm('Are you sure you want to delete this campaign?')) {
        await this.$inertia.delete(`/campaigns/${id}`);
      }
    },
    navigateTo(page) {
      this.$inertia.visit(`/${page}`);
    },
    logout() {
      // Your logout logic
    },
    updateTemplateOptions() {
      if (this.campaignData.type !== 'email') {
        this.campaignData.email_template_id = null; // Reset email template ID if not email type
      }
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
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}

.close {
  float: right;
  font-size: 1.5rem;
  cursor: pointer;
}

.form-group {
  margin-bottom: 15px;
}

.input-field {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
}

input[type="date"] {
  cursor: pointer;
}
</style>
