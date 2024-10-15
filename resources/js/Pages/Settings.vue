<template>
  <DashboardLayout>
    <div>
      <h1>Account Settings</h1>
      <form @submit.prevent="updateAccount">
        <!-- Email, password inputs -->
        <button type="submit">Update</button>
      </form>
    </div>
  </DashboardLayout>
</template>

<script>
export default {
  methods: {
    updateAccount() {
      // API call to update email/password
    }
  }
};
</script>
