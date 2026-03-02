<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Icon } from '@iconify/vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);
const isEn = computed(() => usePage().props.locale === 'en');

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const translations = {
    title: isEn.value ? 'Security & Password' : 'الأمان وكلمة المرور',
    desc: isEn.value ? 'Ensure your account is using a long, random password to stay secure.' : 'تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للحفاظ على أمانه.',
    current: isEn.value ? 'Current Password' : 'كلمة المرور الحالية',
    new: isEn.value ? 'New Password' : 'كلمة المرور الجديدة',
    confirm: isEn.value ? 'Confirm New Password' : 'تأكيد كلمة المرور الجديدة',
    save: isEn.value ? 'Update Password' : 'تحديث كلمة المرور',
    saved: isEn.value ? 'Password updated' : 'تم تحديث كلمة المرور',
};
</script>

<template>
    <section>
        <header class="mb-10">
            <h2 class="text-2xl font-black text-brand-maroon tracking-tight">
                {{ translations.title }}
            </h2>
            <p class="mt-2 text-sm font-medium text-gray-500 max-w-xl">
                {{ translations.desc }}
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="md:col-span-2">
                <InputLabel for="current_password" :value="translations.current"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group max-w-md">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:password" class="text-xl" />
                    </div>
                    <TextInput id="current_password" ref="currentPasswordInput" v-model="form.current_password"
                        type="password"
                        class="pl-12 block w-full border-gray-100 focus:ring-brand-gold focus:border-brand-gold bg-gray-50/30"
                        autocomplete="current-password" />
                </div>
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="md:col-span-1">
                <InputLabel for="password" :value="translations.new"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:locked" class="text-xl" />
                    </div>
                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="pl-12 block w-full border-gray-100 focus:ring-brand-gold focus:border-brand-gold bg-gray-50/30"
                        autocomplete="new-password" />
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="md:col-span-1">
                <InputLabel for="password_confirmation" :value="translations.confirm"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:checkmark" class="text-xl" />
                    </div>
                    <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
                        class="pl-12 block w-full border-gray-100 focus:ring-brand-gold focus:border-brand-gold bg-gray-50/30"
                        autocomplete="new-password" />
                </div>
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>

            <div class="md:col-span-2 flex items-center gap-4 pt-4">
                <button type="submit" :disabled="form.processing"
                    class="inline-flex items-center gap-3 px-10 py-4 rounded-[22px] bg-brand-gold text-white text-sm font-bold shadow-xl shadow-brand-gold/20 hover:bg-brand-maroon hover:shadow-brand-maroon/30 hover:-translate-y-1 transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none group">
                    <Icon icon="carbon:ibm-cloud-security-compliance-center-surface-protection"
                        class="text-lg transition-transform group-hover:scale-110" />
                    {{ translations.save }}
                </button>

                <Transition enter-active-class="transition duration-500 ease-out"
                    enter-from-class="opacity-0 translate-x-4" leave-active-class="transition duration-300 ease-in"
                    leave-to-class="opacity-0 -translate-x-4">
                    <p v-if="form.recentlySuccessful"
                        class="text-sm font-bold text-emerald-500 flex items-center gap-2">
                        <Icon icon="carbon:checkmark-filled" class="text-xl" />
                        {{ translations.saved }}
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
