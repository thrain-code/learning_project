<script setup lang="ts">
import { computed } from 'vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import type { Component } from 'vue';

export interface SelectOption {
  value: string | number;
  label: string;
}

export interface SelectProps {
  options: SelectOption[];
  label: string;
  modelValue: string | number | null;
  placeholder?: string;
  required?: boolean;
  error?: boolean;
  icon?: Component;
  theme?: 'dark' | 'light';
}

const props = defineProps<SelectProps & {
  variant?: 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'dark' | 'light';
  rounded?: 'sm' | 'md' | 'lg' | 'xl' | 'full';
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | null): void
}>();

const themeClasses = computed(() => ({
  label: props.theme === 'dark' ? 'text-zinc-300' : 'text-zinc-700',
  input: props.theme === 'dark' 
    ? 'bg-zinc-800/50 text-white placeholder-zinc-500/80' 
    : 'bg-white text-zinc-900 placeholder-zinc-400'
}));

const colorClasses = computed(() => {
  const isDark = props.theme === 'dark';
  
  const variants = {
    primary: {
      base: isDark ? 'border-emerald-500/30' : 'border-emerald-600/60',
      focus: isDark ? 'focus:border-emerald-500 focus:ring-emerald-500/30' : 'focus:border-emerald-600 focus:ring-emerald-600/30',
      hover: isDark ? 'hover:border-emerald-500/50' : 'hover:border-emerald-600/50',
      icon: isDark ? 'text-emerald-500' : 'text-emerald-600',
      chevron: isDark ? 'text-emerald-500' : 'text-emerald-600'
    },
    secondary: {
      base: isDark ? 'border-blue-500/30' : 'border-blue-600/60',
      focus: isDark ? 'focus:border-blue-500 focus:ring-blue-500/30' : 'focus:border-blue-600 focus:ring-blue-600/30',
      hover: isDark ? 'hover:border-blue-500/50' : 'hover:border-blue-600/50',
      icon: isDark ? 'text-blue-500' : 'text-blue-600',
      chevron: isDark ? 'text-blue-500' : 'text-blue-600'
    },
    success: {
      base: isDark ? 'border-green-500/30' : 'border-green-600/60',
      focus: isDark ? 'focus:border-green-500 focus:ring-green-500/30' : 'focus:border-green-600 focus:ring-green-600/30',
      hover: isDark ? 'hover:border-green-500/50' : 'hover:border-green-600/50',
      icon: isDark ? 'text-green-500' : 'text-green-600',
      chevron: isDark ? 'text-green-500' : 'text-green-600'
    },
    warning: {
      base: isDark ? 'border-amber-500/30' : 'border-amber-600/60',
      focus: isDark ? 'focus:border-amber-500 focus:ring-amber-500/30' : 'focus:border-amber-600 focus:ring-amber-600/30',
      hover: isDark ? 'hover:border-amber-500/50' : 'hover:border-amber-600/50',
      icon: isDark ? 'text-amber-500' : 'text-amber-600',
      chevron: isDark ? 'text-amber-500' : 'text-amber-600'
    },
    danger: {
      base: isDark ? 'border-red-500/30' : 'border-red-600/60',
      focus: isDark ? 'focus:border-red-500 focus:ring-red-500/30' : 'focus:border-red-600 focus:ring-red-600/30',
      hover: isDark ? 'hover:border-red-500/50' : 'hover:border-red-600/50',
      icon: isDark ? 'text-red-500' : 'text-red-600',
      chevron: isDark ? 'text-red-500' : 'text-red-600'
    },
    dark: {
      base: isDark ? 'border-zinc-700/30' : 'border-zinc-600/60',
      focus: isDark ? 'focus:border-zinc-700 focus:ring-zinc-700/30' : 'focus:border-zinc-600 focus:ring-zinc-600/30',
      hover: isDark ? 'hover:border-zinc-700/50' : 'hover:border-zinc-600/50',
      icon: isDark ? 'text-zinc-400' : 'text-zinc-500',
      chevron: isDark ? 'text-zinc-400' : 'text-zinc-500'
    },
    light: {
      base: isDark ? 'border-zinc-200/30' : 'border-zinc-300/60',
      focus: isDark ? 'focus:border-zinc-200 focus:ring-zinc-200/30' : 'focus:border-zinc-300 focus:ring-zinc-300/30',
      hover: isDark ? 'hover:border-zinc-200/50' : 'hover:border-zinc-300/50',
      icon: isDark ? 'text-zinc-100' : 'text-zinc-400',
      chevron: isDark ? 'text-zinc-100' : 'text-zinc-400'
    }
  };
  
  return variants[props.variant || 'primary'];
});

const roundedClass = computed(() => ({
  sm: 'rounded-sm',
  md: 'rounded-md',
  lg: 'rounded-lg',
  xl: 'rounded-xl',
  full: 'rounded-full'
}[props.rounded || 'lg']));

const selectedValue = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
});
</script>

<template>
  <div>
    <label :class="['block text-sm font-medium mb-2', themeClasses.label]">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    
    <div class="relative">
      <component
        :is="icon"
        v-if="icon"
        class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 transition-colors duration-200"
        :class="colorClasses.icon"
      />
      
      <select
        v-model="selectedValue"
        :class="[
          themeClasses.input,
          'py-3 pr-11 outline-none w-full border-2 transition-all duration-200',
          'appearance-none autocomplete-height-fix',
          roundedClass,
          colorClasses.base,
          colorClasses.hover,
          colorClasses.focus,
          { 'border-red-500 focus:border-red-500 focus:ring-red-500/30': error },
          icon ? 'pl-11' : 'pl-4'
        ]"
      >
        <option 
          v-if="placeholder" 
          :value="null" 
          disabled
          class="opacity-60"
        >
          {{ placeholder }}
        </option>
        <option
          v-for="option in options"
          :key="option.value"
          :value="option.value"
        >
          {{ option.label }}
        </option>
      </select>
      
      <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
        <ChevronDownIcon 
          class="w-5 h-5 transition-colors"
          :class="error ? 'text-red-500' : colorClasses.chevron" 
        />
      </div>
    </div>
  </div>
</template>