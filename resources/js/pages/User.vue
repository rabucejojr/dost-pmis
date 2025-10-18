<script lang='ts' setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import {route} from 'ziggy-js'

// Logout function
const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Head title="User Page" />

  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
          User Dashboard
        </h1>

        <!-- Logout button (same as Dashboard) -->
        <button
          @click="logout"
          class="px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
        >
          Logout
        </button>
      </div>
    </template>

    <!-- Page Content -->
    <div class="p-6 text-gray-800 dark:text-gray-100">
      <p class="text-lg mb-3">
        Welcome, {{ $page.props.auth.user.name }}!
      </p>

      <p class="text-gray-600 dark:text-gray-400">
        You are logged in as a <strong>User</strong>. You can view system data
        and reports, but editing features are disabled.
      </p>

      <!-- Example "view-only" content section -->
      <div class="mt-6 space-y-3">
        <div class="border rounded-lg p-4 bg-white dark:bg-gray-800 shadow">
          <h2 class="text-lg font-semibold">📊 View Reports</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            Access and view project or performance reports assigned to your division.
          </p>
        </div>

        <div class="border rounded-lg p-4 bg-white dark:bg-gray-800 shadow">
          <h2 class="text-lg font-semibold">📁 Browse Documents</h2>
          <p class="text-sm text-gray-500 dark:text-gray-400">
            View and download approved documents. Editing is restricted.
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
