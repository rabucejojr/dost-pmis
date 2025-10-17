<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import type { Project,Program } from '@/types'
import { Head, Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, PencilIcon } from 'lucide-vue-next'
import { MapPin, Wallet, Clock, User, Mail, Brain } from 'lucide-vue-next'



// Props from Inertia
defineProps<{
    project: Project,
    program: Program,
 }>()
</script>

<template>
  <AppLayout>
    <Head :title="project.title" />

    <section class="min-h-screen p-6 dark:bg-gray-900">
      <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <!-- Header -->
        <div class="flex justify-between items-start mb-6">
          <div>
            <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-400 mb-2">
              {{ project.title }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              <Link
                :href="`/projects?program=${project.program_id}`"
                class="text-blue-600 dark:text-blue-400 hover:underline"
              >
                {{ project.program?.program_name || 'Unknown Program' }}
              </Link>
            </p>
          </div>

          <!-- Status -->
          <span
            class="text-xs uppercase font-semibold px-3 py-1 rounded-full"
            :class="{
              'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200': project.status === 'completed',
              'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200': project.status === 'ongoing',
              'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200': project.status === 'planning',
            }"
          >
            {{ project.status }}
          </span>
        </div>

        <!-- Description -->
        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6 text-justify">
          {{ project.description }}
        </p>

        <!-- Details Grid -->
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-600 dark:text-gray-300">
          <div>
            <p><strong>📍 Location:</strong> {{ project.location }}</p>
            <p><strong>💰 Budget:</strong> ₱{{ project.budget.toLocaleString() }}</p>
            <p><strong>🕓 Duration:</strong> {{ formatDate(project.start_date) }} – {{ formatDate(project.end_date) }}</p>
          </div>

          <div>
            <p><strong>👨‍🔬 Leader:</strong> {{ project.project_leader }}</p>
            <p><strong>📧 Email:</strong> {{ project.contact_email }}</p>
            <p><strong>🧠 Created By (User ID):</strong> {{ project.user_id }}</p>
          </div>
        </div> -->

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-gray-600 dark:text-gray-300 mt-6">
            <!-- Left Column -->
            <div class="space-y-3">
                <p class="flex items-center gap-2">
                <MapPin class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <strong class="font-semibold">Location:</strong>
                <span>{{ project.location }}</span>
                </p>

                <p class="flex items-center gap-2">
                <Wallet class="w-4 h-4 text-green-600 dark:text-green-400" />
                <strong class="font-semibold">Budget:</strong>
                <span>₱{{ project.budget.toLocaleString() }}</span>
                </p>

                <p class="flex items-center gap-2">
                <Clock class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                <strong class="font-semibold">Duration:</strong>
                <span>{{ formatDate(project.start_date) }} – {{ formatDate(project.end_date) }}</span>
                </p>
            </div>

            <!-- Right Column -->
            <div class="space-y-3">
                <p class="flex items-center gap-2">
                <User class="w-4 h-4 text-indigo-600 dark:text-indigo-400" />
                <strong class="font-semibold">Leader:</strong>
                <span>{{ project.project_leader }}</span>
                </p>

                <p class="flex items-center gap-2">
                <Mail class="w-4 h-4 text-red-600 dark:text-red-400" />
                <strong class="font-semibold">Email:</strong>
                <span>{{ project.contact_email }}</span>
                </p>

                <p class="flex items-center gap-2">
                <Brain class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                <strong class="font-semibold">Created By (User ID):</strong>
                <span>{{ project.user_id }}</span>
                </p>
            </div>
            </div>


        <!-- Footer -->
       <div
  class="mt-8 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3 sm:gap-0"
>
  <!-- Back Button -->
  <Link
    :href="`/projects?program=${project.program_id}`"
    class="group inline-flex justify-center sm:justify-start items-center gap-2
           bg-red-700 dark:bg-red-600
           text-white font-medium
           px-4 py-2 rounded-lg
           shadow-sm hover:shadow-md
           hover:bg-red-800 dark:hover:bg-red-700
           active:scale-[0.98]
           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400
           transition-all duration-150 ease-in-out
           w-full sm:w-auto"
  >
    <ChevronLeftIcon
      class="w-4 h-4 text-white transition-transform duration-150 group-hover:-translate-x-1"
    />
    <span class="tracking-wide">Back to Projects</span>
  </Link>

  <!-- Edit Button -->
  <Link
    :href="`/projects/${project.id}/edit`"
    class="group inline-flex justify-center sm:justify-end items-center gap-2
           bg-blue-700 dark:bg-blue-600
           text-white font-medium
           px-4 py-2 rounded-lg
           shadow-sm hover:shadow-md
           hover:bg-blue-800 dark:hover:bg-blue-700
           active:scale-[0.98]
           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400
           transition-all duration-150 ease-in-out
           w-full sm:w-auto"
  >
    <PencilIcon
      class="w-4 h-4 text-white transition-transform duration-150 group-hover:-rotate-6"
    />
    <span class="tracking-wide">Edit Project</span>
  </Link>
</div>

      </div>
    </section>
  </AppLayout>
</template>

<script lang="ts">
// 🧠 date formatter helper
function formatDate(value: string | Date): string {
  if (!value) return 'N/A'
  const date = new Date(value)
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>
