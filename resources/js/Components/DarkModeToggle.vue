<template>
  <div class="flex space-x-2">
    <button @click="setTheme('light')" class="p-2 bg-gray-300 dark:bg-gray-700 text-black dark:text-white rounded">
      ☀️ Light
    </button>
    <button @click="setTheme('dark')" class="p-2 bg-gray-300 dark:bg-gray-700 text-black dark:text-white rounded">
      🌙 Dark
    </button>
    <button @click="setTheme('system')" class="p-2 bg-gray-300 dark:bg-gray-700 text-black dark:text-white rounded">
      🖥️ System
    </button>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';

const setTheme = (theme) => {
  if (theme === "dark") {
    document.documentElement.classList.add("dark");
    localStorage.setItem("theme", "dark");
  } else if (theme === "light") {
    document.documentElement.classList.remove("dark");
    localStorage.setItem("theme", "light");
  } else {
    localStorage.removeItem("theme");
    applySystemTheme();
  }
};

const applySystemTheme = () => {
  const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
  document.documentElement.classList.toggle("dark", systemDark);
};

onMounted(() => {
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme) {
    setTheme(savedTheme);
  } else {
    applySystemTheme();
  }
});
</script>
