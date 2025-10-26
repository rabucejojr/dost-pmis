<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { PlusCircle, Eye, Edit } from 'lucide-vue-next'
import { route } from 'ziggy-js'

// Simulated data to display in table
const accomplishments = [
  { id: 1, title: 'Deployment of STARBOOKS Units at Tubod NHS', status: 'Completed' },
  { id: 2, title: 'Installation of CEST Solar-Powered Water System', status: 'Ongoing' },
  { id: 3, title: 'RxBox Telemedicine Deployment at Malimono District Hospital', status: 'For Completion' },
]
</script>

<template>
  <AppLayout>
    <Head title="Physical Accomplishments" />

    <div class="p-6 space-y-6">
      <!-- Header section -->
      <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">Physical Accomplishments (DOST-SDN)</h1>

        <!-- ✅ Route to CREATE page -->
        <Link
          :href="route('physical.create')"
          class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700"
        >
          <PlusCircle class="w-4 h-4" />
          Add New
        </Link>
      </div>

      <!-- Simulated Table -->
      <div class="bg-white dark:bg-gray-900 shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-2 text-left">Project Title</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="acc in accomplishments"
              :key="acc.id"
              class="border-b dark:border-gray-700"
            >
              <td class="px-4 py-2">{{ acc.title }}</td>
              <td class="px-4 py-2">{{ acc.status }}</td>
              <td class="px-4 py-2 flex justify-center gap-2">
                <!-- ✅ Route to SHOW page -->
                <Link
                  :href="route('physical.show', acc.id)"
                  class="inline-flex items-center gap-1 text-blue-600 hover:underline"
                >
                  <Eye class="w-4 h-4" /> View
                </Link>

                <!-- ✅ Route to EDIT page -->
                <Link
                  :href="route('physical.edit', acc.id)"
                  class="inline-flex items-center gap-1 text-green-600 hover:underline"
                >
                  <Edit class="w-4 h-4" /> Edit
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
