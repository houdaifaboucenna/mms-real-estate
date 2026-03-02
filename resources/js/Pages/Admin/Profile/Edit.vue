<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Icon } from '@iconify/vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const translations = {
    profile: isEn.value ? 'Profile Management' : 'إدارة الملف الشخصي',
    profile_desc: isEn.value ? "Update your account's profile information, security settings, and account status." : 'تحديث معلومات ملفك الشخصي وإعدادات الأمان وحالة الحساب.',
};
</script>

<template>

    <Head :title="translations.profile" />

    <AuthenticatedLayout :title="translations.profile">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header Section -->
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100/50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                <Icon icon="carbon:user-avatar" class="text-2xl" />
                            </div>
                            <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                                {{ translations.profile }}
                            </h1>
                        </div>
                        <p class="text-sm font-medium text-gray-500 max-w-lg">
                            {{ translations.profile_desc }}
                        </p>
                    </div>
                </div>

                <!-- Profile Information -->
                <div
                    class="bg-white rounded-[40px] shadow-sm ring-1 ring-gray-100 p-8 md:p-12 hover:shadow-xl hover:shadow-brand-maroon/5 transition-all duration-500">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" />
                </div>

                <!-- Security Section -->
                <div
                    class="bg-white rounded-[40px] shadow-sm ring-1 ring-gray-100 p-8 md:p-12 hover:shadow-xl hover:shadow-brand-maroon/5 transition-all duration-500">
                    <UpdatePasswordForm />
                </div>

                <!-- Danger Zone -->
                <div
                    class="bg-red-50/30 rounded-[40px] shadow-sm ring-1 ring-red-100/50 p-8 md:p-12 border border-red-100/50">
                    <DeleteUserForm />
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fade-in-down 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
