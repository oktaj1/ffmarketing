  <template>
    <div class="app-container">
      <!-- Sidebar Navigator -->
      <aside class="sidebar">
        <div class="sidebar-header">
          <!-- <h2>Dashboard</h2> -->
        </div>
        <nav class="sidebar-nav">
          <ul>
            <li><a href="/campaigns">Campaigns</a></li>
            <li><a href="/subscribers">Subscribers</a></li>
            <li><a href="/channels">Channels</a></li>
            <li><a href="/email-templates">Email Templates</a></li>
          </ul>
        </nav>
        <button class="logout-btn" @click="logout">Logout</button>
      </aside>

      <!-- Main Content -->
      <main class="main-content">
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
          </div>
        </div>
      </main>
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
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            name: "Custom Template", // Dynamic name you want to pass
            content: this.editableBladeCode, // Blade code content you are typing
            style: this.selectedBlade, // Style name (e.g., style1, style2)
          }),
        });

        if (!response.ok) throw new Error("Failed to save template");
        const data = await response.json();
        alert("Template saved successfully!");
        console.log("Saved template:", data); // Log the saved template to check the response
      } catch (error) {
        console.error("Save error:", error);
        alert("Failed to save template");
      }
    }
    ,
    logout() {
      alert("Logging out...");
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
.app-container {
  display: flex;
  height: 100vh;
}

/* Sidebar styles */
.sidebar {
  width: 250px;
  background-color: #343a40;
  color: #fff;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 20px;
}

.sidebar-header {
  font-size: 1.5rem;
  text-align: center;
  margin-bottom: 20px;
}

.sidebar-nav ul {
  list-style: none;
  padding: 0;
}

.sidebar-nav li {
  margin-bottom: 10px;
}

.sidebar-nav a {
  color: #fff;
  text-decoration: none;
  font-size: 1rem;
}

.sidebar-nav a:hover {
  text-decoration: underline;
}

.logout-btn {
  background-color: #dc3545;
  color: #fff;
  border: none;
  padding: 10px;
  font-size: 1rem;
  cursor: pointer;
  border-radius: 5px;
  text-align: center;
}

.logout-btn:hover {
  background-color: #c82333;
}

/* Main Content styles */
.main-content {
  flex: 1;
  padding: 20px;
  overflow: auto;
}

.header {
  margin-bottom: 20px;
  text-align: center;
}

.template-container {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
}

.template-option {
  cursor: pointer;
  text-align: center;
}

.template-preview {
  width: 150px;
  /* Increased size */
  height: auto;
  margin-bottom: 5px;
  /* Reduced margin */
}

.template-label {
  font-size: 1rem;
}

.content {
  display: flex;
  gap: 20px;
}

.code-view,
.preview-view {
  flex: 1;
}

.code-editor {
  width: 100%;
  height: 300px;
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  resize: none;
}

.save-btn {
  display: block;
  margin-top: 10px;
  background-color: #28a745;
  color: #fff;
  border: none;
  padding: 10px;
  cursor: pointer;
  border-radius: 5px;
}

.save-btn:hover {
  background-color: #218838;
}

.editable-preview {
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  min-height: 300px;
  overflow: auto;
}

.editable-preview[contenteditable] {
  outline: none;
}
</style>
