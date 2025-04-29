<template>
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 md:px-8">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ currentYear }} Absensi Sekolah. All rights reserved.
            </p>
        </div>
    </footer>
</template>
<script setup lang="ts">
const currentYear = new Date().getFullYear();
</script>
