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
        <textarea v-model="template.html_content" id="content"></textarea>
      </div>
      <div>
        <label for="style">Style:</label>
        <input v-model="template.style" id="style" type="text" />
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
      this.$inertia.put(`/email-templates/${this.template.id}`, {
        name: this.template.name,
        description: this.template.description,  // If you want to handle description as well
        html_content: this.template.html_content,
        style: this.template.style,
      });
    },
  },
};
</script>
