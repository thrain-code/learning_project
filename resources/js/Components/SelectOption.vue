<script setup lang="ts">
import { computed } from 'vue';
import type { SelectProps, SelectOption } from '../types/form';
import { ChevronDownIcon } from '@heroicons/vue/20/solid'; 

const props = defineProps<SelectProps>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | null): void
}>();

const selectedValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
});
</script>

<template>
  <div class="space-y-1.5">
    <label class="block text-sm font-medium text-zinc-300/90 mb-1.5">
      {{ label }}
      <span v-if="required" class="text-red-400/90 ml-0.5">*</span>
    </label>
    
    <div class="relative group">
      <component
        :is="icon"
        v-if="icon"
        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400 
               transition-colors duration-200 group-focus-within:text-emerald-400"
      />
      
      <select
        v-model="selectedValue"
        :class="[
          'bg-zinc-800/70 px-3.5 py-3 w-full text-zinc-100',
          'rounded-lg border-2 border-zinc-700/80 shadow-sm',
          'focus:outline-none focus:border-emerald-500',
          'hover:border-zinc-600 transition-all duration-200',
          'text-md font-[450] placeholder-zinc-400/90',
          'appearance-none autocomplete-height-fix',
          'disabled:opacity-60 disabled:cursor-not-allowed',
          { 
            'pl-10': icon, 
            'pl-3.5': !icon,
            'border-red-400/80': error,
            'focus:border-red-400 focus:ring-red-400/30': error
          }
        ]"
      >
        <option 
          v-if="placeholder" 
          :value="null" 
          disabled 
          selected
          class="text-zinc-400/90 italic bg-zinc-700/50"
        >
          {{ placeholder }}
        </option>
        <option
          v-for="option in options"
          :key="option.value"
          :value="option.value"
          class="bg-zinc-800 text-zinc-100 hover:bg-emerald-500/20"
        >
          {{ option.label }}
        </option>
      </select>
      
      <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center px-2">
        <ChevronDownIcon 
          class="w-5 h-5 text-zinc-400/90 group-focus-within:text-emerald-400 transition-colors" 
        />
      </div>
    </div>
  </div>
</template>