<template>
    <div class="min-h-screen flex">
        <!-- Banner Section -->
        <div class="flex-1 bg-gradient-to-br from-emerald-900/80 to-zinc-900 relative hidden lg:block">
            <div
                class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?finance,technology')] bg-cover bg-center mix-blend-overlay opacity-20">
            </div>
            <div class="relative h-full p-12 flex flex-col justify-between text-white">
                <div class="text-4xl font-bold tracking-tight">
                    <span class="text-emerald-400">Bank</span> Digital
                </div>
                <div class="space-y-4">
                    <h2 class="text-3xl font-semibold">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-zinc-300/90 text-lg font-light max-w-md">
                        Akses penuh ke semua fitur perbankan digital modern
                        dengan keamanan terbaik kelas dunia
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm text-zinc-400">
                    <ShieldCheckIcon class="w-5 h-5 text-emerald-400" />
                    <span>Sistem Keamanan Tier-1</span>
                </div>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="flex-1 flex items-center justify-center p-8 bg-zinc-900">
            <div class="w-full max-w-md">
                <div class="text-center mb-10">
                    <div class="mb-6 flex justify-center">
                        <div class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center">
                            <LockClosedIcon class="w-8 h-8 text-white" />
                        </div>
                    </div>
                    <h1 class="text-3xl font-bold text-zinc-100 mb-2">
                        Masuk ke Akun
                    </h1>
                    <p class="text-zinc-400">
                        Gunakan kredensial Anda untuk mengakses
                    </p>
                </div>

                <form @submit.prevent="submitForm" class="space-y-6">
                    <InputField v-for="field in formConfig" :key="field.model" v-model="formData[field.model]"
                        :label="field.label" :type="field.type" :required="field.required" :icon="field.icon"
                        :autocomplete="field.autocomplete" :error="errors.length > 0" />

                    <div class="flex items-center">
                        <input id="remember-me" type="checkbox" v-model="rememberMe"
                            class="h-4 w-4 text-emerald-500 border-zinc-700 rounded bg-zinc-800 focus:ring-emerald-500" />
                        <label for="remember-me" class="ml-2 text-sm text-zinc-400">Ingat Saya</label>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg hover:shadow-emerald-900/20">
                        Masuk Sekarang
                    </button>
                </form>

                <div v-if="errors.length"
                    class="mt-6 p-4 bg-red-900/30 border-2 border-red-800/50 text-red-300 rounded-xl backdrop-blur-sm animate-fade-in">
                    <ul class="list-disc pl-5 space-y-2">
                        <li v-for="error in errors" :key="error" class="text-sm">
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div class="mt-8 text-center text-sm text-zinc-400">
                    Belum punya akun?
                    <Link href="/service"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors font-semibold">
                    Hubungi Customer Service
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import Empty from "../Layouts/empty.vue";
import InputField from "../Components/InputField.vue";
import type { FormField } from '../types/form';
import {
    LockClosedIcon,
    ShieldCheckIcon,
    UserIcon,
    KeyIcon,
    CreditCardIcon
} from "@heroicons/vue/24/outline";

defineOptions({ layout: Empty });

type LoginField = FormField<'username' | 'password' | 'account_number'>;

const errors = ref<string[]>([]);
const rememberMe = ref(false);

const formConfig: LoginField[] = [
    {
        label: "Nomor Rekening",
        type: "text",
        model: "account_number",
        required: true,
        icon: CreditCardIcon,
        autocomplete: "cc-number",
    },
    {
        label: "Username",
        type: "text",
        model: "username",
        required: true,
        icon: UserIcon,
        autocomplete: "username",
    },
    {
        label: "Password",
        type: "password",
        model: "password",
        required: true,
        icon: KeyIcon,
        autocomplete: "current-password",
    },
];
// Update formData dengan account_number
const formData = ref({
    account_number: "",
    username: "",
    password: "",
});

// Load saved username
onMounted(() => {
    const savedUsername = localStorage.getItem("rememberedUsername");
    if (savedUsername) {
        formData.value.username = savedUsername;
        rememberMe.value = true;
    }
});

const submitForm = () => {
    if (rememberMe.value) {
        localStorage.setItem("rememberedUsername", formData.value.username);
    } else {
        localStorage.removeItem("rememberedUsername");
    }

    router.post(
        "/login",
        {
            ...formData.value,
            remember: rememberMe.value,
        },
        {
            onError: (err) => {
                errors.value = Object.values(err).flat();
                setTimeout(() => (errors.value = []), 5000);
            },
            onSuccess: () => {
                formData.value = { 
                    account_number: "", 
                    username: "", 
                    password: "" 
                };
            },
        }
    );
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
</style>
