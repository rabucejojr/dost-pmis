<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Textarea } from '@/components/ui/textarea'
import { Button } from '@/components/ui/button'

const props = defineProps<{
  project: {
    id: number
    title: string
    description: string
    location: string
    status: string
    budget: number
    start_date: string
    end_date: string
    project_leader: string
    contact_email: string
    implementing_year: number
  }
}>()

const form = useForm({ ...props.project })

const submit = () => form.put(route('projects.update', props.project.id))
</script>

<template>
  <AppLayout>
    <Head title="Edit Project" />

    <section class="max-w-4xl mx-auto py-10 px-6 space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Edit Project</h1>
        <Link :href="route('projects.index')" class="text-blue-600 hover:underline">← Back to Projects</Link>
      </div>

      <Card>
        <CardHeader>
          <CardTitle>Project Information</CardTitle>
        </CardHeader>
        <CardContent class="space-y-4">
          <div>
            <Label>Project Title</Label>
            <Input v-model="form.title" placeholder="Enter project title" />
          </div>

          <div>
            <Label>Description</Label>
            <Textarea v-model="form.description" placeholder="Project overview..." />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <Label>Location</Label>
              <Input v-model="form.location" />
            </div>

            <div>
              <Label>Status</Label>
              <Input v-model="form.status" placeholder="ongoing, completed, etc." />
            </div>

            <div>
              <Label>Budget (₱)</Label>
              <Input type="number" v-model="form.budget" />
            </div>

            <div>
              <Label>Implementing Year</Label>
              <Input type="number" v-model="form.implementing_year" />
            </div>

            <div>
              <Label>Start Date</Label>
              <Input type="date" v-model="form.start_date" />
            </div>

            <div>
              <Label>End Date</Label>
              <Input type="date" v-model="form.end_date" />
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <Label>Project Leader</Label>
              <Input v-model="form.project_leader" />
            </div>
            <div>
              <Label>Contact Email</Label>
              <Input type="email" v-model="form.contact_email" />
            </div>
          </div>

          <div class="pt-6 flex justify-end gap-3">
            <Link :href="route('projects.index')">
              <Button variant="outline">Cancel</Button>
            </Link>
            <Button :disabled="form.processing" @click="submit">
              {{ form.processing ? 'Saving...' : 'Save Changes' }}
            </Button>
          </div>
        </CardContent>
      </Card>
    </section>
  </AppLayout>
</template>
