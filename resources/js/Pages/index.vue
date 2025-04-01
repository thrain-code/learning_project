<template>
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-zinc-900 rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
      <div class="flex gap-2 mb-8 bg-zinc-700 p-1 rounded-xl">
        <button 
          v-for="tab in tabs"
          :key="tab.id"
          @click="activeTab = tab.id"
          :class="[
            'flex-1 py-3 rounded-lg font-semibold transition-all duration-300',
            activeTab === tab.id 
              ? 'bg-emerald-600 text-white shadow-md' 
              : 'bg-transparent text-zinc-300 hover:bg-zinc-600'
          ]"
        >
          {{ tab.label }}
        </button>
      </div>

      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Dynamic Form Fields -->
        <div v-for="field in activeFields" :key="field.model">
          <label class="block text-sm font-medium text-zinc-300 mb-2">
            {{ field.label }}
            <span v-if="field.required" class="text-red-500">*</span>
          </label>
          <input
            :type="field.type"
            :required="field.required"
            class="w-full px-4 py-3 bg-zinc-700 border border-zinc-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-zinc-100 placeholder-zinc-400 transition-all"
            :placeholder="field.placeholder"
            v-model="formData[field.model]"
          />
        </div>

        <div v-if="activeTab === 'login'" class="flex items-center justify-between">
          <a href="#" class="text-sm text-emerald-400 hover:text-emerald-300 transition-colors">
            Lupa Password?
          </a>
        </div>

        <button 
          type="submit" 
          class="w-full py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all duration-300 transform hover:scale-[1.02] active:scale-95"
        >
          {{ activeTab === 'login' ? 'Masuk' : 'Daftar Akun' }}
        </button>
      </form>

      <div 
        v-if="errors.length"
        class="mt-6 p-4 bg-red-900/30 border border-red-800/50 text-red-300 rounded-lg backdrop-blur-sm"
      >
        <ul class="list-disc pl-5 space-y-2">
          <li v-for="error in errors" :key="error" class="text-sm">
            {{ error }}
          </li>
        </ul>
      </div>

      <div class="mt-8 text-center text-sm text-zinc-400">
        Dengan melanjutkan, Anda setuju dengan
        <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors">Ketentuan Layanan</a> dan
        <a href="#" class="text-emerald-400 hover:text-emerald-300 transition-colors">Kebijakan Privasi</a>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Empty from '../Layouts/empty.vue';

defineOptions({ layout: Empty });

type TabType = 'login' | 'register';
type FormField = {
  label: string;
  type: string;
  model: 'name' | 'email' | 'password';
  required: boolean;
  placeholder: string;
};

const activeTab = ref<TabType>('login');
const errors = ref<string[]>([]);

const tabs = [
  { id: 'login' as TabType, label: 'Masuk' },
  { id: 'register' as TabType, label: 'Daftar' }
];

const formConfig: Record<TabType, FormField[]> = {
  login: [
    { 
      label: 'Email',
      type: 'email',
      model: 'email',
      required: true,
      placeholder: 'email@contoh.com' 
    },
    { 
      label: 'Password',
      type: 'password',
      model: 'password',
      required: true,
      placeholder: '••••••••' 
    }
  ],
  register: [
    { 
      label: 'Nama Lengkap',
      type: 'text',
      model: 'name',
      required: true,
      placeholder: 'John Doe' 
    },
    { 
      label: 'Email',
      type: 'email',
      model: 'email',
      required: true,
      placeholder: 'email@contoh.com' 
    },
    { 
      label: 'Password',
      type: 'password',
      model: 'password',
      required: true,
      placeholder: 'Minimal 8 karakter' 
    }
  ]
};

const formData = ref<Record<FormField['model'], string>>({
  name: '',
  email: '',
  password: ''
});

const activeFields = computed(() => formConfig[activeTab.value]);

const submitForm = () => {
  const url = activeTab.value === 'login' ? '/login' : '/register';
  
  router.post(url, formData.value, {
    onError: (err) => {
      errors.value = Object.values(err).flat();
      setTimeout(() => errors.value = [], 5000);
    },
    onSuccess: () => {
      formData.value = { name: '', email: '', password: '' };
    }
  });
};
</script>