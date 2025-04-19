<script setup lang="ts">
import type { InputFieldProps } from '../types/form';
import { computed } from 'vue';

const props = defineProps<InputFieldProps>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: any): void
}>();

const value = computed({
  get: () => {
    if (props.type === 'number' || props.type === 'range') {
      return String(props.modelValue);
    }
    return props.modelValue;
  },
  set: (value) => {
    let processedValue: any = value;
    
    if (props.type === 'number' || props.type === 'range') {
      processedValue = Number(value);
    }
    
    emit('update:modelValue', processedValue);
  }
});

const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  emit('update:modelValue', target.files?.[0] || null);
};
</script>

<template>
  <div>
    <label class="block text-sm font-medium text-zinc-300 mb-2">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="relative">
      <component
        :is="icon"
        v-if="icon"
        class="w-5 h-5 absolute left-4 transition-colors duration-200 peer-focus:text-emerald-500"
        :class="{
          'top-1/2 -translate-y-1/2': type !== 'textarea',
          'top-3': type === 'textarea'
        }"
      />
      
      <input
        v-if="type !== 'textarea' && type !== 'file'"
        :type="type"
        :required="required"
        v-model="value"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        class="bg-zinc-800/50 px-4 py-3 pl-11 pr-4 outline-none w-full text-white rounded-lg border-2 border-solid transition-all duration-200 focus:border-emerald-500 hover:border-zinc-600 border-zinc-700 focus:ring-0 placeholder-zinc-500 autocomplete-height-fix"
        :class="{ 
          'border-red-500': error,
          'pl-4': !icon 
        }"
      />
      
      <input
        v-else-if="type === 'file'"
        type="file"
        :required="required"
        @change="handleFileChange"
        :accept="accept"
        class="bg-zinc-800/50 px-4 py-3 pl-11 pr-4 outline-none w-full text-white rounded-lg border-2 border-solid transition-all duration-200 focus:border-emerald-500 hover:border-zinc-600 border-zinc-700 focus:ring-0 placeholder-zinc-500 autocomplete-height-fix"
        :class="{ 
          'border-red-500': error,
          'pl-4': !icon 
        }"
      />
      
      <textarea
        v-else
        :required="required"
        v-model="value"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        class="bg-zinc-800/50 px-4 py-3 pl-11 pr-4 outline-none w-full text-white rounded-lg border-2 border-solid transition-all duration-200 focus:border-emerald-500 hover:border-zinc-600 border-zinc-700 focus:ring-0 placeholder-zinc-500 autocomplete-height-fix"
        :class="{ 
          'border-red-500': error,
          'pl-4': !icon 
        }"
      ></textarea>
    </div>
  </div>
</template>