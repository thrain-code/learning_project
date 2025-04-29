<template>
  <button
    @click="toggleDark"
    class="rounded px-3 py-1 text-sm font-medium transition-colors"
    :class="isDark ? 'text-yellow-400 hover:text-yellow-300' : 'text-zinc-600 hover:text-zinc-800'"
  >
    {{ isDark ? '🌞 Light' : '🌙 Dark' }}
  </button>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const isDark = ref(false)

const toggleDark = () => {
  isDark.value = !isDark.value
  updateHtmlClass()
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light')
}

const updateHtmlClass = () => {
  document.documentElement.classList.toggle('dark', isDark.value)
}

onMounted(() => {
  const savedTheme = localStorage.getItem('theme')
  isDark.value = savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)
  updateHtmlClass()
})
</script>
