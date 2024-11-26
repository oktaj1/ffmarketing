<template>
  <div>
    <button @click="openModal()">Create Template</button>

    <div v-for="template in templates" :key="template.id" class="template-card">
      <h3>{{ template.name }}</h3>
      <div v-html="template.content"></div>
      <button @click="openModal(template)">Edit</button>
      <button @click="previewTemplate(template.id)">Preview</button>
    </div>

    <div v-if="showModal" class="modal">
      <div class="modal-content">
        <h2>{{ currentTemplate ? 'Edit' : 'Create' }} Template</h2>
        <form @submit.prevent="saveTemplate">
          <label for="name">Name</label>
          <input v-model="form.name" type="text" id="name" required />

          <label for="content">Content</label>
          <textarea v-model="form.content" id="content" required></textarea>

          <label for="style">Style</label>
          <select v-model="form.style" id="style">
            <option value="style1">Style 1</option>
            <option value="style2">Style 2</option>
            <option value="style3">Style 3</option>
          </select>

          <button type="submit">{{ currentTemplate ? 'Update' : 'Create' }} Template</button>
        </form>
        <button @click="closeModal">Close</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      templates: [],
      showModal: false,
      currentTemplate: null,
      form: {
        name: '',
        content: '',
        style: 'style1', // Default style
      },
      errors: {},
    };
  },
  methods: {
    async openModal(template) {
      this.showModal = true;
      if (template) {
        this.currentTemplate = template;
        this.form = { ...template };
      } else {
        this.currentTemplate = null;
        this.form = { name: '', content: '', style: 'style1' };
      }
    },
    closeModal() {
      this.showModal = false;
      this.form = { name: '', content: '', style: 'style1' };
      this.currentTemplate = null;
      this.errors = {};
    },
    async saveTemplate() {
      this.errors = {};
      try {
        const url = this.currentTemplate
          ? `/email-templates/${this.currentTemplate.id}`
          : '/email-templates';

        const method = this.currentTemplate ? 'PUT' : 'POST';

        const response = await fetch(url, {
          method,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document
              .querySelector('meta[name="csrf-token"]')
              .getAttribute('content'),
          },
          body: JSON.stringify(this.form),
        });

        if (!response.ok) {
          const result = await response.json();
          this.errors = result.errors || {};
          throw new Error('Error saving template');
        }

        const updatedTemplate = await response.json();
        if (this.currentTemplate) {
          const index = this.templates.findIndex(
            (t) => t.id === this.currentTemplate.id
          );
          this.templates.splice(index, 1, updatedTemplate);
        } else {
          this.templates.push(updatedTemplate);
        }

        this.closeModal();
      } catch (error) {
        console.error(error);
      }
    },
    async previewTemplate(id) {
      window.open(`/preview-email/${id}`, '_blank');
    },
    async fetchTemplates() {
      try {
        const response = await fetch('/email-templates');
        if (response.ok) {
          this.templates = await response.json();
        } else {
          throw new Error('Failed to fetch templates');
        }
      } catch (error) {
        console.error(error);
      }
    },
  },
  mounted() {
    this.fetchTemplates();
  },
};
</script>
