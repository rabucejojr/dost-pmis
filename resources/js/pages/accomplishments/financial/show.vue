<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card'
// import { Button } from '@/components/ui/button'

defineProps<{ accomplishment: any }>()
</script>

<template>
  <AppLayout>
    <Head :title="accomplishment.project_title" />
    <section class="max-w-3xl mx-auto py-10 px-6 space-y-6">
      <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
          {{ accomplishment.project_title }}
        </h1>
        <Link :href="route('financial.index')" class="text-blue-600 hover:underline dark:text-blue-400">
          ← Back
        </Link>
      </div>

      <Card class="dark:bg-gray-900 dark:border-gray-700">
        <CardHeader><CardTitle>Financial Details</CardTitle></CardHeader>
        <CardContent class="space-y-3 text-gray-700 dark:text-gray-300">
          <p><strong>Implementing Year:</strong> {{ accomplishment.implementing_year }}</p>
          <p><strong>Budget Utilized:</strong> ₱{{ accomplishment.budget_utilized.toLocaleString() }}</p>
          <p><strong>Status:</strong> {{ accomplishment.status.replace('_', ' ') }}</p>
        </CardContent>
      </Card>
    </section>
  </AppLayout>
</template>
