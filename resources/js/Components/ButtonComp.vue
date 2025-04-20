<template>
  <button
    :class="[buttonClasses, customClass]"
    :disabled="disabled || loading"
    @click="$emit('click')"
  >
    <svg
      v-if="loading"
      class="animate-spin h-5 w-5"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle
        class="opacity-25"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
      ></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
      ></path>
    </svg>

    <component
      v-if="icon && iconPosition === 'left' && !loading"
      :is="icon"
      class="h-5 w-5"
    />

    <span :class="{ 'opacity-0': loading }">
      <slot />
    </span>

    <component
      v-if="icon && iconPosition === 'right' && !loading"
      :is="icon"
      class="h-5 w-5"
    />
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Component } from 'vue';

const props = defineProps({
  variant: {
    type: String as () => 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'indigo',
    default: 'primary',
  },
  size: {
    type: String as () => 'sm' | 'md' | 'lg',
    default: 'md',
  },
  width: {
    type: [String, Number] as unknown as () => 'full' | 'fit' | number,
    default: 'full'
  },
  icon: {
    type: Object as () => Component,
    default: null,
  },
  iconPosition: {
    type: String as () => 'left' | 'right',
    default: 'left',
  },
  disabled: Boolean,
  loading: Boolean,
  customClass: String,
});

defineEmits(['click']);

const buttonClasses = computed(() => {
  return [
    'py-3.5 text-white font-semibold rounded-xl',
    'transition-all duration-300 transform',
    'hover:scale-[1.02] active:scale-95',
    'shadow-lg hover:shadow-xl',
    sizeClasses.value,
    widthClasses.value,
    variantClasses.value,
  ];
});

const widthClasses = computed(() => {
  if (typeof props.width === 'number') {
    return `w-${props.width}`
  }
  return {
    full: 'w-full',
    fit: 'w-fit'
  }[props.width]
});

const sizeClasses = computed(() => {
  return {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-base',
    lg: 'px-6 py-3 text-lg',
  }[props.size];
});

const variantClasses = computed(() => {
  const colors = {
    primary: {
      bg: 'bg-emerald-600',
      hover: 'hover:bg-emerald-700',
      active: 'active:bg-emerald-800',
      shadow: 'shadow-emerald-900/20',
      hoverShadow: 'hover:shadow-emerald-900/30'
    },
    secondary: {
      bg: 'bg-blue-600',
      hover: 'hover:bg-blue-700',
      active: 'active:bg-blue-800',
      shadow: 'shadow-blue-900/20',
      hoverShadow: 'hover:shadow-blue-900/30'
    },
    success: {
      bg: 'bg-green-600',
      hover: 'hover:bg-green-700',
      active: 'active:bg-green-800',
      shadow: 'shadow-green-900/20',
      hoverShadow: 'hover:shadow-green-900/30'
    },
    warning: {
      bg: 'bg-amber-600',
      hover: 'hover:bg-amber-700',
      active: 'active:bg-amber-800',
      shadow: 'shadow-amber-900/20',
      hoverShadow: 'hover:shadow-amber-900/30'
    },
    danger: {
      bg: 'bg-red-600',
      hover: 'hover:bg-red-700',
      active: 'active:bg-red-800',
      shadow: 'shadow-red-900/20',
      hoverShadow: 'hover:shadow-red-900/30'
    },
    indigo: {
      bg: 'bg-indigo-600',
      hover: 'hover:bg-indigo-700',
      active: 'active:bg-indigo-800',
      shadow: 'shadow-indigo-900/20',
      hoverShadow: 'hover:shadow-indigo-900/30'
    }
  };
  
  const currentColor = colors[props.variant];
  return [
    currentColor.bg,
    currentColor.hover,
    currentColor.active,
    currentColor.shadow,
    currentColor.hoverShadow
  ].join(' ');
});
</script>

<style scoped>
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>