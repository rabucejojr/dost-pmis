<script setup lang="ts">
import { defineProps } from 'vue'
import { router } from '@inertiajs/vue3'
import type { Project } from '@/types'

// 🧠 Props definition — accepts a list of projects and optional title
defineProps<{
  projects: Project[]
  title?: string
}>()

// 🧠 Navigate to project details via Inertia visit
const viewProject = (id: number) => {
  router.visit(`/projects/${id}`)
}
</script>

<template>
  <div class="transition-colors duration-300 dark:bg-gray-900 p-4 rounded-lg">
    <h2
      v-if="title"
      class="text-2xl font-bold mb-4 text-blue-700 dark:text-blue-400"
    >
      {{ title }}
    </h2>

    <!-- 🧠 Handle no projects -->
    <div
      v-if="projects.length === 0"
      class="text-gray-600 dark:text-gray-300 text-center py-8"
    >
      No projects found for this program.
    </div>

    <!-- 🧠 Project Grid -->
    <div
      v-else
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
    >
      <div
        v-for="project in projects"
        :key="project.id"
        class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 hover:shadow-lg hover:scale-[1.02] transition flex flex-col justify-between"
      >
        <!-- 🧠 Project Basic Info -->
        <div>
          <h3
            class="text-lg font-semibold text-blue-700 dark:text-blue-400 mb-1"
          >
            {{ project.title }}
          </h3>

          <p
            class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3 mb-2"
          >
            {{ project.description }}
          </p>

          <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">
            📍 {{ project.location }}
          </p>

          <p class="text-xs text-gray-500 dark:text-gray-400">
            🗓 {{ formatDate(project.start_date) }} → {{ formatDate(project.end_date) }}
          </p>
        </div>

        <!-- 🧠 Footer Section -->
        <div class="mt-4 flex justify-between items-center">
          <span
            class="text-xs font-medium uppercase px-2 py-1 rounded-full"
            :class="{
              'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200': project.status === 'completed',
              'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200': project.status === 'ongoing',
              'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200': project.status === 'planning',
              'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200': project.status === 'approved',
              'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200': project.status === 'rejected',
            }"
          >
            {{ project.status }}
          </span>

          <button
            @click="viewProject(project.id)"
            class="bg-blue-700 dark:bg-blue-600 text-white px-3 py-1.5 text-sm rounded-md hover:bg-blue-800 dark:hover:bg-blue-700 transition"
          >
            View Details
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
// 🧠 Utility functions scoped below main script
function formatDate(value: any): string {
  if (!value) return 'N/A'
  const date = new Date(value)
  return date.toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}
</script>

<style scoped>
/* 🧠 Simple fade transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
