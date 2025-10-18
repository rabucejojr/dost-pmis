<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import AppLayout from '@/layouts/AppLayout.vue'

// ✅ Logout function (same as User page)
const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Head title="Guest Page" />

  <AppLayout>
    <div class="p-8 text-gray-800 dark:text-gray-100">
      <h1 class="text-2xl font-bold mb-4">Guest Logged In</h1>

      <p class="text-base mb-4">
        Welcome, {{ $page.props.auth.user.name }}!
      </p>

      <p class="text-sm text-gray-600 dark:text-gray-400">
        You are currently logged in as a guest user. You have limited access to view
        public content and announcements.
      </p>

      <button
        @click="logout"
        class="mt-6 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
      >
        Logout
      </button>
    </div>
  </AppLayout>
</template>
