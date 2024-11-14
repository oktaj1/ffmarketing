<template>
  <div class="dashboard-layout">
    <!-- Header Section -->
    <header class="dashboard-header">
      <h1>Campaigns</h1>
      <button class="logout-button" @click="logout">Logout</button>
    </header>

    <!-- Sidebar Section -->
    <aside class="dashboard-sidebar">
      <nav>
        <ul>
          <li><a href="/subscribers">Subscribers</a></li>
          <li><a href="/channels">Channels</a></li>
          <li><a href="/campaigns">Campaigns</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">
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
    </main>
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
        channels: []
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
    async handleSubmit() {
      if (this.editMode) {
        await this.$inertia.patch(`/campaigns/${this.campaignData.ulid}`, this.campaignData);
      } else {
        await this.$inertia.post('/campaigns', this.campaignData);
      }
      this.closeModal();
    },
    resetCampaignData() {
      this.campaignData = {
        ulid: null,
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
  padding: 6px 12px;
  cursor: pointer;
  font-size: 0.9rem;
  border-radius: 4px;
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

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background-color: #fff;
  padding: 2rem;
  border-radius: 8px;
  width: 400px;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 1.5rem;
  cursor: pointer;
}

.form-group {
  margin-bottom: 1rem;
}

.input-field {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.checkbox-group {
  display: flex;
  align-items: center;
}

.checkbox-group input {
  margin-right: 0.5rem;
}

button.btn {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 0.5rem 1rem;
  font-size: 1rem;
  cursor: pointer;
  border-radius: 4px;
}

button.btn:hover {
  background-color: #0056b3;
}
</style>
