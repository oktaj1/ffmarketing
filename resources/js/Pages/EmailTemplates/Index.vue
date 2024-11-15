<template>
  <div class="dashboard-layout">
    <!-- Header Section -->
    <header class="dashboard-header">
      <h1>Email Templates</h1>
      <button class="logout-button" @click="logout">Logout</button>
    </header>

    <!-- Sidebar Section -->
    <aside class="dashboard-sidebar">
      <nav>
        <ul>
          <li><a href="/subscribers">Subscribers</a></li>
          <li><a href="/channels">Channels</a></li>
          <li><a href="/email-templates">Email Templates</a></li>
          <li><a href="/settings">Settings</a></li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">
      <!-- Button to create new template -->
      <button class="button" @click="openCreateModal">Create New Template</button>

      <!-- Table to display templates -->
      <table class="styled-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="template in emailTemplates" :key="template.id">
            <td>{{ template.id }}</td>
            <td>{{ template.name }}</td>
            <td>{{ template.description }}</td>
            <td>
              <button class="edit-button" @click="editTemplate(template)">Edit</button>
              <button class="delete-button" @click="deleteTemplate(template.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- Modal for creating/editing a template -->
      <div v-if="showCreateModal" class="modal">
        <div class="modal-content">
          <span class="close" @click="closeCreateModal">&times;</span>
          <h2>{{ editMode ? 'Edit Template' : 'Create New Template' }}</h2>
          <form @submit.prevent="createTemplate">
            <div class="form-group">
              <label for="name">Template Name</label>
              <input v-model="newTemplate.name" type="text" id="name" class="input-field" required />
            </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea v-model="newTemplate.description" id="description" class="input-field"></textarea>
            </div>

            <button type="submit" class="btn">{{ editMode ? 'Update' : 'Create Template' }}</button>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    emailTemplates: {
      type: Array,
      required: true,
      default: () => [],
    },
    errors: Object,
  },
  data() {
    return {
      showCreateModal: false,
      editMode: false,
      newTemplate: {
        id: null,
        name: '',
        description: '',
      },
    };
  },
  methods: {
    openCreateModal() {
      this.editMode = false;
      this.newTemplate = { id: null, name: '', description: '' };
      this.showCreateModal = true;
    },
    closeCreateModal() {
      this.showCreateModal = false;
    },
    async createTemplate() {
      if (this.editMode) {
        await Inertia.patch(`/email-templates/${this.newTemplate.id}`, this.newTemplate);
      } else {
        await Inertia.post('/email-templates', this.newTemplate);
      }
      this.closeCreateModal();
    },
    async editTemplate(template) {
      this.newTemplate = { ...template };
      this.editMode = true;
      this.showCreateModal = true;
    },
    async deleteTemplate(id) {
      if (confirm('Are you sure you want to delete this template?')) {
        await Inertia.delete(`/email-templates/${id}`);
      }
    },
  },
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
