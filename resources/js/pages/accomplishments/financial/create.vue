<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { useForm, Head, Link } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Label } from '@/components/ui/label'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'

const form = useForm({
  project_title: '',
  implementing_year: new Date().getFullYear(),
  budget_utilized: 0,
  status: 'ongoing',
})

const statuses = [
  'ongoing', 'completed', 'terminated',
  'continuing', 'graduated', 'grace_period',
  'liquidated', 'unliquidated'
]

const submit = () => form.post(route('financial.store'))
</script>

<template>
  <AppLayout>
    <Head title="Add Financial Accomplishment" />
    <section class="max-w-3xl mx-auto py-10 px-6 space-y-8">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Add Financial Record</h1>
        <Link :href="route('financial.index')" class="text-blue-600 hover:underline dark:text-blue-400">← Back</Link>
      </div>

      <Card class="dark:bg-gray-900 dark:border-gray-700">
        <CardHeader><CardTitle>Record Details</CardTitle></CardHeader>
        <CardContent class="space-y-4">
          <div>
            <Label>Project Title</Label>
            <Input v-model="form.project_title" placeholder="Enter project title" />
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <Label>Implementing Year</Label>
              <Input type="number" v-model="form.implementing_year" />
            </div>
            <div>
              <Label>Status</Label>
              <select v-model="form.status" class="w-full p-2.5 rounded-md border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100">
                <option v-for="s in statuses" :key="s" :value="s">{{ s.replace('_', ' ') }}</option>
              </select>
            </div>
            <div>
              <Label>Budget Utilized (₱)</Label>
              <Input type="number" v-model="form.budget_utilized" min="0" />
            </div>
          </div>

          <div class="flex justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <Link :href="route('financial.index')"><Button variant="outline">Cancel</Button></Link>
            <Button @click="submit" :disabled="form.processing">
              {{ form.processing ? 'Saving...' : 'Save Record' }}
            </Button>
          </div>
        </CardContent>
      </Card>
    </section>
  </AppLayout>
</template>
