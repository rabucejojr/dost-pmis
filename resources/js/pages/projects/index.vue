<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Program, Project } from '@/types'
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { route } from 'ziggy-js'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Search,
  Eye,
  Trash2,
  Archive,
  Plus,
  MapPin,
  User,
  Wallet,
  Clock,
  FolderKanban,
} from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
} from '@/components/ui/dialog'

// Props
const props = defineProps<{
  program: Program | null
  projects: Project[]
}>()

// State
const selectedProject = ref<Project | null>(null)
const showArchiveModal = ref(false)
const searchQuery = ref('')

// Computed: Filter projects dynamically
const filteredProjects = computed(() => {
  const search = searchQuery.value.trim().toLowerCase()
  if (!search) return props.projects

  return props.projects.filter((p) =>
    [p.title, p.description, p.location, p.project_leader]
      .filter(Boolean)
      .some((field) => field.toLowerCase().includes(search))
  )
})

// Helpers
function formatDate(value: string | Date): string {
  if (!value) return 'N/A'
  const date = new Date(value)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}

// Navigation
const goToCreate = () => router.visit(route('projects.create'))
const goToArchived = () => router.visit(route('projects.trashed'))

// Modal actions
const confirmArchive = (project: Project) => {
  selectedProject.value = project
  showArchiveModal.value = true
}

const archiveProject = async () => {
  if (!selectedProject.value) return

  try {
    await router.delete(route('projects.destroy', selectedProject.value.id), {
      preserveScroll: true,
      onSuccess: () => {
        showArchiveModal.value = false
        selectedProject.value = null
        setTimeout(() => router.visit(route('projects.trashed')), 150)
      },
      onError: (errors) => {
        console.error('Archive failed:', errors)
      },
    })
  } catch (error) {
    console.error('Unexpected error during archive:', error)
  }
}
</script>

<template>
  <AppLayout title="Projects">
    <div class="transition-colors duration-300 dark:bg-gray-900 min-h-screen p-6">
      <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div
          class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4"
        >
          <div class="flex items-center gap-2">
            <FolderKanban
            class="text-blue-600 dark:text-blue-400 w-8 h-8 sm:w-7 sm:h-7 md:w-8 md:h-8 lg:w-9 lg:h-9"
            />

            <div>
              <h1
                class="text-3xl font-bold text-blue-700 dark:text-blue-400"
              >
                {{ program ? program.program_name : 'All Programs' }} Projects
              </h1>
              <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">
                A complete overview of ongoing and completed projects.
              </p>
            </div>
          </div>

           <!-- Action Buttons -->
<div class="flex flex-row flex-wrap gap-3 w-full sm:w-auto justify-center sm:justify-start">
  <!-- Archived Projects -->
  <div class="relative group flex-1 sm:flex-none">
    <Link
      href="#"
      @click.prevent="goToArchived"
      class="w-full text-center py-2.5 min-h-[44px] rounded-lg bg-transparent text-blue-600 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 flex items-center justify-center transition-colors duration-200"
    >
      <Archive class="w-5 h-5" />
    </Link>

    <!-- Tooltip -->
    <div
      class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 px-2 py-1 text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap"
    >
      Archived Projects
      <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-4 border-transparent border-t-gray-800 dark:border-t-gray-700"></div>
    </div>
  </div>

  <!-- Add Project -->
  <div class="relative group flex-1 sm:flex-none">
    <Link
      href="#"
      @click.prevent="goToCreate"
      class="w-full text-center py-2.5 min-h-[44px] rounded-lg bg-blue-600 hover:bg-blue-700 text-white dark:bg-blue-500 dark:hover:bg-blue-400 flex items-center justify-center transition-colors duration-200"
    >
      <Plus class="w-5 h-5" />
    </Link>

    <!-- Tooltip -->
    <div
      class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 px-2 py-1 text-xs font-medium text-white bg-gray-800 dark:bg-gray-700 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap"
    >
      Add Project
      <div class="absolute top-full left-1/2 -translate-x-1/2 w-0 h-0 border-4 border-transparent border-t-gray-800 dark:border-t-gray-700"></div>
    </div>
  </div>
</div>

        </div>

        <!-- 🔍 Search -->
        <div
          class="w-full sm:w-1/2 mx-auto mb-10 bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700"
        >
          <Label for="search" class="sr-only">Search Projects</Label>
          <div class="relative">
            <Search class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" />
            <Input
              id="search"
              v-model="searchQuery"
              type="text"
              placeholder="Search by title, leader, or location..."
              class="pl-9"
            />
          </div>
        </div>

        <!-- 📋 Projects Grid -->
        <div
          v-if="filteredProjects.length"
          class="grid grid-cols-[repeat(auto-fit,minmax(260px,1fr))] gap-6"
        >
          <div
            v-for="project in filteredProjects"
            :key="project.id"
            class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-5 hover:shadow-lg hover:scale-[1.02] transition border border-transparent hover:border-blue-300 dark:hover:border-blue-700"
          >
            <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-400">
              {{ project.title }}
            </h3>

            <p
              class="text-gray-700 dark:text-gray-300 text-sm mt-1 font-medium uppercase"
            >
              {{ project.status || '—' }}
            </p>

            <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 line-clamp-3">
              {{ project.description || 'No description available.' }}
            </p>

            <div class="mt-4 text-sm text-gray-600 dark:text-gray-400 space-y-1">
              <p class="flex items-center gap-2">
                <MapPin class="w-4 h-4 text-blue-500" />
                <span>{{ project.location || '—' }}</span>
              </p>
              <p class="flex items-center gap-2">
                <User class="w-4 h-4 text-indigo-500" />
                <span>{{ project.project_leader || '—' }}</span>
              </p>
            <p class="flex items-center gap-2">
            <Wallet class="w-4 h-4 text-green-500" />
            <span>
                {{ new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(project.budget ?? 0) }}
            </span>
            </p>
              <p class="flex items-center gap-2">
                <Clock class="w-4 h-4 text-yellow-500" />
                <span>
                  {{ formatDate(project.start_date) }} → {{ formatDate(project.end_date) }}
                </span>
              </p>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-5 text-sm">
              <a
                :href="route('projects.show', project.id)"
                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium flex items-center gap-1"
              >
                <Eye class="w-4 h-4" /> View
              </a>

              <button
                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 flex items-center gap-1"
                @click.prevent="confirmArchive(project)"
              >
                <Trash2 class="w-4 h-4" /> Archive
              </button>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div
          v-else
          class="text-center text-gray-500 dark:text-gray-400 py-20"
        >
          No projects found.
        </div>

        <!-- 🗂️ Archive Confirmation Modal -->
        <Dialog v-model:open="showArchiveModal">
          <DialogContent>
            <DialogHeader>
              <DialogTitle>Archive Project</DialogTitle>
              <DialogDescription>
                Are you sure you want to archive
                <span class="font-semibold text-blue-600 dark:text-blue-400">
                  {{ selectedProject?.title }}
                </span>?
                <br />
                You can restore it later from the Archived Projects section.
              </DialogDescription>
            </DialogHeader>

            <DialogFooter class="flex justify-end gap-3 mt-4">
              <Button variant="outline" @click="showArchiveModal = false">
                Cancel
              </Button>
              <Button variant="destructive" @click="archiveProject">
                Confirm Archive
              </Button>
            </DialogFooter>
          </DialogContent>
        </Dialog>
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
