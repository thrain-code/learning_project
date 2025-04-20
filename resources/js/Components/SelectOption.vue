<script setup lang="ts">
import { computed } from 'vue';
import type { SelectProps, SelectOption } from '../types/form';
import { ChevronDownIcon } from '@heroicons/vue/20/solid'; 

const props = defineProps<SelectProps & {
  variant?: 'primary' | 'secondary' | 'success' | 'warning' | 'danger';
  rounded?: 'sm' | 'md' | 'lg' | 'xl' | 'full';
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | null): void
}>();

const colorClasses = computed(() => {
  const variants = {
    primary: {
      border: 'border-emerald-500/30',
      focus: 'focus:border-emerald-500 focus:ring-emerald-500/20',
      hover: 'hover:border-emerald-500/50',
      icon: 'text-emerald-400',
      chevron: 'text-emerald-400'
    },
    secondary: {
      border: 'border-blue-500/30',
      focus: 'focus:border-blue-500 focus:ring-blue-500/20',
      hover: 'hover:border-blue-500/50',
      icon: 'text-blue-400',
      chevron: 'text-blue-400'
    },
    success: {
      border: 'border-green-500/30',
      focus: 'focus:border-green-500 focus:ring-green-500/20',
      hover: 'hover:border-green-500/50',
      icon: 'text-green-400',
      chevron: 'text-green-400'
    },
    warning: {
      border: 'border-amber-500/30',
      focus: 'focus:border-amber-500 focus:ring-amber-500/20',
      hover: 'hover:border-amber-500/50',
      icon: 'text-amber-400',
      chevron: 'text-amber-400'
    },
    danger: {
      border: 'border-red-500/30',
      focus: 'focus:border-red-500 focus:ring-red-500/20',
      hover: 'hover:border-red-500/50',
      icon: 'text-red-400',
      chevron: 'text-red-400'
    }
  };
  return variants[props.variant || 'primary'];
});

const roundedClass = computed(() => {
  return {
    sm: 'rounded-sm',
    md: 'rounded-md',
    lg: 'rounded-lg',
    xl: 'rounded-xl',
    full: 'rounded-full'
  }[props.rounded || 'lg'];
});

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
        class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 transition-colors duration-200"
        :class="colorClasses.icon"
      />
      
      <select
        v-model="selectedValue"
        :class="[
          'bg-zinc-800/70 px-3.5 py-3 w-full text-zinc-100',
          'border-2 shadow-sm focus:outline-none',
          'transition-all duration-200 font-[450] placeholder-zinc-400/90',
          'appearance-none autocomplete-height-fix disabled:opacity-60 disabled:cursor-not-allowed',
          roundedClass,
          colorClasses.border,
          colorClasses.hover,
          colorClasses.focus,
          { 
            'pl-10': icon, 
            'pl-3.5': !icon,
            'border-red-400/80 focus:border-red-400 focus:ring-red-400/30': error
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
          class="w-5 h-5 transition-colors"
          :class="error ? 'text-red-400' : colorClasses.chevron" 
        />
      </div>
    </div>
  </div>
</template>