<template>
  <button
    :class="[buttonClasses, customClass]"
    :disabled="disabled || loading"
    @click="$emit('click')"
  >
    <div class="flex items-center justify-center w-full gap-2 relative">
      <div v-if="loading" class="absolute inset-0 flex items-center justify-center">
        <svg
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
      </div>

      <component
        v-if="icon && iconPosition === 'left' && !loading"
        :is="icon"
        class="h-5 w-5 flex-shrink-0"
      />

      <span :class="{ 'opacity-0': loading }">
        <slot />
      </span>

      <component
        v-if="icon && iconPosition === 'right' && !loading"
        :is="icon"
        class="h-5 w-5 flex-shrink-0"
      />
    </div>
  </button>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Component } from 'vue';

const props = defineProps({
  variant: {
    type: String as () => 'primary' | 'secondary' | 'success' | 'warning' | 'danger' | 'dark' | 'light',
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
  theme: {
    type: String as () => 'light' | 'dark',
    default: 'light',
  },
  rounded: {
    type: String as () => 'sm' | 'md' | 'lg' | 'xl' | 'full',
    default: 'xl',
  }
});

defineEmits(['click']);

const buttonClasses = computed(() => {
  return [
    'font-semibold transition-all duration-300 transform',
    'hover:scale-[1.02] active:scale-95',
    'shadow-lg hover:shadow-xl',
    'flex items-center justify-center',
    sizeClasses.value,
    widthClasses.value,
    variantClasses.value,
    roundedClass.value,
    { 'opacity-70 cursor-not-allowed hover:scale-100 active:scale-100': props.disabled }
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

const roundedClass = computed(() => {
  return {
    sm: 'rounded-sm',
    md: 'rounded-md',
    lg: 'rounded-lg',
    xl: 'rounded-xl',
    full: 'rounded-full'
  }[props.rounded];
});

const themeColorMappings = computed(() => {
  const lightTheme = {
    primary: {
      base: 'bg-emerald-500 text-white',
      hover: 'hover:bg-emerald-600',
      active: 'active:bg-emerald-700',
      shadow: 'shadow-emerald-300/30',
      hoverShadow: 'hover:shadow-emerald-400/40'
    },
    secondary: {
      base: 'bg-blue-500 text-white',
      hover: 'hover:bg-blue-600',
      active: 'active:bg-blue-700',
      shadow: 'shadow-blue-300/30',
      hoverShadow: 'hover:shadow-blue-400/40'
    },
    success: {
      base: 'bg-green-500 text-white',
      hover: 'hover:bg-green-600',
      active: 'active:bg-green-700',
      shadow: 'shadow-green-300/30',
      hoverShadow: 'hover:shadow-green-400/40'
    },
    warning: {
      base: 'bg-amber-500 text-white',
      hover: 'hover:bg-amber-600',
      active: 'active:bg-amber-700',
      shadow: 'shadow-amber-300/30',
      hoverShadow: 'hover:shadow-amber-400/40'
    },
    danger: {
      base: 'bg-red-500 text-white',
      hover: 'hover:bg-red-600',
      active: 'active:bg-red-700',
      shadow: 'shadow-red-300/30',
      hoverShadow: 'hover:shadow-red-400/40'
    },
    dark: {
      base: 'bg-gray-700 text-white',
      hover: 'hover:bg-gray-800',
      active: 'active:bg-gray-900',
      shadow: 'shadow-gray-400/20',
      hoverShadow: 'hover:shadow-gray-500/30'
    },
    light: {
      base: 'bg-white text-gray-700 border border-gray-200',
      hover: 'hover:bg-gray-50',
      active: 'active:bg-gray-100',
      shadow: 'shadow-gray-200/50',
      hoverShadow: 'hover:shadow-gray-300/60'
    }
  };

  const darkTheme = {
    primary: {
      base: 'bg-emerald-700 text-white',
      hover: 'hover:bg-emerald-800',
      active: 'active:bg-emerald-900',
      shadow: 'shadow-emerald-900/30',
      hoverShadow: 'hover:shadow-emerald-900/50'
    },
    secondary: {
      base: 'bg-blue-700 text-white',
      hover: 'hover:bg-blue-800',
      active: 'active:bg-blue-900',
      shadow: 'shadow-blue-900/30',
      hoverShadow: 'hover:shadow-blue-900/50'
    },
    success: {
      base: 'bg-green-700 text-white',
      hover: 'hover:bg-green-800',
      active: 'active:bg-green-900',
      shadow: 'shadow-green-900/30',
      hoverShadow: 'hover:shadow-green-900/50'
    },
    warning: {
      base: 'bg-amber-700 text-white',
      hover: 'hover:bg-amber-800',
      active: 'active:bg-amber-900',
      shadow: 'shadow-amber-900/30',
      hoverShadow: 'hover:shadow-amber-900/50'
    },
    danger: {
      base: 'bg-red-700 text-white',
      hover: 'hover:bg-red-800',
      active: 'active:bg-red-900',
      shadow: 'shadow-red-900/30',
      hoverShadow: 'hover:shadow-red-900/50'
    },
    dark: {
      base: 'bg-gray-900 text-white',
      hover: 'hover:bg-black',
      active: 'active:bg-black',
      shadow: 'shadow-black/40',
      hoverShadow: 'hover:shadow-black/60'
    },
    light: {
      base: 'bg-gray-800 text-white border border-gray-700',
      hover: 'hover:bg-gray-700',
      active: 'active:bg-gray-600',
      shadow: 'shadow-black/30',
      hoverShadow: 'hover:shadow-black/50'
    }
  };

  return props.theme === 'dark' ? darkTheme : lightTheme;
});

const variantClasses = computed(() => {
  const themeColors = themeColorMappings.value;
  const currentColor = themeColors[props.variant];
  
  return [
    currentColor.base,
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