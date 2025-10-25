<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'
import { ArrowLeft } from 'lucide-vue-next'

const form = useForm({
  title: '',
  description: '',
  location: '',
  status: 'ongoing',
  budget: 0,
  start_date: '',
  end_date: '',
  project_leader: '',
  contact_email: '',
  implementing_year: new Date().getFullYear(),
})

const statuses = [
  'ongoing',
  'completed',
  'terminated',
  'continuing',
  'graduated',
  'grace_period',
  'liquidated',
  'unliquidated',
]

const submit = () => form.post(route('projects.store'))
</script>

<template>
  <AppLayout>
    <Head title="Create Project" />

    <section class="max-w-5xl mx-auto py-10 px-4 md:px-8 space-y-8">
      <!-- Page Header -->
      <div class="flex justify-between items-center">
        <div>
          <h1 class="text-3xl font-bold tracking-tight text-gray-800 dark:text-gray-100">
            Create New Project
          </h1>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Fill out the fields below to add a new project record.
          </p>
        </div>

        <Link
          :href="route('projects.index')"
          class="flex items-center gap-1 text-sm text-blue-600 dark:text-blue-400 hover:underline"
        >
          <ArrowLeft class="w-4 h-4" />
          Back to Projects
        </Link>
      </div>

      <!-- Project Details Card -->
      <Card class="shadow-sm border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
        <CardHeader class="pb-2">
          <CardTitle class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            Project Information
          </CardTitle>
        </CardHeader>

        <CardContent class="space-y-6">
          <!-- Title & Description -->
          <div class="space-y-4">
            <div>
              <Label class="text-sm font-medium">Project Title <span class="text-red-500">*</span></Label>
              <Input
                v-model="form.title"
                placeholder="Enter project title"
                class="mt-1 w-full"
              />
              <small v-if="form.errors.title" class="text-red-500">{{ form.errors.title }}</small>
            </div>

            <div>
              <Label class="text-sm font-medium">Description</Label>
              <Textarea
                v-model="form.description"
                placeholder="Brief description of the project..."
                rows="4"
                class="mt-1 resize-none"
              />
            </div>
          </div>

          <!-- Grid Layout -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <Label class="text-sm font-medium">Location</Label>
              <Input v-model="form.location" placeholder="Enter project location" class="mt-1" />
            </div>

            <!-- Status Dropdown -->
            <div>
              <Label class="text-sm font-medium">Status</Label>
              <select
                v-model="form.status"
                class="mt-1 w-full p-2.5 text-sm rounded-md border border-gray-300
                       bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:outline-none
                       dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700
                       dark:focus:ring-blue-400 transition-all"
              >
                <option disabled value="">Select status</option>
                <option
                  v-for="status in statuses"
                  :key="status"
                  :value="status"
                  class="capitalize bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                >
                  {{ status.replace('_', ' ') }}
                </option>
              </select>
            </div>

            <div>
              <Label class="text-sm font-medium">Budget (₱)</Label>
              <Input type="number" v-model="form.budget" min="0" class="mt-1" />
            </div>

            <div>
              <Label class="text-sm font-medium">Implementing Year</Label>
              <Input type="number" v-model="form.implementing_year" class="mt-1" />
            </div>

            <div>
              <Label class="text-sm font-medium">Start Date</Label>
              <Input type="date" v-model="form.start_date" class="mt-1" />
            </div>

            <div>
              <Label class="text-sm font-medium">End Date</Label>
              <Input type="date" v-model="form.end_date" class="mt-1" />
            </div>

            <div>
              <Label class="text-sm font-medium">Project Leader</Label>
              <Input v-model="form.project_leader" placeholder="Enter leader name" class="mt-1" />
            </div>

            <div>
              <Label class="text-sm font-medium">Contact Email</Label>
              <Input
                type="email"
                v-model="form.contact_email"
                placeholder="leader@email.com"
                class="mt-1"
              />
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="pt-6 flex justify-end gap-3 border-t border-gray-200 dark:border-gray-700">
            <Link :href="route('projects.index')">
              <Button variant="outline" class="hover:bg-gray-100 dark:hover:bg-gray-800">
                Cancel
              </Button>
            </Link>

            <Button
              :disabled="form.processing"
              @click="submit"
              class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white"
            >
              {{ form.processing ? 'Saving...' : 'Save Project' }}
            </Button>
          </div>
        </CardContent>
      </Card>
    </section>
  </AppLayout>
</template>
