<script setup lang="ts">
import type { Program } from '@/types'
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Search } from 'lucide-vue-next'

// Props definition
const props = defineProps<{
  programs: Program[]
}>()

// Search input
const searchQuery = ref('')

// Computed: Filter programs dynamically
const filteredPrograms = computed(() => {
  const search = searchQuery.value.trim().toLowerCase()
  if (!search) return props.programs

  return props.programs.filter((p) => {
    const name = p.program_name?.toLowerCase() || ''
    const desc = p.description?.toLowerCase() || ''
    return name.includes(search) || desc.includes(search)
  })
})

// Navigate to selected program
const viewProjects = (programId?: number) => {
  if (!programId) return
  router.get(`/projects?program=${programId}`, {}, {
    preserveScroll: true,
    preserveState: true,
  })
}
</script>

<template>
  <div class="transition-colors duration-300 dark:bg-gray-900 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">

      <!-- Search Bar -->
      <div
        class="w-full sm:w-1/2 mx-auto mb-10 bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700"
      >
        <Label for="search" class="sr-only">Search Programs</Label>
        <div class="relative">
          <Search class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
          <Input
            id="search"
            v-model="searchQuery"
            type="text"
            placeholder="Search by program name or description..."
            class="pl-9"
          />
        </div>
      </div>

      <!-- Grid List -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
          v-for="program in filteredPrograms"
          :key="program.id"
          @click="viewProjects(program.id)"
          class="cursor-pointer bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 hover:shadow-lg hover:scale-[1.02] transition"
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

      <!-- Empty State -->
      <div
        v-if="filteredPrograms.length === 0"
        class="text-center text-gray-500 dark:text-gray-400 py-20"
      >
        No matching programs found.
      </div>
    </div>
  </div>
</template>

<style scoped>
.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
