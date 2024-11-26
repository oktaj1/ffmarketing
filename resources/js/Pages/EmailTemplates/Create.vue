<template>
  <div class="container">
    <div class="header">
      <h2>Select a Blade Template</h2>
    </div>

    <div class="template-container">
      <div v-for="template in templates" :key="template.name" class="template-option"
        @click="selectTemplate(template.style)">
        <img :src="`/images/${template.style}-preview.jpg`" :alt="template.name" class="template-preview" />
        <div class="template-label">{{ template.name }}</div>
      </div>
    </div>

    <div class="content">
      <div class="code-view">
        <h3>Blade Code</h3>
        <textarea v-model="editableBladeCode" ref="codeEditor" class="code-editor"
          @input="syncPreviewWithCode"></textarea>
        <button @click="saveTemplate" class="save-btn">Save Template</button>
      </div>

      <div class="preview-view">
        <h3>Preview</h3>
        <div class="editable-preview" ref="previewContainer" v-html="renderedPreview" @click="handleElementClick"
          contenteditable="true" @input="syncCodeWithPreview"></div>
        <p v-if="!renderedPreview">Select a Blade template to preview it</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      templates: [
        { name: "Style 1", style: "style1" },
        { name: "Style 2", style: "style2" },
        { name: "Style 3", style: "style3" },
      ],
      selectedBlade: null,
      editableBladeCode: "",
      renderedPreview: "",
    };
  },
  methods: {
    selectTemplate(style) {
      this.selectedBlade = style;
      this.loadBlade();
    },
    async loadBlade() {
      if (!this.selectedBlade) return;

      try {
        const response = await fetch(`/api/blade-code?style=${this.selectedBlade}`);
        if (!response.ok) throw new Error("Failed to fetch blade code");

        const data = await response.json();
        this.editableBladeCode = data.blade_code;
        this.renderedPreview = data.preview_html;
      } catch (error) {
        console.error("Error fetching Blade code:", error);
        this.editableBladeCode = "Error loading blade code";
        this.renderedPreview = "";
      }
    },
    async saveTemplate() {
      try {
        const response = await fetch("/api/save-blade-template", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            style: this.selectedBlade,
            content: this.editableBladeCode,
          }),
        });

        if (!response.ok) throw new Error("Failed to save template");
        alert("Template saved successfully!");
      } catch (error) {
        console.error("Save error:", error);
        alert("Failed to save template");
      }
    },
    handleElementClick(event) {
      const target = event.target;
      if (target.hasAttribute("data-editable")) {
        const dataEditable = target.getAttribute("data-editable");
        this.highlightBladeTag(dataEditable);
        this.scrollCodeToView(dataEditable);
      }
    },
    highlightBladeTag(dataEditable) {
      if (!dataEditable) return;

      const lines = this.editableBladeCode.split("\n");
      const match = lines.find((line) => line.includes(`data-editable="${dataEditable}"`));

      if (match) {
        const textarea = this.$refs.codeEditor;
        const startIndex = this.editableBladeCode.indexOf(match);
        const endIndex = startIndex + match.length;

        textarea.setSelectionRange(startIndex, endIndex);
        textarea.focus();
      }
    },
    syncPreviewWithCode() {
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = this.editableBladeCode;

      this.renderedPreview = tempDiv.innerHTML;
    },
    syncCodeWithPreview(event) {
      const tempDiv = this.$refs.previewContainer;
      this.editableBladeCode = tempDiv.innerHTML;
    },
    scrollCodeToView(dataEditable) {
      const textarea = this.$refs.codeEditor;
      const lines = this.editableBladeCode.split("\n");
      const matchingLine = lines.find((line) => line.includes(`data-editable="${dataEditable}"`));

      if (matchingLine) {
        const lineIndex = lines.indexOf(matchingLine);
        const lineHeight = parseInt(window.getComputedStyle(textarea).lineHeight, 10);
        const scrollPosition = lineIndex * lineHeight;

        textarea.scrollTop = scrollPosition;
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
