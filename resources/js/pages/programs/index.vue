<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import {route} from 'ziggy-js';

defineProps<{
  programs: Array<{
    id: number
    program_name: string
    description: string
    slug: string
    type: string
  }>
}>();
</script>

<template>
  <div class="max-w-7xl mx-auto py-10">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">📚 DOST Programs</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="program in programs"
        :key="program.id"
        class="bg-white shadow-md rounded-xl p-5 hover:shadow-lg transition"
      >
        <h3 class="text-lg font-semibold text-blue-700">{{ program.program_name }}</h3>
        <p class="text-gray-600 text-sm mt-2 line-clamp-3">
          {{ program.description }}
        </p>
        <Link
          :href="route('programs.show', program.id)"
          class="text-blue-600 text-sm font-medium hover:underline mt-3 inline-block"
        >
          View Details →
        </Link>
      </div>
    </div>
  </div>
</template>
