<script setup lang="ts">
import { ref } from 'vue'
import { Program } from '../types/index'

// Props definition
defineProps<{
  programs: Program[]
}>()

const selectedProgram = ref<null | Program>(null)

const openProgram = (program: Program) => {
  selectedProgram.value = program
}

const closeProgram = () => {
  selectedProgram.value = null
}
</script>

<template>
  <div class="transition-colors duration-300 dark:bg-gray-900 min-h-screen p-4">
    <!-- Grid List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="program in programs"
        :key="program.id"
        @click="openProgram(program)"
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

    <!-- Modal for Program Details -->
    <transition name="fade">
      <div
        v-if="selectedProgram"
        class="fixed inset-0 bg-gray-900/70 dark:bg-black/80 flex items-center justify-center z-50"
        @click.self="closeProgram"
      >
        <div
          class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-lg p-6 text-gray-900 dark:text-gray-100"
        >
          <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-400 mb-2">
            {{ selectedProgram.program_name }}
          </h2>
          <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
            {{ selectedProgram.description }}
          </p>

          <!-- Buttons -->
          <div class="mt-3 flex justify-end space-x-3">
            <button
              @click="closeProgram"
              class="bg-blue-700 dark:bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-800 dark:hover:bg-blue-700 transition"
            >
              View Projects
            </button>
            <button
              @click="closeProgram"
              class="bg-red-600 dark:bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </transition>
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
