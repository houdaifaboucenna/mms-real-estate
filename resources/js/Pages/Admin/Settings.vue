<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import axios from 'axios';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    settings: Object,
    translations: Object,
});

// Helper to get setting value
const getSetting = (name) => props.settings[name]?.value || '';

const form = useForm({
    facebook: getSetting('facebook'),
    instagram: getSetting('instagram'),
    twitter: getSetting('twitter'),
    youtube: getSetting('youtube'),
    telegram: getSetting('telegram'),
    whatsapp: getSetting('whatsapp'),
    phone: getSetting('phone'),
    email: getSetting('email'),
    desc: getSetting('desc'),
    desc_ar: getSetting('desc_ar'),
    keywords: getSetting('keywords'),
    keywords_ar: getSetting('keywords_ar'),
    home_imgs: [], // For new uploads
});

const existingSliderImages = ref(JSON.parse(getSetting('home_imgs') || '[]'));
const previewNewImages = ref([]);
const activeTab = ref('general'); // general, slider, seo, contact
const activeLang = ref('en');

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    files.forEach(file => {
        form.home_imgs.push(file);
        const reader = new FileReader();
        reader.onload = (event) => {
            previewNewImages.value.push(event.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeNewImage = (index) => {
    form.home_imgs.splice(index, 1);
    previewNewImages.value.splice(index, 1);
};

const removeExistingImage = async (img, index) => {
    if (confirm(isEn.value ? 'Are you sure you want to delete this image?' : 'هل أنت متأكد من حذف هذه الصورة؟')) {
        try {
            await axios.delete(route('settings.deleteImage'), {
                data: { img: img }
            });
            existingSliderImages.value.splice(index, 1);
        } catch (error) {
            console.error('Error deleting image:', error);
        }
    }
};

const submit = () => {
    form.put(route('settings.update'), {
        forceFormData: true,
        onSuccess: () => {
            previewNewImages.value = [];
            form.home_imgs = [];
        },
    });
};
</script>

<template>

    <Head :title="isEn ? 'Application Settings' : 'إعدادات التطبيق'" />

    <AuthenticatedLayout :title="isEn ? 'Application Settings' : 'إعدادات التطبيق'">
        <template #content>
            <div class="max-w-6xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div
                    class="flex items-center justify-between bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ isEn ? 'Global Settings' : 'الإعدادات العامة' }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ isEn ? 'Configure your website appearance, SEO, and contact details.'
                                : 'تكوين مظهر موقعك، SEO، وتفاصيل الاتصال.' }}
                        </p>
                    </div>
                    <button @click="submit" :disabled="form.processing"
                        class="flex items-center px-8 py-4 rounded-2xl bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-xs disabled:opacity-50 group">
                        <Icon v-if="form.processing" icon="line-md:loading-twotone-loop" class="text-xl mr-2" />
                        <Icon v-else icon="carbon:save"
                            class="text-xl mr-2 group-hover:rotate-12 transition-transform" />
                        {{ isEn ? 'Update All Settings' : 'تحديث كافة الإعدادات' }}
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <!-- Sidebar Navigation -->
                    <div class="lg:col-span-1 space-y-2">
                        <button v-for="tab in [
                            { id: 'general', label: isEn ? 'Social Links' : 'روابط التواصل', icon: 'carbon:share-knowledge' },
                            { id: 'contact', label: isEn ? 'Contact Info' : 'معلومات الاتصال', icon: 'carbon:phone' },
                            { id: 'seo', label: isEn ? 'Meta & SEO' : 'البيانات الوصفية', icon: 'carbon:search' },
                            { id: 'slider', label: isEn ? 'Home Slider' : 'شريط الصور', icon: 'carbon:image' }
                        ]" :key="tab.id" @click="activeTab = tab.id"
                            class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl transition-all text-left"
                            :class="activeTab === tab.id ? 'bg-brand-maroon text-white shadow-lg shadow-brand-maroon/20 translate-x-1' : 'bg-white text-gray-500 hover:bg-gray-50 ring-1 ring-gray-100'">
                            <Icon :icon="tab.icon" class="text-xl" />
                            <span class="font-bold text-sm">{{ tab.label }}</span>
                        </button>
                    </div>

                    <!-- Main Content Panel -->
                    <div class="lg:col-span-3">
                        <form @submit.prevent="submit" class="space-y-8 animate-fade-in">

                            <!-- General: Social Links -->
                            <div v-show="activeTab === 'general'"
                                class="bg-white rounded-[40px] p-10 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 border-b-8 border-brand-maroon">
                                <div class="flex items-center gap-4 mb-10">
                                    <div
                                        class="h-14 w-14 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                        <Icon icon="carbon:share-knowledge" class="text-3xl" />
                                    </div>
                                    <h3 class="text-2xl font-black text-brand-maroon tracking-tight">
                                        {{ isEn ? 'Social Networks' : 'شبكات التواصل' }}</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div v-for="social in [
                                        { id: 'facebook', label: 'Facebook', icon: 'logos:facebook' },
                                        { id: 'instagram', label: 'Instagram', icon: 'logos:instagram-icon' },
                                        { id: 'twitter', label: 'Twitter (X)', icon: 'logos:twitter' },
                                        { id: 'youtube', label: 'YouTube', icon: 'logos:youtube-icon' },
                                        { id: 'telegram', label: 'Telegram', icon: 'logos:telegram' }
                                    ]" :key="social.id" class="space-y-2">
                                        <label
                                            class="flex items-center gap-2 text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">
                                            <Icon :icon="social.icon" /> {{ social.label }}
                                        </label>
                                        <input v-model="form[social.id]" type="url"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                            :placeholder="'https://' + social.id + '.com/yourprofile'">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <div v-show="activeTab === 'contact'"
                                class="bg-white rounded-[40px] p-10 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 border-b-8 border-brand-gold">
                                <div class="flex items-center gap-4 mb-10">
                                    <div
                                        class="h-14 w-14 rounded-2xl bg-brand-gold/10 flex items-center justify-center text-brand-gold-dark">
                                        <Icon icon="carbon:phone" class="text-3xl" />
                                    </div>
                                    <h3 class="text-2xl font-black text-brand-maroon tracking-tight">
                                        {{ isEn ? 'Contact Details' : 'بيانات الاتصال' }}</h3>
                                </div>
                                <div class="space-y-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">{{
                                                    isEn ? 'WhatsApp Number' : 'رقم الواتساب' }}</label>
                                            <input v-model="form.whatsapp" type="text"
                                                class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                                placeholder="+1234567890">
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">{{
                                                    isEn ? 'Phone Number' : 'رقم الهاتف' }}</label>
                                            <input v-model="form.phone" type="text"
                                                class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                                placeholder="+1234567890">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">{{
                                                isEn ? 'Public Email' : 'البريد الإلكتروني' }}</label>
                                        <input v-model="form.email" type="email"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                            placeholder="contact@example.com">
                                    </div>
                                </div>
                            </div>

                            <!-- SEO & Meta -->
                            <div v-show="activeTab === 'seo'"
                                class="bg-white rounded-[40px] p-10 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 border-b-8 border-brand-maroon">
                                <div class="flex items-center justify-between mb-10">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-14 w-14 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                            <Icon icon="carbon:search" class="text-3xl" />
                                        </div>
                                        <h3 class="text-2xl font-black text-brand-maroon tracking-tight">SEO
                                            Configuration</h3>
                                    </div>
                                    <div class="flex bg-gray-50 p-1 rounded-2xl ring-1 ring-gray-100">
                                        <button type="button" @click="activeLang = 'en'"
                                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all"
                                            :class="activeLang === 'en' ? 'bg-white shadow-md text-brand-maroon' : 'text-gray-400'">
                                            EN
                                        </button>
                                        <button type="button" @click="activeLang = 'ar'"
                                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all"
                                            :class="activeLang === 'ar' ? 'bg-white shadow-md text-brand-maroon' : 'text-gray-400'">
                                            AR
                                        </button>
                                    </div>
                                </div>

                                <div class="space-y-8" :dir="activeLang === 'ar' ? 'rtl' : 'ltr'">
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">{{
                                                isEn ? 'Meta Description' : 'وصف الموقع' }}</label>
                                        <textarea v-if="activeLang === 'en'" v-model="form.desc" rows="4"
                                            class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-medium text-gray-600 leading-relaxed shadow-inner"
                                            placeholder="Brief description for search engines..."></textarea>
                                        <textarea v-else v-model="form.desc_ar" rows="4"
                                            class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-medium text-gray-600 leading-relaxed shadow-inner"
                                            placeholder="وصف مختصر لمحركات البحث..."></textarea>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em]">{{
                                                isEn ? 'Main Keywords' : 'الكلمات المفتاحية' }}</label>
                                        <textarea v-if="activeLang === 'en'" v-model="form.keywords" rows="3"
                                            class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-500 shadow-inner italic"
                                            placeholder="real estate, luxury homes, rentals..."></textarea>
                                        <textarea v-else v-model="form.keywords_ar" rows="3"
                                            class="w-full px-6 py-4 rounded-3xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-500 shadow-inner italic"
                                            placeholder="عقارات، شقق فاخرة، إيجار..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Slider Images -->
                            <div v-show="activeTab === 'slider'"
                                class="bg-white rounded-[40px] p-10 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 border-b-8 border-brand-gold">
                                <div class="flex items-center gap-4 mb-10">
                                    <div
                                        class="h-14 w-14 rounded-2xl bg-brand-gold/10 flex items-center justify-center text-brand-gold-dark">
                                        <Icon icon="carbon:image" class="text-3xl" />
                                    </div>
                                    <h3 class="text-2xl font-black text-brand-maroon tracking-tight">
                                        {{ isEn ? 'Home Slider Images' : 'صور شريط الرئيسية' }}</h3>
                                </div>

                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                                    <!-- Existing Images -->
                                    <div v-for="(img, index) in existingSliderImages" :key="img"
                                        class="relative aspect-[4/3] group rounded-3xl overflow-hidden shadow-md ring-1 ring-gray-100">
                                        <img :src="'/storage/' + img" class="h-full w-full object-cover">
                                        <div
                                            class="absolute inset-0 bg-brand-maroon/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                        <button type="button" @click="removeExistingImage(img, index)"
                                            class="absolute top-3 right-3 p-2.5 rounded-xl bg-white/90 backdrop-blur shadow-xl text-brand-red opacity-0 group-hover:opacity-100 transition-all hover:scale-110 active:scale-95">
                                            <Icon icon="carbon:trash-can" class="text-xl" />
                                        </button>
                                    </div>

                                    <!-- New Uploads -->
                                    <div v-for="(preview, index) in previewNewImages" :key="index"
                                        class="relative aspect-[4/3] group rounded-3xl overflow-hidden shadow-md ring-4 ring-brand-gold/30 animate-scale-in">
                                        <img :src="preview" class="h-full w-full object-cover blur-[1px]">
                                        <div class="absolute inset-0 flex items-center justify-center bg-brand-gold/10">
                                            <span
                                                class="px-3 py-1 rounded-full bg-brand-gold text-[8px] font-black text-brand-maroon uppercase tracking-widest shadow-lg">New</span>
                                        </div>
                                        <button type="button" @click="removeNewImage(index)"
                                            class="absolute top-3 right-3 p-2.5 rounded-xl bg-brand-maroon/90 backdrop-blur shadow-xl text-white transition-all hover:scale-110 active:scale-95">
                                            <Icon icon="carbon:close" class="text-xl" />
                                        </button>
                                    </div>

                                    <!-- Add Button -->
                                    <label
                                        class="relative aspect-[4/3] cursor-pointer group active:scale-95 transition-all">
                                        <input type="file" multiple @change="handleImageUpload" class="hidden"
                                            accept="image/*">
                                        <div
                                            class="h-full w-full flex flex-col items-center justify-center rounded-3xl border-4 border-dashed border-gray-100 group-hover:border-brand-gold group-hover:bg-brand-gold/5 transition-all">
                                            <div
                                                class="h-14 w-14 rounded-full bg-gray-50 flex items-center justify-center text-gray-300 group-hover:bg-brand-gold/10 group-hover:text-brand-gold-dark transition-all">
                                                <Icon icon="carbon:cloud-upload" class="text-3xl" />
                                            </div>
                                            <span
                                                class="text-[10px] font-black text-gray-400 group-hover:text-brand-gold-dark uppercase tracking-widest mt-3 transition-colors">Add
                                                Images</span>
                                        </div>
                                    </label>
                                </div>
                                <div v-if="form.errors.home_imgs"
                                    class="mt-4 text-red-500 text-xs font-bold uppercase tracking-widest">{{
                                        form.errors.home_imgs }}</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out forwards;
}

.animate-fade-in {
    animation: fade-in 0.4s ease-out forwards;
}

.animate-scale-in {
    animation: scale-in 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
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

@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.9);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

textarea {
    resize: none;
}
</style>
