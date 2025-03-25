<template>
  <div class="min-h-screen bg-white dark:bg-gray-900 text-black dark:text-white">
    <header class="p-4 flex justify-between">
      <h1>Dashboard</h1>
      <DarkModeToggle />
    </header>
    <main class="p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
import DarkModeToggle from "@/Components/DarkModeToggle.vue";
</script>
