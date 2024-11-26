<template>
  <div :class="style">
    <h1>{{ template.name }}</h1>
    <p>{{ template.content }}</p>
    <div v-html="template.style"></div> <!-- Render style content -->
  </div>
</template>

<script>
export default {
  props: {
    template: {
      type: Object,
      required: true,
    },
    style: {
      type: [String, Number],  // Accept both String and Number types
      required: true,
    },
  },
};
</script>

<style scoped>
/* Define styles for 'style1' and 'style2' */
.style1 {
  background-color: lightblue;
  color: darkblue;
}

.style2 {
  background-color: lightgreen;
  color: darkgreen;
}

.style3 {
  background-color: lightyellow;
  color: darkorange;
}
</style>
