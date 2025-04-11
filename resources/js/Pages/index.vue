<template>
    <div class="min-h-screen flex">
        <!-- Banner Section -->
        <div
            class="flex-1 bg-gradient-to-br from-emerald-900/80 to-zinc-900 relative hidden lg:block"
        >
            <div
                class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?finance,technology')] bg-cover bg-center mix-blend-overlay opacity-20"
            ></div>
            <div
                class="relative h-full p-12 flex flex-col justify-between text-white"
            >
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
                        <div
                            class="w-16 h-16 bg-emerald-600 rounded-2xl flex items-center justify-center"
                        >
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
                    <div v-for="field in formConfig" :key="field.model">
                        <label
                            class="block text-sm font-medium text-zinc-300 mb-2"
                        >
                            {{ field.label }}
                            <span v-if="field.required" class="text-red-500"
                                >*</span
                            >
                        </label>
                        <div class="relative">
                            <component
                                :is="field.icon"
                                class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 transition-colors duration-200 peer-focus:text-emerald-500"
                            />
                            <input
                                :type="field.type"
                                :required="field.required"
                                class="bg-zinc-800/50 px-4 py-3 pl-11 pr-4 outline-none w-full text-white rounded-lg border-2 border-solid transition-all duration-200 focus:border-emerald-500 hover:border-zinc-600 border-zinc-700 focus:ring-0 placeholder-zinc-500 autocomplete-height-fix"
                                v-model="formData[field.model]"
                                :autocomplete="field.autocomplete"
                                :class="{ 'border-red-500': errors.length }"
                            />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input
                            id="remember-me"
                            type="checkbox"
                            v-model="rememberMe"
                            class="h-4 w-4 text-emerald-500 border-zinc-700 rounded bg-zinc-800 focus:ring-emerald-500"
                        />
                        <label
                            for="remember-me"
                            class="ml-2 text-sm text-zinc-400"
                            >Ingat Saya</label
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg hover:shadow-emerald-900/20"
                    >
                        Masuk Sekarang
                    </button>
                </form>

                <div
                    v-if="errors.length"
                    class="mt-6 p-4 bg-red-900/30 border-2 border-red-800/50 text-red-300 rounded-xl backdrop-blur-sm animate-fade-in"
                >
                    <ul class="list-disc pl-5 space-y-2">
                        <li
                            v-for="error in errors"
                            :key="error"
                            class="text-sm"
                        >
                            {{ error }}
                        </li>
                    </ul>
                </div>

                <div class="mt-8 text-center text-sm text-zinc-400">
                    Belum punya akun?
                    <Link
                        href="/service"
                        class="text-emerald-400 hover:text-emerald-300 transition-colors font-semibold"
                    >
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
import {
    LockClosedIcon,
    ShieldCheckIcon,
    UserIcon,
    KeyIcon,
} from "@heroicons/vue/24/outline";

defineOptions({ layout: Empty });

type FormField = {
    label: string;
    type: string;
    model: "username" | "password";
    required: boolean;
    icon: any;
    autocomplete: string;
};

const errors = ref<string[]>([]);
const rememberMe = ref(false);

const formConfig: FormField[] = [
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

const formData = ref({
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
                formData.value = { username: "", password: "" };
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
