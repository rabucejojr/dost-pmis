<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Project } from '@/types'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { ArrowLeft, RotateCcw, Trash2, Archive } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardHeader,
  CardTitle,
  CardContent,
  CardFooter,
} from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'

defineProps<{
  projects: Project[]
}>()

// ✅ Restore a soft-deleted project
const restore = (id: number) => {
  router.put(route('projects.restore', id), {}, {
    preserveScroll: true,
    onSuccess: () => {
      // Optional toast or visual feedback
      console.log('Project restored successfully.')
    },
    onError: (error) => {
      console.error('Restore failed:', error)
    },
  })
}

// ✅ Permanently delete a soft-deleted project
const forceDelete = (id: number) => {
  if (confirm('⚠️ This will permanently delete the project. Continue?')) {
    router.delete(route('projects.forceDelete', id), {
      preserveScroll: true,
      onSuccess: () => {
        console.log('Project permanently deleted.')
      },
      onError: (error) => {
        console.error('Permanent delete failed:', error)
      },
    })
  }
}
</script>

<template>
  <AppLayout title="Archived Projects">
    <section class="p-6 min-h-screen">
      <!-- Header -->
      <div
        class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4"
      >
        <div class="flex items-center gap-2">
          <Archive class="w-6 h-6 text-gray-600 dark:text-gray-300" />
          <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            Archived Projects
          </h1>
        </div>

        <Button variant="outline" as-child>
          <a :href="route('projects.index')" class="flex items-center gap-2">
            <ArrowLeft class="w-4 h-4" /> Back to Active Projects
          </a>
        </Button>
      </div>

      <!-- Empty State -->
      <div
        v-if="projects.length === 0"
        class="text-center text-gray-500 py-24"
      >
        🗂️ No archived projects found.
      </div>

      <!-- Archived Projects Grid -->
      <div
        v-else
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <Card
          v-for="project in projects"
          :key="project.id"
          class="hover:shadow-lg hover:scale-[1.02] transition-all duration-200"
        >
          <CardHeader>
            <CardTitle
              class="text-lg font-semibold text-gray-800 dark:text-gray-100"
            >
              {{ project.title }}
            </CardTitle>
          </CardHeader>

          <CardContent class="space-y-3">
            <p
              class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-3"
            >
              {{ project.description || 'No description available.' }}
            </p>

            <div class="flex justify-between items-center">
              <Badge variant="outline" class="capitalize">
                {{ project.status || 'Archived' }}
              </Badge>

              <span
                class="text-xs text-gray-500 dark:text-gray-400 italic"
                v-if="project.deleted_at"
              >
                Archived:
                {{ new Date(project.deleted_at).toLocaleDateString() }}
              </span>
            </div>
          </CardContent>

          <CardFooter class="flex justify-end gap-2 pt-4">
            <Button
              variant="secondary"
              size="sm"
              class="flex items-center gap-1"
              @click="restore(project.id)"
            >
              <RotateCcw class="w-4 h-4" /> Restore
            </Button>

            <Button
              variant="destructive"
              size="sm"
              class="flex items-center gap-1"
              @click="forceDelete(project.id)"
            >
              <Trash2 class="w-4 h-4" /> Delete
            </Button>
          </CardFooter>
        </Card>
      </div>
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
