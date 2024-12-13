<template>
  <div>
    <h1>Create a New Email Template</h1>

    <form @submit.prevent="saveTemplate">
      <div>
        <label for="name">Template Name</label>
        <input v-model="template.name" id="name" type="text" required />
      </div>

      <div>
        <label for="style">Style</label>
        <select v-model="template.style" required>
          <option value="style1">Style 1</option>
          <option value="style2">Style 2</option>
          <option value="style3">Style 3</option>
        </select>
      </div>

      <div>
        <label for="content">Template Content</label>
        <textarea v-model="template.content" id="content" required></textarea>
      </div>

      <button type="submit">Save Template</button>
    </form>

    <!-- Notifications Component -->
    <Notifications />
  </div>
</template>

<script>
import { useNotification, Notifications } from '@kyvg/vue3-notification';

export default {
  components: {
    Notifications,
  },
  data() {
    return {
      template: {
        name: '',
        style: 'style1',
        content: '',
      },
    };
  },
  setup() {
    const { notify } = useNotification();
    return {
      notify,
    };
  },
  methods: {
    async saveTemplate() {
      try {
        const response = await fetch('/email-templates', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(this.template),
        });

        if (!response.ok) {
          throw new Error('Failed to save template');
        }

        // Use the same notification method as "Show Notifications" button
        this.notify({
          title: 'Success',
          text: 'Template saved successfully!',
          type: 'success', // Use the success notification type
          duration: 3000, // Duration for the notification to stay on screen
          position: 'top-right', // Position of the notification
        });

        // Optionally, reset the form
        this.template = { name: '', style: 'style1', content: '' };
      } catch (error) {
        console.error('Error saving template:', error);

        // Use the same error notification method
        this.notify({
          title: 'Error',
          text: 'Error saving template',
          type: 'error', // Use the error notification type
          duration: 3000, // Duration for the notification to stay on screen
          position: 'top-right', // Position of the notification
        });
      }
    },
  },
};
</script>
