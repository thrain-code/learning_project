<template>
    <Head title="login" />
    <div class="min-h-screen flex">
        <div
            class="flex-1 bg-gradient-to-br from-emerald-900/80 to-zinc-900 relative hidden lg:block"
        >
            <div
                class="absolute inset-0 bg-[url('https://source.unsplash.com/random/1920x1080/?education,classroom')] bg-cover bg-center mix-blend-overlay opacity-20"
            ></div>
            <div
                class="relative h-full p-12 flex flex-col justify-between text-white"
            >
                <div class="text-4xl font-bold tracking-tight">
                    <span class="text-emerald-400">E-Learning</span> Platform
                </div>

                <div>
                    <h2 class="text-3xl font-semibold">
                        Selamat Datang Kembali
                    </h2>
                    <p class="text-zinc-300/90 text-lg font-light max-w-md">
                        Akses materi pembelajaran, kelas online, dan komunitas
                        edukasi kami
                    </p>
                </div>

                <div class="flex items-center gap-2 text-sm text-zinc-400">
                    <ShieldCheckIcon class="w-5 h-5 text-emerald-400" />
                    <span>Sistem Pembelajaran Terintegrasi</span>
                </div>
            </div>
        </div>
        <div class="flex-1 flex items-center justify-center p-8 bg-zinc-900">
            <div class="w-full max-w-md">
                <div class="px-4">
                    <div class="text-center mb-10">
                        <h1 class="text-3xl font-bold text-zinc-100 mb-2">
                            Masuk ke Platform
                        </h1>
                        <p class="text-zinc-400">
                            Gunakan kredensial Anda untuk mengakses
                        </p>
                    </div>

                    <form @submit.prevent="submitLogin" class="space-y-6">
                        <InputField
                            variant="primary"
                            theme="dark"
                            v-for="field in loginFields"
                            :key="field.model"
                            v-bind="field"
                            v-model="loginData[field.model]"
                            :error="hasError(field.errorKey)"
                        />

                        <div class="flex items-center justify-between">
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
                            <a
                                href="#"
                                class="text-sm text-emerald-400 hover:text-emerald-300"
                            >
                                Lupa Password?
                            </a>
                        </div>

                        <ButtonComp
                            variant="primary"
                            theme="light"
                        >
                            Ghost Button
                        </ButtonComp>
                    </form>

                    <div class="mt-8 text-center text-sm text-zinc-400">
                        Kembali ke halaman
                        <Link
                            href="/"
                            class="text-emerald-400 hover:text-emerald-300 transition-colors font-semibold ml-1"
                            >
                            Homepage
                        </Link>
                    </div>
                </div>

                <Transition name="fade">
                    <div
                        v-if="errors.length"
                        class="mt-6 p-4 bg-red-900/30 border-2 border-red-800/50 text-red-300 rounded-xl backdrop-blur-sm"
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
                </Transition>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import InputField from "../../Components/InputField.vue";
import ButtonComp from "../../Components/ButtonComp.vue";
import {
    ShieldCheckIcon,
    EnvelopeIcon,
    KeyIcon,
} from "@heroicons/vue/24/outline";
import Empty from "../../Layouts/empty.vue";

defineOptions({ layout: Empty });

const rememberMe = ref(false);
const errors = ref<string[]>([]);

const loginData = ref({
    username: "",
    password: "",
});

const loginFields = [
    {
        label: "Username",
        type: "text",
        model: "username",
        required: true,
        icon: EnvelopeIcon,
        autocomplete: "username",
        placeholder: "Masukkan alamat username",
        errorKey: "username",
        modelValue: undefined,
    },
    {
        label: "Password",
        type: "password",
        model: "password",
        required: true,
        icon: KeyIcon,
        autocomplete: "current-password",
        placeholder: "Masukkan password",
        errorKey: "password",
        modelValue: undefined,
    },
];

const hasError = (fieldKey: string) =>
    errors.value.some((e) => e.toLowerCase().includes(fieldKey));

const submitLogin = () => {
    if (rememberMe.value) {
        localStorage.setItem("rememberedusername", loginData.value.username);
    } else {
        localStorage.removeItem("rememberedusername");
    }

    router.post("/login", loginData.value, {
        onError: (err) => {
            errors.value = Object.values(err).flat();
            setTimeout(() => (errors.value = []), 5000);
        },
        onSuccess: () => {
            loginData.value = { username: "", password: "" };
        },
    });
};

onMounted(() => {
    const savedusername = localStorage.getItem("rememberedusername");
    if (savedusername) {
        loginData.value.username = savedusername;
        rememberMe.value = true;
    }
});
</script>

<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(0.7);
}

input[type="date"]::-webkit-calendar-picker-indicator:hover {
    filter: invert(0.5);
}
</style>
