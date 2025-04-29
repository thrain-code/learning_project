<script setup lang="ts">
import { computed, type Component } from 'vue';

type InputType = 
  | 'text'
  | 'password'
  | 'email'
  | 'number'
  | 'tel'
  | 'date'
  | 'url'
  | 'search'
  | 'color'
  | 'range'
  | 'hidden'
  | 'file'
  | 'textarea';

interface InputFieldProps<T = any> {
  label: string;
  modelValue: T;
  type?: InputType | string;
  required?: boolean;
  icon?: Component;
  autocomplete?: string;
  placeholder?: string;
  error?: boolean;
  accept?: string;
  theme?: 'dark' | 'light' | string;
}

const props = defineProps<InputFieldProps & {
  variant?: 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'dark' | 'light';
  rounded?: 'sm' | 'md' | 'lg' | 'xl' | 'full';
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: any): void;
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
      focus: isDark ? 'focus:border-emerald-500' : 'focus:border-emerald-600',
      hover: isDark ? 'hover:border-emerald-500/50' : 'hover:border-emerald-600/50',
      icon: isDark ? 'text-emerald-500' : 'text-emerald-600'
    },
    secondary: {
      base: isDark ? 'border-blue-500/30' : 'border-blue-600/60',
      focus: isDark ? 'focus:border-blue-500' : 'focus:border-blue-600',
      hover: isDark ? 'hover:border-blue-500/50' : 'hover:border-blue-600/50',
      icon: isDark ? 'text-blue-500' : 'text-blue-600'
    },
    success: {
      base: isDark ? 'border-green-500/30' : 'border-green-600/60',
      focus: isDark ? 'focus:border-green-500' : 'focus:border-green-600',
      hover: isDark ? 'hover:border-green-500/50' : 'hover:border-green-600/50',
      icon: isDark ? 'text-green-500' : 'text-green-600'
    },
    warning: {
      base: isDark ? 'border-amber-500/30' : 'border-amber-600/60',
      focus: isDark ? 'focus:border-amber-500' : 'focus:border-amber-600',
      hover: isDark ? 'hover:border-amber-500/50' : 'hover:border-amber-600/50',
      icon: isDark ? 'text-amber-500' : 'text-amber-600'
    },
    danger: {
      base: isDark ? 'border-red-500/30' : 'border-red-600/60',
      focus: isDark ? 'focus:border-red-500' : 'focus:border-red-600',
      hover: isDark ? 'hover:border-red-500/50' : 'hover:border-red-600/50',
      icon: isDark ? 'text-red-500' : 'text-red-600'
    },
    dark: {
      base: isDark ? 'border-zinc-700/30' : 'border-zinc-600/60',
      focus: isDark ? 'focus:border-zinc-700' : 'focus:border-zinc-600',
      hover: isDark ? 'hover:border-zinc-700/50' : 'hover:border-zinc-600/50',
      icon: isDark ? 'text-zinc-400' : 'text-zinc-500'
    },
    light: {
      base: isDark ? 'border-zinc-200/30' : 'border-zinc-300/60',
      focus: isDark ? 'focus:border-zinc-200' : 'focus:border-zinc-300',
      hover: isDark ? 'hover:border-zinc-200/50' : 'hover:border-zinc-300/50',
      icon: isDark ? 'text-zinc-100' : 'text-zinc-400'
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

const value = computed({
  get: () => {
    if (props.type === 'number' || props.type === 'range') {
      return String(props.modelValue);
    }
    return props.modelValue;
  },
  set: (val) => {
    let processed = val;
    if (props.type === 'number' || props.type === 'range') {
      processed = Number(val);
    }
    emit('update:modelValue', processed);
  }
});

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:modelValue', target.files?.[0] || null);
};
</script>

<template>
  <div class="w-full">
    <label :class="['block text-sm font-medium mb-2', themeClasses.label]">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="relative w-full">
      <component
        :is="icon"
        v-if="icon"
        class="w-5 h-5 absolute left-3 transition-colors duration-200"
        :class="[
          colorClasses.icon,
          {
            'top-1/2 -translate-y-1/2': type !== 'textarea',
            'top-3': type === 'textarea'
          }
        ]"
      />

      <input
        v-if="type !== 'textarea' && type !== 'file'"
        :type="type || 'text'"
        :required="required"
        v-model="value"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        class="w-full px-4 py-2 sm:py-3 outline-none border-2 transition-all duration-200"
        :class="[
          themeClasses.input,
          roundedClass,
          colorClasses.base,
          colorClasses.hover,
          colorClasses.focus,
          { 
            'border-red-500 focus:border-red-500': error,
            'pl-10': icon,
            'pl-4': !icon
          }
        ]"
      />

      <input
        v-else-if="type === 'file'"
        type="file"
        :required="required"
        @change="handleFileChange"
        :accept="accept"
        class="w-full px-4 py-2 sm:py-3 outline-none border-2 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:rounded-md cursor-pointer"
        :class="[
          themeClasses.input,
          roundedClass,
          colorClasses.base,
          colorClasses.hover,
          colorClasses.focus,
          {
            'border-red-500 focus:border-red-500': error,
            'pl-10': icon,
            'pl-4': !icon
          }
        ]"
      />

      <textarea
        v-else
        :required="required"
        v-model="value"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        rows="4"
        class="w-full px-4 py-2 sm:py-3 outline-none border-2 transition-all duration-200 resize-y"
        :class="[
          themeClasses.input,
          roundedClass,
          colorClasses.base,
          colorClasses.hover,
          colorClasses.focus,
          {
            'border-red-500 focus:border-red-500': error,
            'pl-10': icon,
            'pl-4': !icon
          }
        ]"
      />
    </div>
  </div>
</template>