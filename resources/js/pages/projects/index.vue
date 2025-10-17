<script lang="ts" setup>
import AppLayout from '@/layouts/AppLayout.vue'
import type { Program, Project } from '@/types'
import { MapPin, User, Mail, Wallet, Clock } from 'lucide-vue-next'


// Inertia automatically passes these props from Laravel
defineProps<{
  program: Program | null
  projects: Project[]
}>()
</script>

<template>
  <AppLayout>
    <section class="p-6 min-h-screen dark:bg-gray-900">
      <!-- Header -->
      <div class="flex justify-between items-center mb-6">
        <!-- <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-400">
          {{ program ? program.slug.toUpperCase() : 'ALL PROGRAMS' }} Projects
        </h1> -->

        <!-- <a
          href="/programs"
          class="bg-red-600 dark:bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-700 dark:hover:bg-red-600 transition"
        >
          ⬅ Back to Programs
        </a> -->
      </div>

      <!-- Handle Empty Projects -->
      <div
        v-if="projects.length === 0"
        class="text-gray-500 dark:text-gray-300 text-center py-10"
      >
        No projects found for this program.
      </div>

      <!-- Project Cards Grid -->
      <div
        v-else
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
      >
        <div
          v-for="project in projects"
          :key="project.id"
          class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-5 hover:shadow-lg transition hover:scale-[1.02]"
        >
          <h3 class="text-lg font-semibold text-blue-700 dark:text-blue-300 mb-2">
            {{ project.title }}
          </h3>

          <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-3">
            {{ project.description }}
          </p>

          <!-- <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
            <p>📍 Location: {{ project.location }}</p>
            <p>👨‍🔬 Leader: {{ project.project_leader }}</p>
            <p>📧 Email: {{ project.contact_email }}</p>
            <p>💰 Budget: ₱{{ project.budget.toLocaleString() }}</p>
            <p>🕓 {{ formatDate(project.start_date) }} → {{ formatDate(project.end_date) }}</p>
          </div> -->
          <div class="text-xs text-gray-600 dark:text-gray-400 space-y-1 mt-3">
            <p class="flex items-center gap-1.5">
                <MapPin class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" />
                <span class="truncate">{{ project.location }}</span>
            </p>

            <p class="flex items-center gap-1.5">
                <User class="w-3.5 h-3.5 text-indigo-600 dark:text-indigo-400" />
                <span class="truncate">{{ project.project_leader }}</span>
            </p>

            <p class="flex items-center gap-1.5">
                <Mail class="w-3.5 h-3.5 text-red-600 dark:text-red-400" />
                <span class="truncate">{{ project.contact_email }}</span>
            </p>

            <p class="flex items-center gap-1.5">
                <Wallet class="w-3.5 h-3.5 text-green-600 dark:text-green-400" />
                <span>₱{{ project.budget.toLocaleString() }}</span>
            </p>

            <p class="flex items-center gap-1.5">
                <Clock class="w-3.5 h-3.5 text-yellow-600 dark:text-yellow-400" />
                <span>{{ formatDate(project.start_date) }} → {{ formatDate(project.end_date) }}</span>
            </p>
        </div>


          <!-- Status Badge -->
          <div class="mt-3 flex justify-between items-center">
            <span
              class="text-xs uppercase px-2 py-1 rounded-full font-semibold"
                :class="{
                // ✅ Completed
                'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200': project.status === 'completed',

                // ✅ Ongoing
                'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200': project.status === 'ongoing',

                // ✅ Planning (unchanged)
                'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200': project.status === 'planning',

                // ✅ Terminated
                'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200': project.status === 'terminated',

                // ✅ Continuing
                'bg-blue-100 text-blue-700 dark:bg-blue-800 dark:text-blue-200': project.status === 'continuing',

                // ✅ Graduated
                'bg-purple-100 text-purple-700 dark:bg-purple-800 dark:text-purple-200': project.status === 'graduated',

                // ✅ Grace Period
                'bg-orange-100 text-orange-700 dark:bg-orange-800 dark:text-orange-200': project.status === 'grace_period',

                // ✅ Liquidated
                'bg-emerald-100 text-emerald-700 dark:bg-emerald-800 dark:text-emerald-200': project.status === 'liquidated',

                // ✅ Unliquidated
                'bg-rose-100 text-rose-700 dark:bg-rose-800 dark:text-rose-200': project.status === 'unliquidated',
                }"
            >
              {{ project.status }}
            </span>
            <a
              :href="`/projects/${project.id}`"
              class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:underline"
            >
              View Details →
            </a>
          </div>
        </div>
      </div>
    </section>
  </AppLayout>
</template>

<script lang="ts">
// 🧠 Simple date formatting helper
function formatDate(value: string | Date): string {
  if (!value) return 'N/A'
  const date = new Date(value)
  return date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  })
}
</script>
