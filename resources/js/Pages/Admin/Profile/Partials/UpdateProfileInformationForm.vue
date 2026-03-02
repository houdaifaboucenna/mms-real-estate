<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Icon } from '@iconify/vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const profile = user.profile || {};
const isEn = computed(() => usePage().props.locale === 'en');

const form = useForm({
    _method: 'PATCH',
    name: user.name,
    email: user.email,
    username: profile.username || '',
    bio: profile.bio || '',
    image: null,
});

const imagePreview = ref(profile.image_url || null);

const handleImageChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.image = file;
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const submit = () => {
    form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.image = null;
        },
    });
};

const translations = {
    title: isEn.value ? 'Profile Information' : 'معلومات الملف الشخصي',
    desc: isEn.value ? "Update your account's profile information and email address." : 'تحديث معلومات ملفك الشخصي وعنوان بريدك الإلكتروني.',
    name: isEn.value ? 'Full Name' : 'الاسم الكامل',
    email: isEn.value ? 'Email Address' : 'البريد الإلكتروني',
    username: isEn.value ? 'Username' : 'اسم المستخدم',
    bio: isEn.value ? 'Bio / Description' : 'السيرة الذاتية / الوصف',
    image: isEn.value ? 'Profile Picture' : 'الصورة الشخصية',
    save: isEn.value ? 'Save Changes' : 'حفظ التغييرات',
    saved: isEn.value ? 'Saved successfully' : 'تم الحفظ بنجاح',
    change_photo: isEn.value ? 'Change Photo' : 'تغيير الصورة',
};
</script>

<template>
    <section class="relative">
        <header class="mb-10">
            <h2 class="text-2xl font-black text-brand-maroon tracking-tight">
                {{ translations.title }}
            </h2>
            <p class="mt-2 text-sm font-medium text-gray-500 max-w-xl">
                {{ translations.desc }}
            </p>
        </header>

        <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Profile Image Section -->
            <div class="md:col-span-2 mb-4">
                <InputLabel for="image" :value="translations.image"
                    class="mb-4 text-[10px] font-black uppercase tracking-widest text-brand-maroon/30" />
                <div class="flex items-center gap-8">
                    <div class="relative group/avatar">
                        <div
                            class="h-32 w-32 rounded-[40px] overflow-hidden ring-4 ring-gray-50 shadow-2xl transition-transform group-hover/avatar:scale-105 duration-500 bg-gray-100 flex items-center justify-center">
                            <img v-if="imagePreview" :src="imagePreview" class="h-full w-full object-cover" />
                            <Icon v-else icon="carbon:user-avatar" class="text-6xl text-gray-300" />
                        </div>
                        <label for="image"
                            class="absolute -bottom-2 -right-2 h-10 w-10 rounded-2xl bg-brand-gold text-white flex items-center justify-center cursor-pointer shadow-xl hover:rotate-12 transition-all active:scale-95 group/btn border-4 border-white">
                            <Icon icon="carbon:camera" class="text-xl" />
                        </label>
                        <input id="image" type="file" @change="handleImageChange" class="hidden" accept="image/*" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <span class="text-sm font-bold text-brand-maroon">{{ user.name }}</span>
                        <span class="text-xs font-medium text-gray-400">@{{ form.username || 'username' }}</span>
                        <div
                            class="mt-2 text-[10px] font-black text-brand-gold uppercase tracking-[0.2em] px-3 py-1 bg-brand-gold/10 rounded-full w-fit">
                            {{ isEn ? 'Verified Account' : 'حساب موثق' }}
                        </div>
                    </div>
                </div>
                <InputError class="mt-4" :message="form.errors.image" />
            </div>

            <!-- Basic Info (Read Only) -->
            <div class="opacity-60 grayscale-[0.5]">
                <InputLabel for="name" :value="translations.name"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:user-identification" class="text-xl" />
                    </div>
                    <TextInput id="name" type="text"
                        class="pl-12 block w-full bg-gray-50/50 border-gray-100 pointer-events-none" v-model="form.name"
                        disabled />
                </div>
            </div>

            <div class="opacity-60 grayscale-[0.5]">
                <InputLabel for="email" :value="translations.email"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:email" class="text-xl" />
                    </div>
                    <TextInput id="email" type="email"
                        class="pl-12 block w-full bg-gray-50/50 border-gray-100 pointer-events-none"
                        v-model="form.email" disabled />
                </div>
            </div>

            <!-- Editable Info -->
            <div>
                <InputLabel for="username" :value="translations.username"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <div
                        class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-brand-maroon/30 group-focus-within:text-brand-gold transition-colors">
                        <Icon icon="carbon:at" class="text-xl" />
                    </div>
                    <TextInput id="username" type="text"
                        class="pl-12 block w-full border-gray-100 focus:ring-brand-gold focus:border-brand-gold bg-white"
                        v-model="form.username" required autocomplete="username" placeholder="john_doe" />
                </div>
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="md:col-span-2">
                <InputLabel for="bio" :value="translations.bio"
                    class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30 mb-2" />
                <div class="relative group">
                    <textarea id="bio" rows="4"
                        class="block w-full rounded-[24px] border-gray-100 shadow-sm focus:border-brand-gold focus:ring focus:ring-brand-gold focus:ring-opacity-20 bg-white text-sm font-medium p-6 transition-all min-h-[120px]"
                        v-model="form.bio" placeholder="Tell us about yourself..."></textarea>
                </div>
                <InputError class="mt-2" :message="form.errors.bio" />
            </div>

            <!-- Footer Section -->
            <div class="md:col-span-2 flex items-center justify-between pt-8 border-t border-gray-50">
                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="form.processing"
                        class="inline-flex items-center gap-3 px-10 py-4 rounded-[22px] bg-brand-maroon text-white text-sm font-bold shadow-xl shadow-brand-maroon/20 hover:bg-brand-gold hover:shadow-brand-gold/30 hover:-translate-y-1 transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none group">
                        <Icon icon="carbon:save" class="text-lg transition-transform group-hover:rotate-12" />
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

                <div v-if="mustVerifyEmail && user.email_verified_at === null"
                    class="bg-amber-50 rounded-2xl p-4 flex items-center gap-4 border border-amber-100/50">
                    <Icon icon="carbon:warning" class="text-amber-500 text-xl flex-shrink-0" />
                    <div>
                        <p class="text-xs font-bold text-amber-900 leading-tight">
                            {{ isEn ? 'Verify your email' : 'تأكيد بريدك الإلكتروني' }}
                        </p>
                        <Link :href="route('verification.send')" method="post" as="button"
                            class="text-[10px] font-black uppercase tracking-widest text-amber-600 hover:text-amber-700 underline mt-1">
                            {{ isEn ? 'Resend link' : 'إعادة إرسال الرابط' }}
                        </Link>
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>

<style scoped>
textarea {
    resize: none;
}
</style>
