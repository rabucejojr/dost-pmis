<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Project, Program } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Badge } from '@/components/ui/badge'
import { ChevronLeft, Pencil, MapPin, Wallet, Clock, User, Mail } from 'lucide-vue-next'

defineProps<{
  project: Project
  program: Program
}>()

function formatDate(value: string | Date): string {
  if (!value) return 'N/A'
  const date = new Date(value)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>

<template>
  <AppLayout>
    <Head :title="project.title" />

    <section class="max-w-4xl mx-auto py-8 px-6 space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ project.title }}</h1>
        <Badge class="capitalize">{{ project.status }}</Badge>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Description</CardTitle>
        </CardHeader>
        <CardContent>
          <p class="text-gray-700 dark:text-gray-300 text-justify">
            {{ project.description }}
          </p>
        </CardContent>
      </Card>

      <Card>
        <CardHeader>
          <CardTitle>Details</CardTitle>
        </CardHeader>
        <CardContent class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-600">
          <div class="space-y-3">
            <p class="flex items-center gap-2">
              <MapPin class="w-4 h-4 text-blue-600" /> <strong>Location:</strong> {{ project.location }}
            </p>
            <p class="flex items-center gap-2">
              <Wallet class="w-4 h-4 text-green-600" /> <strong>Budget:</strong> ₱{{ project.budget.toLocaleString() }}
            </p>
            <p class="flex items-center gap-2">
              <Clock class="w-4 h-4 text-yellow-600" />
              <strong>Duration:</strong> {{ formatDate(project.start_date) }} → {{ formatDate(project.end_date) }}
            </p>
          </div>

          <div class="space-y-3">
            <p class="flex items-center gap-2">
              <User class="w-4 h-4 text-indigo-600" /> <strong>Leader:</strong> {{ project.project_leader }}
            </p>
            <p class="flex items-center gap-2">
              <Mail class="w-4 h-4 text-red-600" /> <strong>Email:</strong> {{ project.contact_email }}
            </p>
          </div>
        </CardContent>
      </Card>

      <div class="flex justify-between">
        <Link :href="`/projects?program=${project.program_id}`">
          <Button variant="outline"><ChevronLeft class="w-4 h-4 mr-2" /> Back</Button>
        </Link>
        <Link :href="`/projects/${project.id}/edit`">
          <Button><Pencil class="w-4 h-4 mr-2" /> Edit Project</Button>
        </Link>
      </div>
    </section>
  </AppLayout>
</template>
