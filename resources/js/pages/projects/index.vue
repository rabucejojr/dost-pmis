<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Program, Project } from '@/types'
import { router } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { route } from 'ziggy-js'
import {
  MapPin,
  User,
  Wallet,
  Clock,
  Plus,
  Trash2,
  Eye,
  Search,
  Archive,
} from 'lucide-vue-next'
import {
  Card,
  CardHeader,
  CardTitle,
  CardContent,
  CardFooter,
} from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import {
  Dialog,
  DialogContent,
  DialogHeader,
  DialogTitle,
  DialogDescription,
  DialogFooter,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'

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

  return props.projects.filter((p) => {
    return (
      p.title?.toLowerCase().includes(search) ||
      p.description?.toLowerCase().includes(search) ||
      p.location?.toLowerCase().includes(search) ||
      p.project_leader?.toLowerCase().includes(search)
    )
  })
})

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

        // Wait a moment before navigating to ensure the record is deleted
        setTimeout(() => {
          router.visit(route('projects.trashed'))
        }, 150)
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
    <section class="p-6 min-h-screen">
      <!-- Header -->
      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
      >
        <div>
          <h1 class="text-3xl font-bold">
            {{ program ? program.program_name : 'All Programs' }} Projects
          </h1>
          <p class="text-gray-500 text-sm">
            A complete overview of ongoing and completed projects.
          </p>
        </div>

        <div class="flex items-center gap-3">
          <Button variant="outline" @click="goToArchived">
            <Archive class="w-4 h-4 mr-2" /> Archived Projects
          </Button>
          <Button @click="goToCreate">
            <Plus class="w-4 h-4 mr-2" /> Add Project
          </Button>
        </div>
      </div>

      <!-- 🔍 Search -->
      <div
        class="w-full sm:w-1/2 mb-10 bg-white dark:bg-gray-800 p-3 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700"
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

      <!-- Empty State -->
      <div
        v-if="filteredProjects.length === 0"
        class="text-center py-20 text-gray-500"
      >
        No projects found.
      </div>

      <!-- Projects Grid -->
      <div
        v-else
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <Card
          v-for="project in filteredProjects"
          :key="project.id"
          class="hover:shadow-lg hover:scale-[1.02] transition"
        >
          <CardHeader>
            <CardTitle class="text-lg font-semibold text-blue-700">
              {{ project.title }}
            </CardTitle>
          </CardHeader>

          <CardContent>
            <p class="text-gray-600 text-sm line-clamp-3 mb-4">
              {{ project.description }}
            </p>

            <div class="space-y-1.5 text-xs text-gray-600">
              <p class="flex items-center gap-2">
                <MapPin class="w-4 h-4 text-blue-600" />
                <span>{{ project.location }}</span>
              </p>
              <p class="flex items-center gap-2">
                <User class="w-4 h-4 text-indigo-600" />
                <span>{{ project.project_leader }}</span>
              </p>
              <p class="flex items-center gap-2">
                <Wallet class="w-4 h-4 text-green-600" />
                <span>₱{{ project.budget.toLocaleString() }}</span>
              </p>
              <p class="flex items-center gap-2">
                <Clock class="w-4 h-4 text-yellow-600" />
                <span>
                  {{ formatDate(project.start_date) }} →
                  {{ formatDate(project.end_date) }}
                </span>
              </p>
            </div>
          </CardContent>

          <CardFooter class="flex justify-between items-center pt-4">
            <Badge
              :variant="{
                completed: 'success',
                ongoing: 'secondary',
                terminated: 'destructive',
              }[project.status] || 'outline'"
              class="capitalize"
            >
              {{ project.status }}
            </Badge>

            <div class="flex items-center gap-2">
              <Button variant="link" size="sm" as-child>
                <a :href="`/projects/${project.id}`">
                  <Eye class="w-4 h-4" />
                </a>
              </Button>

              <!-- 🗑️ Archive Button -->
              <Button
                variant="destructive"
                size="sm"
                @click.prevent="confirmArchive(project)"
              >
                <Trash2 class="w-4 h-4" />
              </Button>
            </div>
          </CardFooter>
        </Card>
      </div>

      <!-- 🗂️ Archive Confirmation Modal -->
      <Dialog v-model:open="showArchiveModal">
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Archive Project</DialogTitle>
            <DialogDescription>
              Are you sure you want to archive
              <span class="font-semibold text-blue-600">{{
                selectedProject?.title
              }}</span
              >?
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
    </section>
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
