<template>
  <div class="container">
    <div class="header">
      <label for="bladeSelector">Choose a Blade Template:</label>
      <select id="bladeSelector" v-model="selectedBlade" @change="loadBlade">
        <option value="style1">Style 1</option>
        <option value="style2">Style 2</option>
        <option value="style3">Style 3</option>
      </select>
    </div>

    <div class="content">
      <!-- Code Viewer -->
      <div class="code-view">
        <h3>Blade Code</h3>
        <pre><code>{{ bladeCode }}</code></pre>
      </div>

      <!-- Preview -->
      <div class="preview-view">
        <h3>Preview</h3>
        <iframe
          v-if="previewUrl"
          :src="previewUrl"
          frameborder="0"
          class="iframe-preview"
        ></iframe>
        <p v-else>Select a Blade template to preview it</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedBlade: null, // Currently selected Blade file
      bladeCode: "", // The Blade file code content
      previewUrl: "", // URL to render the Blade preview
    };
  },
  methods: {
    async loadBlade() {
      if (!this.selectedBlade) return;

      try {
        // Fetch Blade file code from the server
        const response = await fetch(
          `/api/blade-code?style=${this.selectedBlade}`
        );
        const data = await response.json();
        this.bladeCode = data.code;

        // Set the preview URL
        this.previewUrl = `/preview/${this.selectedBlade}`;
      } catch (error) {
        console.error("Error fetching Blade code:", error);
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
  display: flex;
  gap: 10px;
  align-items: center;
}

.content {
  display: flex;
  justify-content: space-between;
}

.code-view {
  width: 50%;
  padding: 10px;
  border: 1px solid #ddd;
  background: #f5f5f5;
  overflow-x: auto;
}

.preview-view {
  width: 50%;
  padding: 10px;
  border: 1px solid #ddd;
}

.iframe-preview {
  width: 100%;
  height: 100%;
  border: none;
}
</style>
