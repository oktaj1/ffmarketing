<template>
    <div class="container">
      <div class="header">
        <label for="templateSelector">Choose a Template:</label>
        <select id="templateSelector" v-model="selectedStyle" @change="loadTemplate">
          <option value="">Select Style</option>
          <option value="style1">Style 1</option>
          <option value="style2">Style 2</option>
          <option value="style3">Style 3</option>
        </select>
      </div>
  
      <div class="content">
        <!-- Code Viewer -->
        <div class="code-view">
          <h3>Template Code</h3>
          <pre><code>{{ templateCode }}</code></pre>
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
          <p v-else>Select a template to preview it</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        selectedStyle: "", // Selected template style
        templateCode: "", // Code of the selected template
        previewUrl: "", // Preview URL for the selected template
      };
    },
    methods: {
      async loadTemplate() {
        if (!this.selectedStyle) {
          this.templateCode = "";
          this.previewUrl = "";
          return;
        }
  
        try {
          // Fetch the code of the selected template
          const codeResponse = await fetch(`/email-templates/code/${this.selectedStyle}`);
          const codeData = await codeResponse.json();
          if (codeData.code) {
            this.templateCode = codeData.code;
          } else {
            this.templateCode = "Error loading template code.";
          }
  
          // Set the preview URL for the iframe
          this.previewUrl = `/email-templates/preview/${this.selectedStyle}`;
        } catch (error) {
          console.error("Error loading template:", error);
          this.templateCode = "Failed to load template code.";
          this.previewUrl = "";
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
    height: 500px;
    border: none;
  }
  </style>
  