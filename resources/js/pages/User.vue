<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

// Props from Laravel Controller
defineProps<{
  programs: Array<{
    id: number
    name: string
    description?: string
    projects: Array<{
      id: number
      title: string
      status: string
      budget: number | string
      description?: string
    }>
  }>
}>()

// Logout function
const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Head title="User Dashboard" />

  <AppLayout>
    <!-- Page Header -->
    <template #header>
      <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
          User Dashboard
        </h1>

        <!-- Logout button -->
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
      <!-- Welcome Message -->
      <div class="mb-8">
        <p class="text-lg mb-2">
          Welcome, <strong>{{ $page.props.auth.user.name }}</strong>!
        </p>
        <p class="text-gray-600 dark:text-gray-400">
          You are logged in as a <strong>User</strong>. You can view system data and project information, but editing is disabled.
        </p>
      </div>

      <!-- ✅ PROGRAMS SECTION -->
      <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">
        Programs Overview
      </h2>

      <div
        v-for="program in programs"
        :key="program.id"
        class="mb-8 p-5 bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700"
      >
        <!-- Program Header -->
        <div class="flex justify-between items-center mb-3">
          <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300">
            {{ program.name }}
          </h3>
        </div>

        <!-- Program Description -->
        <p class="text-gray-600 dark:text-gray-400 mb-4">
          {{ program.description || 'No description available.' }}
        </p>

        <!-- Projects under Program -->
        <div v-if="program.projects.length" class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div
            v-for="project in program.projects"
            :key="project.id"
            class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition"
          >
            <!-- Project Header -->
            <div class="flex justify-between items-center mb-2">
              <h4 class="font-medium text-gray-800 dark:text-gray-100">
                {{ project.title }}
              </h4>

              <!-- Status Badge -->
              <span
                class="text-xs font-semibold uppercase px-2 py-1 rounded-full"
                :class="{
                  'bg-green-100 text-green-700': project.status === 'Approved',
                  'bg-yellow-100 text-yellow-700': project.status === 'Processing',
                  'bg-gray-100 text-gray-700': project.status === 'Submitted',
                  'bg-red-100 text-red-700': project.status === 'Rejected',
                }"
              >
                {{ project.status }}
              </span>
            </div>

            <!-- Project Info -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">
              Budget: ₱{{ Number(project.budget).toLocaleString() }}
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 line-clamp-3">
              {{ project.description || 'No project description provided.' }}
            </p>

            <!-- Disabled Edit Button -->
            <div class="flex justify-end">
              <button
                disabled
                class="cursor-not-allowed opacity-60 px-3 py-1 text-sm bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded-md"
              >
                Edit (Restricted)
              </button>
            </div>
          </div>
        </div>

        <!-- No Projects -->
        <div v-else class="text-gray-500 italic">
          No projects available under this program.
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
