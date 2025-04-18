<template>
  <div class="min-h-screen bg-zinc-900 text-white p-8">
    <div class="max-w-4xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 text-emerald-400">
          Pendaftaran Akun Bank Digital
        </h1>
        <p class="text-zinc-400">
          Isi formulir berikut untuk membuat akun perbankan digital Anda
        </p>
      </div>

      <!-- Form -->
      <form @submit.prevent="submitForm" class="space-y-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Personal Data -->
          <div class="space-y-6">
            <InputField
              v-for="field in personalFields"
              :key="field.model"
              :field="field"
              v-model="formData[field.model]"
              :error="hasError(field.model)"
            />
          </div>

          <!-- Additional Data -->
          <div class="space-y-6">
            <InputField
              v-for="field in additionalFields"
              :key="field.model"
              :field="field"
              v-model="formData[field.model]"
              :error="hasError(field.model)"
            />

            <!-- File Uploads -->
            <div class="space-y-4">
              <InputField
                :field="fileFields.ktp"
                v-model="formData.ktp"
                :error="hasError('ktp')"
              />
              
              <InputField
                :field="fileFields.photo"
                v-model="formData.photo"
                :error="hasError('photo')"
              />
            </div>
          </div>
        </div>

        <!-- Terms Checkbox -->
        <div class="flex items-center">
          <input
            id="terms"
            type="checkbox"
            v-model="formData.agreeTerms"
            class="h-4 w-4 text-emerald-500 border-zinc-700 rounded bg-zinc-800 focus:ring-emerald-500"
            required
          />
          <label for="terms" class="ml-2 text-zinc-400 text-sm">
            Saya setuju dengan 
            <a href="#" class="text-emerald-400 hover:underline">
              Syarat & Ketentuan
            </a>
            yang berlaku
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="processing"
          class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg hover:shadow-emerald-900/20 disabled:opacity-50 disabled:cursor-not-allowed"
        >
          {{ processing ? 'Memproses...' : 'Daftar Sekarang' }}
        </button>

        <!-- Error Display -->
        <div
          v-if="Object.keys(errors).length"
          class="mt-6 p-4 bg-red-900/30 border-2 border-red-800/50 text-red-300 rounded-xl backdrop-blur-sm animate-fade-in"
        >
          <ul class="list-disc pl-5 space-y-2">
            <li
              v-for="(errorList, field) in errors"
              :key="field"
              class="text-sm"
            >
              <span class="font-medium capitalize">{{ field }}:</span>
              {{ errorList.join(', ') }}
            </li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import InputField from '../../Components/InputField.vue';
import type { FormField } from '../../types/form';
import {
  UserCircleIcon,
  IdentificationIcon,
  EnvelopeIcon,
  PhoneIcon,
  HomeModernIcon,
  CalendarIcon,
  DocumentTextIcon,
  CameraIcon
} from '@heroicons/vue/24/outline';

const processing = ref(false);

const formData = ref({
  full_name: '',
  email: '',
  phone: '',
  birth_date: '',
  nik: '',
  address: '',
  city: '',
  province: '',
  postal_code: '',
  ktp: null as File | null,
  photo: null as File | null,
  agreeTerms: false
});

const errors = ref<Record<string, string[]>>({});

// Helper untuk check error
const hasError = (field: string) => !!errors.value[field]?.length;

// Konfigurasi field
const personalFields: FormField[] = [
  {
    label: "Nama Lengkap",
    type: "text",
    model: "full_name",
    required: true,
    icon: UserCircleIcon,
    autocomplete: "name",
    placeholder: "Masukkan nama lengkap sesuai KTP",
  },
  {
    label: "Email",
    type: "email",
    model: "email",
    required: true,
    icon: EnvelopeIcon,
    autocomplete: "email",
    placeholder: "contoh@email.com",
  },
  {
    label: "Nomor HP",
    type: "tel",
    model: "phone",
    required: true,
    icon: PhoneIcon,
    autocomplete: "tel",
    placeholder: "08xxxxxxxxxx",
  },
  {
    label: "Tanggal Lahir",
    type: "date",
    model: "birth_date",
    required: true,
    icon: CalendarIcon,
    autocomplete: "bday",
    placeholder: "Pilih tanggal lahir",
  }
];

const additionalFields: FormField[] = [
  {
    label: "NIK",
    type: "number",
    model: "nik",
    required: true,
    icon: IdentificationIcon,
    autocomplete: "off",
    placeholder: "Masukkan 16 digit NIK",
  },
  {
    label: "Alamat",
    type: "text",
    model: "address",
    required: true,
    icon: HomeModernIcon,
    autocomplete: "street-address",
    placeholder: "Jalan, No. Rumah, RT/RW",
  },
  {
    label: "Kota",
    type: "text",
    model: "city",
    required: true,
    icon: HomeModernIcon,
    autocomplete: "address-level2",
    placeholder: "Masukkan kota tempat tinggal",
  },
  {
    label: "Provinsi",
    type: "text",
    model: "province",
    required: true,
    icon: HomeModernIcon,
    autocomplete: "address-level1",
    placeholder: "Masukkan provinsi tempat tinggal",
  },
  {
    label: "Kode Pos",
    type: "text",
    model: "postal_code",
    required: true,
    icon: DocumentTextIcon,
    autocomplete: "postal-code",
    placeholder: "Masukkan kode pos",
  }
];

const fileFields = {
  ktp: {
    label: "Upload KTP (PDF/Image)",
    type: "file",
    model: "ktp",
    required: true,
    icon: DocumentTextIcon,
    accept: "image/*,.pdf",
    placeholder: "Unggah file KTP",
  } as FormField,
  photo: {
    label: "Upload Pas Foto",
    type: "file",
    model: "photo",
    required: true,
    icon: CameraIcon,
    accept: "image/*",
    placeholder: "Unggah pas foto 3x4",
  } as FormField
};

const submitForm = async () => {
  processing.value = true;
  errors.value = {};

  const form = new FormData();
  const data = formData.value;
  
  // Append semua field kecuali file
  Object.entries(data).forEach(([key, value]) => {
    if (key === 'ktp' || key === 'photo') return;
    if (value !== null) form.append(key, value as string | Blob);
  });

  // Append file secara terpisah
  if (data.ktp) form.append('ktp', data.ktp);
  if (data.photo) form.append('photo', data.photo);

  try {
    await router.post('/register', form, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
  } catch (err: any) {
    if (err.response?.data?.errors) {
      errors.value = err.response.data.errors;
    }
  } finally {
    processing.value = false;
  }
};
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(-10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>