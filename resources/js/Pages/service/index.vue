<template>
  <div class="min-h-screen bg-zinc-900 p-6">
    <div class="max-w-2xl mx-auto bg-zinc-800 rounded-xl p-8 shadow-lg">
      <!-- Header Section -->
      <div class="mb-8 text-center">
        <div class="mb-4 flex justify-center">
          <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
            </svg>
          </div>
        </div>
        <h1 class="text-3xl font-bold text-emerald-500">Buka Rekening Baru</h1>
        <p class="text-zinc-400 mt-2">Isi formulir berikut untuk membuka rekening baru</p>
      </div>

      <!-- Form Section -->
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Personal Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-zinc-300 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
            <input
              v-model="form.fullName"
              type="text"
              required
              class="w-full bg-zinc-700 text-white rounded-lg p-3 border-2 border-zinc-600 focus:border-emerald-500 focus:ring-0"
              placeholder="Masukkan nama lengkap"
            >
          </div>
          
          <div>
            <label class="block text-zinc-300 mb-2">Nomor KTP <span class="text-red-500">*</span></label>
            <input
              v-model="form.ktpNumber"
              type="text"
              required
              class="w-full bg-zinc-700 text-white rounded-lg p-3 border-2 border-zinc-600 focus:border-emerald-500 focus:ring-0"
              placeholder="Masukkan nomor KTP"
            >
          </div>
        </div>

        <!-- Account Type -->
        <div>
          <label class="block text-zinc-300 mb-2">Jenis Rekening <span class="text-red-500">*</span></label>
          <select
            v-model="form.accountType"
            class="w-full bg-zinc-700 text-white rounded-lg p-3 border-2 border-zinc-600 focus:border-emerald-500 focus:ring-0"
          >
            <option value="savings">Tabungan</option>
            <option value="checking">Giro</option>
            <option value="deposit">Deposito</option>
          </select>
        </div>

        <!-- Initial Deposit -->
        <div>
          <label class="block text-zinc-300 mb-2">Setoran Awal <span class="text-red-500">*</span></label>
          <div class="relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-zinc-400">Rp</span>
            <input
              v-model="form.initialDeposit"
              type="number"
              min="100000"
              required
              class="w-full bg-zinc-700 text-white rounded-lg p-3 pl-10 border-2 border-zinc-600 focus:border-emerald-500 focus:ring-0"
              placeholder="Minimum Rp 100.000"
            >
          </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="flex items-start">
          <input
            id="terms"
            v-model="form.agreeTerms"
            type="checkbox"
            required
            class="mt-1 h-4 w-4 text-emerald-500 border-zinc-600 rounded bg-zinc-700 focus:ring-emerald-500"
          >
          <label for="terms" class="ml-2 text-zinc-300 text-sm">
            Saya setuju dengan 
            <a href="#" class="text-emerald-400 hover:underline">Syarat & Ketentuan</a> 
            yang berlaku
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transition-colors"
        >
          Ajukan Pembukaan Rekening
        </button>

        <!-- Success Message -->
        <div v-if="showSuccess" class="p-4 bg-emerald-900/30 text-emerald-300 rounded-lg animate-fade-in">
          Pengajuan pembukaan rekening berhasil dikirim! 
          <div class="mt-2 text-sm">Status pengajuan dapat dicek di halaman profil Anda.</div>
        </div>
      </form>

      <!-- Info Section -->
      <div class="mt-8 p-4 bg-zinc-700/50 rounded-lg">
        <h3 class="text-emerald-400 font-semibold mb-2">Persyaratan Umum</h3>
        <ul class="text-zinc-300 text-sm list-disc pl-5 space-y-2">
          <li>Usia minimal 17 tahun</li>
          <li>Fotokopi KTP yang masih berlaku</li>
          <li>Setoran awal minimum Rp 100.000</li>
          <li>Data yang diberikan harus valid</li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  fullName: '',
  ktpNumber: '',
  accountType: 'savings',
  initialDeposit: '',
  agreeTerms: false
});

const showSuccess = ref(false);

const handleSubmit = () => {
  if (
    form.value.fullName &&
    form.value.ktpNumber &&
    form.value.initialDeposit >= 100000 &&
    form.value.agreeTerms
  ) {
    showSuccess.value = true;
    setTimeout(() => {
      showSuccess.value = false;
      form.value = {
        fullName: '',
        ktpNumber: '',
        accountType: 'savings',
        initialDeposit: '',
        agreeTerms: false
      };
    }, 5000);
  }
};
</script>

<style>
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

input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>