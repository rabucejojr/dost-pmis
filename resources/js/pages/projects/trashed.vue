<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Project } from '@/types'
import { router } from '@inertiajs/vue3'
import { ArrowLeft, RotateCcw, Trash2 } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { Card, CardHeader, CardTitle, CardContent, CardFooter } from '@/components/ui/card'
import { Badge } from '@/components/ui/badge'

const props = defineProps<{
  projects: Project[]
}>()

// Restore project
const restore = (id: number) => {
  router.put(`/projects/${id}/restore`, {}, { preserveScroll: true })
}

// Permanently delete
const forceDelete = (id: number) => {
  if (confirm('This will permanently delete the project. Continue?')) {
    router.delete(`/projects/${id}/force-delete`, {}, { preserveScroll: true })
  }
}
</script>

<template>
  <AppLayout title="Archived Projects">
    <section class="p-6 min-h-screen">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <h1 class="text-3xl font-bold">Archived Projects</h1>

        <Button variant="outline" as-child>
          <a href="/projects" class="flex items-center gap-2">
            <ArrowLeft class="w-4 h-4" /> Back to Active Projects
          </a>
        </Button>
      </div>

      <!-- Empty State -->
      <div
        v-if="projects.length === 0"
        class="text-center text-gray-500 py-24"
      >
        No archived projects.
      </div>

      <!-- Archived Projects Grid -->
      <div
        v-else
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <Card
          v-for="project in projects"
          :key="project.id"
          class="hover:shadow-lg hover:scale-[1.02] transition"
        >
          <CardHeader>
            <CardTitle class="text-lg font-semibold text-gray-800 dark:text-gray-200">
              {{ project.title }}
            </CardTitle>
          </CardHeader>

          <CardContent>
            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-3">
              {{ project.description || 'No description available.' }}
            </p>

            <Badge variant="outline" class="capitalize">
              {{ project.status || 'Archived' }}
            </Badge>
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
