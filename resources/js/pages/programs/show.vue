<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import {route} from 'ziggy-js';

defineProps<{
  program: {
    id: number
    program_name: string
    description: string
    slug: string
    type: string
  }
}>()
</script>

<template>
  <div class="max-w-4xl mx-auto py-10">
    <Link
      :href="route('programs.index')"
      class="text-blue-600 hover:underline mb-4 inline-block"
    >
      ← Back to Programs
    </Link>

    <div class="bg-white shadow rounded-xl p-6">
      <h2 class="text-2xl font-bold text-blue-700 mb-2">
        {{ program.program_name }}
      </h2>
      <!-- <p class="text-gray-500 text-sm mb-4">Slug: {{ program.slug }}</p> -->
      <p class="text-gray-700 leading-relaxed">{{ program.description }}</p>
    </div>
  </div>
</template>
