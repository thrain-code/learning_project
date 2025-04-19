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

                <!-- Banner Content dengan Transition -->
                <Transition name="banner-fade" mode="out-in">
                    <div :key="isLogin ? 'login' : 'register'">
                        <h2 class="text-3xl font-semibold">
                            {{ bannerTitle }}
                        </h2>
                        <p class="text-zinc-300/90 text-lg font-light max-w-md">
                            {{ bannerMessage }}
                        </p>
                    </div>
                </Transition>
                <div class="flex items-center gap-2 text-sm text-zinc-400">
                    <ShieldCheckIcon class="w-5 h-5 text-emerald-400" />
                    <span>Sistem Keamanan Tier-1</span>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="flex-1 flex items-center justify-center p-8 bg-zinc-900">
            <div class="w-full max-w-md">
                <Transition name="slide-fade" mode="out-in">
                    <!-- Login Form -->
                    <div v-if="isLogin" key="login" class="px-4">
                        <div class="text-center mb-10">
                            <h1 class="text-3xl font-bold text-zinc-100 mb-2">
                                Masuk ke Akun
                            </h1>
                            <p class="text-zinc-400">
                                Gunakan kredensial Anda untuk mengakses
                            </p>
                        </div>

                        <form @submit.prevent="submitLogin" class="space-y-6">
                            <InputField
                                v-for="field in loginFields"
                                :key="field.model"
                                v-bind="field"
                                v-model="loginData[field.model]"
                                :error="hasError(field.errorKey)"
                            />

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

                        <div class="mt-8 text-center text-sm text-zinc-400">
                            Belum punya akun?
                            <button
                                @click="switchToRegister"
                                class="text-emerald-400 hover:text-emerald-300 transition-colors font-semibold ml-1"
                            >
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <div v-else key="register" class="px-4">
                        <div class="text-center mb-10">
                            <h1 class="text-3xl font-bold text-zinc-100 mb-2">
                                Daftar Akun Baru
                            </h1>
                            <p class="text-zinc-400">
                                Buat akun Anda dalam 2 menit
                            </p>
                        </div>

                        <form
                            @submit.prevent="submitRegister"
                            class="space-y-6"
                        >
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <InputField
                                    v-for="field in registerFields"
                                    :key="field.model"
                                    v-bind="field"
                                    v-model="registerData[field.model]"
                                    :error="hasError(field.errorKey)"
                                />
                            </div>

                            <SelectField
                                v-bind="provinceField"
                                v-model="registerData.province"
                                :error="hasError('province')"
                            />

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <InputField
                                    v-bind="fileFields.ktp"
                                    v-model="registerData.ktp"
                                    :error="hasError('ktp')"
                                />
                                <InputField
                                    v-bind="fileFields.photo"
                                    v-model="registerData.photo"
                                    :error="hasError('photo')"
                                />
                            </div>

                            <div class="flex items-start">
                                <input
                                    id="terms"
                                    type="checkbox"
                                    v-model="registerData.agreeTerms"
                                    class="mt-1 h-4 w-4 text-emerald-400 border-zinc-600 rounded bg-zinc-700 focus:ring-2 focus:ring-emerald-400/30"
                                    required
                                />
                                <label
                                    for="terms"
                                    class="ml-3 text-zinc-300 text-sm leading-tight"
                                >
                                    Saya menyetujui
                                    <a
                                        href="#"
                                        class="text-emerald-400 hover:text-emerald-300 transition-colors"
                                    >
                                        Syarat & Ketentuan
                                    </a>
                                </label>
                            </div>

                            <button
                                type="submit"
                                class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg hover:shadow-emerald-900/20"
                            >
                                Daftar Sekarang
                            </button>
                        </form>

                        <div class="mt-8 text-center text-sm text-zinc-400">
                            Sudah punya akun?
                            <button
                                @click="switchToLogin"
                                class="text-emerald-400 hover:text-emerald-300 transition-colors font-semibold ml-1"
                            >
                                Masuk di sini
                            </button>
                        </div>
                    </div>
                </Transition>

                <!-- Error Display -->
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
import { ref, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import InputField from "../Components/InputField.vue";
import SelectField from "../Components/SelectOption.vue";
import type { FormField, InputType } from "../types/form";
import Empty from "../Layouts/empty.vue";
import {
    ShieldCheckIcon,
    CreditCardIcon,
    KeyIcon,
    UserCircleIcon,
    EnvelopeIcon,
    PhoneIcon,
    MapPinIcon,
    DocumentTextIcon,
    CameraIcon,
} from "@heroicons/vue/24/outline";

const isLogin = ref(true);
const rememberMe = ref(false);
const errors = ref<string[]>([]);

defineOptions({ layout: Empty });

// Login Data
const loginData = ref({
    account_number: "",
    password: "",
});

// Registration Data
const registerData = ref({
    full_name: "",
    email: "",
    phone: "",
    birth_date: "",
    nik: "",
    address: "",
    province: "",
    postal_code: "",
    ktp: null as File | null,
    photo: null as File | null,
    agreeTerms: false,
});

// Banner Content
const bannerTitle = computed(() =>
    isLogin.value ? "Selamat Datang Kembali" : "Mulai Perjalanan Finansial Anda"
);

const bannerMessage = computed(() =>
    isLogin.value
        ? "Akses penuh ke semua fitur perbankan digital modern dengan keamanan terbaik kelas dunia"
        : "Nikmati kemudahan transaksi finansial dengan fitur keamanan tingkat tinggi dan layanan 24/7"
);

// Form Configurations
const loginFields: FormField[] = [
    {
        label: "Nomor Rekening",
        type: "text",
        model: "account_number",
        required: true,
        icon: CreditCardIcon,
        autocomplete: "cc-number",
        placeholder: "Masukkan nomor rekening",
        errorKey: "account_number",
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

const registerFields: FormField[] = [
    {
        label: "Nama Lengkap",
        type: "text",
        model: "full_name",
        required: true,
        icon: UserCircleIcon,
        autocomplete: "name",
        placeholder: "Masukkan nama lengkap",
        errorKey: "full_name",
        modelValue: undefined,
    },
    {
        label: "Email",
        type: "email",
        model: "email",
        required: true,
        icon: EnvelopeIcon,
        autocomplete: "email",
        placeholder: "contoh@email.com",
        errorKey: "email",
        modelValue: undefined,
    },
    {
        label: "Nomor HP",
        type: "tel",
        model: "phone",
        required: true,
        icon: PhoneIcon,
        autocomplete: "tel",
        placeholder: "08xxxxxxxxxx",
        errorKey: "phone",
        modelValue: undefined,
    },
];

const provinceField = {
    label: "Provinsi",
    model: "province",
    required: true,
    icon: MapPinIcon,
    placeholder: "Pilih provinsi",
    options: [
        { value: "DKI_JAKARTA", label: "DKI Jakarta" },
        { value: "JAWA_BARAT", label: "Jawa Barat" },
        { value: "JAWA_TIMUR", label: "Jawa Timur" },
        { value: "JAWA_TENGAH", label: "Jawa Tengah" },
        { value: "SUMATRA_BARAT", label: "Sumatra Barat" },
        { value: "SUMATRA_UTARA", label: "Sumatra Utara" },
        { value: "KALIMANTAN_BARAT", label: "Kalimantan Barat" },
        { value: "PAPUA", label: "Papua" },
        { value: "NUSA_TENGGARA_BARAT", label: "Nusa Tenggara Barat" },
    ],
    errorKey: "province",
};

const fileFields = {
    ktp: {
        label: "Upload KTP",
        type: "file" as InputType,
        model: "ktp",
        required: true,
        icon: DocumentTextIcon,
        accept: "image/*,.pdf",
        placeholder: "File KTP (max 2MB)",
        errorKey: "ktp",
    },
    photo: {
        label: "Pas Foto",
        type: "file" as InputType,
        model: "photo",
        required: true,
        icon: CameraIcon,
        accept: "image/*",
        placeholder: "Foto 3x4 (max 2MB)",
        errorKey: "photo",
    },
};

// Methods
const switchToRegister = () => {
    isLogin.value = false;
    errors.value = [];
};

const switchToLogin = () => {
    isLogin.value = true;
    errors.value = [];
};

const hasError = (fieldKey: string) =>
    errors.value.some((e) => e.toLowerCase().includes(fieldKey));

const submitLogin = () => {
    if (rememberMe.value) {
        localStorage.setItem(
            "rememberedAccount",
            loginData.value.account_number
        );
    } else {
        localStorage.removeItem("rememberedAccount");
    }

    router.post("/login", loginData.value, {
        onError: (err) => {
            errors.value = Object.values(err).flat();
            setTimeout(() => (errors.value = []), 5000);
        },
        onSuccess: () => {
            loginData.value = { account_number: "", password: "" };
        },
    });
};

const submitRegister = () => {
    const formData = new FormData();
    Object.entries(registerData.value).forEach(([key, value]) => {
        if (value !== null && value !== undefined) {
            formData.append(
                key,
                value instanceof File ? value : value.toString()
            );
        }
    });

    router.post("/register", formData, {
        onError: (err) => {
            errors.value = Object.values(err).flat();
            setTimeout(() => (errors.value = []), 5000);
        },
        onSuccess: () => {
            registerData.value = {
                full_name: "",
                email: "",
                phone: "",
                birth_date: "",
                nik: "",
                address: "",
                province: "",
                postal_code: "",
                ktp: null,
                photo: null,
                agreeTerms: false,
            };
            switchToLogin();
        },
    });
};

onMounted(() => {
    const savedAccount = localStorage.getItem("rememberedAccount");
    if (savedAccount) {
        loginData.value.account_number = savedAccount;
        rememberMe.value = true;
    }
});
</script>

<style>
/* Banner transition */
.banner-fade-enter-active,
.banner-fade-leave-active {
    transition: all 0.5s ease;
}

.banner-fade-enter-from {
    opacity: 0;
    transform: translateY(-20px);
}

.banner-fade-leave-to {
    opacity: 0;
    transform: translateY(20px);
}

/* Konten dalam banner */
.banner-content-enter-active {
    transition: all 0.3s ease-out;
}

.banner-content-leave-active {
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.banner-content-enter-from {
    opacity: 0;
    transform: translateY(-10px);
}

.banner-content-leave-to {
    opacity: 0;
    transform: translateY(10px);
}
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateX(20px);
    opacity: 0;
}

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
