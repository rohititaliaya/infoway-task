<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
                Stock Manager Login
            </h2>

            <!-- Form -->
            <form @submit.prevent="submitLogin" class="space-y-5">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Email</label
                    >
                    <input
                        v-model="email"
                        type="email"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1"
                        >Password</label
                    >
                    <input
                        v-model="password"
                        type="password"
                        placeholder="Enter your password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    />
                </div>

                <!-- Error -->
                <p v-if="error" class="text-red-600 text-sm">{{ error }}</p>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition disabled:opacity-50"
                    :disabled="loading"
                >
                    <span v-if="loading">Logging in...</span>
                    <span v-else>Login</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

const store = useStore();
const router = useRouter();

const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref("");

const submitLogin = async () => {
    loading.value = true;
    error.value = "";
    try {
        await store.dispatch("auth/login", {
            email: email.value,
            password: password.value,
        });
        router.push("/list");
    } catch (err) {
        error.value = err?.message || "Login failed";
    } finally {
        loading.value = false;
    }
};
</script>
