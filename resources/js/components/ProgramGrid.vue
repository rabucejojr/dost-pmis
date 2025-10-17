<script setup lang="ts">
import { Program } from '../types/index'
import { router } from '@inertiajs/vue3'

// Props definition
defineProps<{
  programs: Program[]
}>()

// Navigate to the selected program's projects (via Inertia)
const viewProjects = (programId?: number) => {
  if (!programId) return // 🛡️ prevent null errors

  router.get(`/projects?program=${programId}`, {}, {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>

<template>
  <div class="transition-colors duration-300 dark:bg-gray-900 min-h-screen p-4">
    <!-- Grid List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="program in programs"
        :key="program.id"
        @click="viewProjects(program.id)"
        class="cursor-pointer bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 hover:shadow-lg transition hover:scale-[1.02]"
      >
        <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-400">
          {{ program.program_name }}
        </h3>
        <p class="text-gray-700 dark:text-gray-300 text-sm mt-2 font-medium uppercase">
          {{ program.type }}
        </p>
        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 line-clamp-3">
          {{ program.description }}
        </p>
      </div>
    </div>

  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
