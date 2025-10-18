<script lang="ts" setup>
import { Head, Link, router } from '@inertiajs/vue3'
import {route} from 'ziggy-js'

const logout = () => {
  router.post(route('logout'))
}
</script>

<template>
  <Head title="User Page" />
  <div class="p-8 text-gray-800 dark:text-gray-100">
    <h1 class="text-2xl font-bold mb-4">User Logged In</h1>
    <p>Welcome, {{ $page.props.auth.user.name }}!</p>

    <button
      @click="logout"
      class="mt-6 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
    >
      Logout
    </button>
  </div>
</template>
