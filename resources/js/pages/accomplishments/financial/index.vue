<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Search, PlusCircle } from 'lucide-vue-next'
import { ref, watch } from 'vue'

const props = defineProps<{
  accomplishments: {
    data: Array<{
      id: number
      project_title: string
      implementing_year: number
      budget_utilized: number
      status: string
    }>
    links: Array<{ url: string | null; label: string; active: boolean }>
    current_page: number
    last_page: number
    total: number
  }
  filters?: {
    search?: string
  }
}>()

// Search state synced with controller filters
const search = ref(props.filters?.search || '')

// 🔍 Automatically fetch new data when user types
watch(search, (value) => {
  router.get(
    route('financial.index'),
    { search: value },
    { preserveState: true, replace: true }
  )
})
</script>

<template>
  <AppLayout>
    <Head title="Financial Accomplishments" />

    <section class="max-w-full mx-auto py-10 px-4 md:px-8 space-y-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            Financial Accomplishments
          </h1>
          <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Overview of project fund utilization and financial performance.
          </p>
        </div>
        <Link :href="route('financial.create')">
          <Button
            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white"
          >
            <PlusCircle class="w-4 h-4" /> Add Record
          </Button>
        </Link>
      </div>

      <!-- Search Bar -->
      <div class="flex items-center gap-2 w-full md:w-1/3">
        <Search class="w-4 h-4 text-gray-500 dark:text-gray-400" />
        <Input
          v-model="search"
          placeholder="Search project title..."
          class="dark:bg-gray-800 dark:text-gray-100"
        />
      </div>

      <!-- Full-Width Table -->
      <div
        class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm"
      >
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead>
            <tr
              class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-sm uppercase"
            >
              <th class="px-4 py-3 text-left">Project Title</th>
              <th class="px-4 py-3 text-left">Year</th>
              <th class="px-4 py-3 text-left">Budget Utilized (₱)</th>
              <th class="px-4 py-3 text-left">Status</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            <tr
              v-for="acc in accomplishments.data"
              :key="acc.id"
              class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors duration-150"
            >
              <td class="px-4 py-3 text-sm dark:text-gray-100">
                {{ acc.project_title }}
              </td>
              <td class="px-4 py-3 text-sm">{{ acc.implementing_year }}</td>
              <td class="px-4 py-3 text-sm">
                ₱{{ Number(acc.budget_utilized).toLocaleString() }}
              </td>
              <td class="px-4 py-3">
                <span
                  class="inline-flex px-2 py-1 rounded-full text-xs font-medium capitalize"
                  :class="{
                    'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400': acc.status === 'ongoing',
                    'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400': acc.status === 'completed',
                    'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400': acc.status === 'continuing',
                    'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400': acc.status === 'terminated',
                    'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-400': acc.status === 'graduated',
                    'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400': acc.status === 'grace_period',
                    'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400': acc.status === 'liquidated',
                    'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400': acc.status === 'unliquidated',
                  }"
                >
                  {{ acc.status.replace('_', ' ') }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-center gap-2 text-sm">
                  <!-- Edit Button -->
                  <Link
                    :href="route('financial.edit', acc.id)"
                    class="inline-flex items-center px-2 py-1 rounded-md font-medium
                      text-blue-600 hover:text-blue-700 hover:bg-blue-50
                      dark:text-blue-400 dark:hover:text-blue-300 dark:hover:bg-blue-900/40
                      transition-colors duration-150"
                  >
                    Edit
                  </Link>

                  <!-- View Button -->
                  <Link
                    :href="route('financial.show', acc.id)"
                    class="inline-flex items-center px-2 py-1 rounded-md font-medium
                      text-gray-600 hover:text-gray-800 hover:bg-gray-100
                      dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-800/60
                      transition-colors duration-150"
                  >
                    View
                  </Link>
                </div>
              </td>
            </tr>
            <tr v-if="!accomplishments.data.length">
              <td
                colspan="5"
                class="py-6 text-center text-gray-500 dark:text-gray-400"
              >
                No records found.
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div
        v-if="accomplishments.links.length > 3"
        class="flex justify-center items-center gap-2 mt-6 flex-wrap"
      >
        <Link
          v-for="link in accomplishments.links"
          :key="link.label"
          :href="link.url || '#'"
          class="px-3 py-1 rounded text-sm transition-all border"
          :class="{
            'bg-blue-600 text-white border-blue-600 dark:bg-blue-500 dark:border-blue-500': link.active,
            'text-gray-700 dark:text-gray-300 border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800':
              !link.active && link.url,
            'opacity-50 cursor-not-allowed': !link.url,
          }"
        >
          <span v-if="link.label.includes('&laquo;')">«</span>
          <span v-else-if="link.label.includes('&raquo;')">»</span>
          <span v-else>{{ link.label }}</span>
        </Link>
      </div>
    </section>
  </AppLayout>
</template>

