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
  </div>
</template>

<script>
export default {
  data() {
    return {
      template: {
        name: '',
        style: 'style1',
        content: '',
      },
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

        alert('Template saved successfully!');
        // Optionally, redirect or clear the form
        this.template = { name: '', style: 'style1', content: '' };
      } catch (error) {
        console.error('Error saving template:', error);
        alert('Error saving template');
      }
    },
  },
};
</script>


<style scoped>
.container {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

.template-container {
  display: flex;
  justify-content: center;
  gap: 30px;
  flex-wrap: wrap;
  margin-bottom: 30px;
}

.template-preview {
  width: 300px;
  height: 200px;
  border-radius: 10px;
  object-fit: cover;
  border: 3px solid transparent;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}

.template-preview:hover {
  transform: scale(1.1);
  border-color: #007bff;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.template-option {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  gap: 10px;
  margin: 20px;
}

.template-label {
  font-size: 1rem;
  font-weight: bold;
  color: #333;
}

.content {
  display: flex;
  justify-content: space-between;
  gap: 20px;
}

.code-view {
  width: 50%;
  padding: 10px;
  border: 1px solid #ddd;
  background: #f5f5f5;
}

.code-editor {
  width: 100%;
  height: 400px;
  font-family: monospace;
  white-space: pre;
  overflow: auto;
  border: 1px solid #ccc;
  background-color: #fff;
  outline: none;
}

.preview-view {
  width: 50%;
  padding: 10px;
  border: 1px solid #ddd;
  background: #fff;
  min-height: 400px;
  overflow: auto;
}

.editable-preview {
  width: 100%;
  min-height: 400px;
  border: 1px solid #ddd;
  padding: 10px;
  overflow: auto;
}
</style>
