<template>
    <div>
      <h1>Edit Email Template</h1>
      <form @submit.prevent="updateTemplate">
        <div>
          <label for="name">Name:</label>
          <input v-model="template.name" id="name" type="text" />
        </div>
        <div>
          <label for="content">Content:</label>
          <textarea v-model="template.content" id="content"></textarea>
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      template: Object,
    },
    methods: {
      updateTemplate() {
        this.$inertia.put(`/email-templates/${this.template.id}`, this.template);
      },
    },
  };
  </script>
  