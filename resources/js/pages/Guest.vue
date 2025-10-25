<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

// Props from the controller
defineProps<{
  programs: { id: number; name: string; description: string }[]
}>()

// Logout function (shared with others)
const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Head title="Guest Page" />

  <AppLayout>
    <template #header>
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
          Guest Dashboard
        </h1>

        <button
          @click="logout"
          class="px-3 py-1.5 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm"
        >
          Logout
        </button>
      </div>
    </template>

    <!-- Main Content -->
    <div class="p-6 text-gray-800 dark:text-gray-100">
      <p class="text-lg mb-4">
        Welcome, {{ $page.props.auth.user.name }}!
      </p>
      <p class="text-gray-600 dark:text-gray-400">
        You are logged in as a <strong>Guest</strong>. You can browse program information but not view detailed projects.
      </p>

      <!-- Program List -->
      <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div
          v-for="program in programs"
          :key="program.id"
          class="p-4 border rounded-lg bg-white dark:bg-gray-800 shadow hover:shadow-md transition"
        >
          <h2 class="text-lg font-semibold mb-1">{{ program.name }}</h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ program.description }}
          </p>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
