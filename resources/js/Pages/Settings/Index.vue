<template>
    <div>
        <h1>Settings</h1>
        <h2>Change Password</h2>

        <form @submit.prevent="submitPasswordChange">
            <div>
                <label for="oldPassword">Old Password</label>
                <input type="password" v-model="form.oldPassword" id="oldPassword" required />
            </div>

            <div>
                <label for="newPassword">New Password</label>
                <input type="password" v-model="form.newPassword" id="newPassword" required />
            </div>

            <div>
                <label for="newPasswordConfirmation">Confirm New Password</label>
                <input type="password" v-model="form.newPasswordConfirmation" id="newPasswordConfirmation" required />
            </div>

            <div v-if="errors.oldPassword">
                <p>{{ errors.oldPassword }}</p>
            </div>

            <div>
                <button type="submit">Submit</button>
            </div>
        </form>

        <div v-if="message" class="message">
            <p>{{ message }}</p>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    setup() {
        const form = ref({
            oldPassword: "",
            newPassword: "",
            newPasswordConfirmation: "",
        });
        const errors = ref({
            oldPassword: null,
            newPassword: null,
        });
        const message = ref(null);

        const submitPasswordChange = () => {
            Inertia.post("/settings/password", form.value)
                .then(() => {
                    message.value = "Password changed successfully!";
                })
                .catch((error) => {
                    errors.value = error.response.data.errors;
                });
        };

        return {
            form,
            errors,
            message,
            submitPasswordChange,
        };
    },
};
</script>