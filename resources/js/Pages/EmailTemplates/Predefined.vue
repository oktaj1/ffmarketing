<template>
    <div class="predefined-templates-page">
      <header>
        <h1>Choose a Predefined Template</h1>
      </header>
      <div class="templates-grid">
        <div
          v-for="template in templates"
          :key="template.id"
          class="template-card"
        >
          <img :src="template.preview" alt="Template Preview" class="template-preview" />
          <h3>{{ template.name }}</h3>
          <p>{{ template.description }}</p>
          <button
            @click="selectTemplate(template.id)"
            class="select-button"
          >
            Use this template
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      templates: Array,
    },
    methods: {
      selectTemplate(id) {
        this.$inertia.get('/email-templates/create', { template_id: id });
      },
    },
  };
  </script>
  
  <style scoped>
  .predefined-templates-page {
    padding: 2rem;
  }
  .templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1rem;
  }
  .template-card {
    border: 1px solid #ddd;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
  }
  .template-preview {
    width: 100%;
    border-radius: 4px;
  }
  .select-button {
    margin-top: 1rem;
    padding: 0.5rem 1rem;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  </style>
  