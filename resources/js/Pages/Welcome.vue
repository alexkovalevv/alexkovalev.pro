<script setup>
import {Head, Link} from '@inertiajs/vue3';
import AppImpressionLayout from "@/Layouts/AppImpressionLayout.vue";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <AppImpressionLayout>
        <Head title="Privacy Policy"/>

        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
                <div class="text-center">
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo"
                         class="w-20 h-20 mx-auto mb-4">
                    <h1 class="text-2xl font-bold text-gray-800">Laravel Framework</h1>
                    <p class="text-gray-600 mt-2">The PHP Framework for Web Artisans</p>
                </div>

                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-800">Contact Information</h2>
                    <ul class="mt-2 space-y-2">
                        <li class="text-gray-600">Email: info@laravel.com</li>
                        <li class="text-gray-600">Phone: +1 234 567 890</li>
                    </ul>
                </div>

                <div class="mt-6">
                    <h2 class="text-xl font-semibold text-gray-800">Follow Us</h2>
                    <div class="flex space-x-4 mt-2">
                        <a href="https://twitter.com/laravelphp" class="text-blue-500 hover:text-blue-700">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://github.com/laravel" class="text-gray-800 hover:text-gray-600">
                            <i class="fab fa-github"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/laravel" class="text-blue-700 hover:text-blue-900">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AppImpressionLayout>
</template>

<script>
export default {
    name: 'LaravelBusinessCard',
};
</script>

<style>
/* Подключение Font Awesome для иконок */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
</style>
