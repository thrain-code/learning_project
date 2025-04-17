<!-- resources/js/Components/Forms/InputField.vue -->
<script setup lang="ts">
import type { InputFieldProps } from '../types/form';
import { computed } from 'vue';

const props = defineProps<InputFieldProps>();
const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
}>();

const value = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
});
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
        class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 transition-colors duration-200 peer-focus:text-emerald-500"
      />
      <input
        :type="type"
        :required="required"
        v-model="value"
        :autocomplete="autocomplete"
        :placeholder="placeholder"
        class="bg-zinc-800/50 px-4 py-3 pl-11 pr-4 outline-none w-full text-white rounded-lg border-2 border-solid transition-all duration-200 focus:border-emerald-500 hover:border-zinc-600 border-zinc-700 focus:ring-0 placeholder-zinc-500 autocomplete-height-fix"
        :class="{ 'border-red-500': error }"
      />
    </div>
  </div>
</template>