<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, onMounted, watch } from 'vue';
import axios from 'axios';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    estate: { type: Object, default: null },
    cities: Array,
    types: Object,
    translations: Object,
});

const activeTab = ref('en'); // 'en' or 'ar'
const towns = ref([]);
const isLoadingTowns = ref(false);

const form = useForm({
    title: props.estate?.title || '',
    title_ar: props.estate?.title_ar || '',
    slug: props.estate?.slug || '',
    short: props.estate?.short || '',
    short_ar: props.estate?.short_ar || '',
    keywords: props.estate?.keywords || '',
    keywords_ar: props.estate?.keywords_ar || '',
    content: props.estate?.content || '',
    content_ar: props.estate?.content_ar || '',
    min: props.estate?.min || '',
    max: props.estate?.max || '',
    city: props.estate?.city?.id || '',
    town_id: props.estate?.town_id || '',
    type: props.estate?.type || '',
    images: [],
});

const existingImages = ref(props.estate?.image ?? []);
const previewImages = ref([]);

const fetchTowns = async (cityId) => {
    if (!cityId) {
        towns.value = [];
        return;
    }

    isLoadingTowns.value = true;
    try {
        const response = await axios.post('/towns', { city: cityId });
        towns.value = response.data;
    } catch (error) {
        console.error('Error fetching towns:', error);
    } finally {
        isLoadingTowns.value = false;
    }
};

onMounted(() => {
    if (form.city) {
        fetchTowns(form.city);
    }
});

watch(() => form.city, (newCity) => {
    fetchTowns(newCity);
});

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    files.forEach(file => {
        form.images.push(file);
        const reader = new FileReader();
        reader.onload = (event) => {
            previewImages.value.push(event.target.result);
        };
        reader.readAsDataURL(file);
    });
};

const removeNewImage = (index) => {
    form.images.splice(index, 1);
    previewImages.value.splice(index, 1);
};

const removeExistingImage = async (img, index) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure you want to delete this image?')) {
        try {
            await axios.post('/delete-estate-image/' + props.estate.id, {
                image: img,
            });
            existingImages.value.splice(index, 1);
        } catch (error) {
            console.error('Error deleting image:', error);
        }
    }
};

const submitForm = () => {
    if (props.estate) {
        // Inertia useForm handles file uploads with _method: 'PUT'
        form.put(route('estates.update', props.estate.id), {
            forceFormData: true,
            onSuccess: () => {
                // Handle success
            },
        });
    } else {
        form.post(route('estates.store'), {
            onSuccess: () => {
                // Handle success
            },
        });
    }
};
</script>

<template>

    <Head :title="estate ? translations.edit_estate : translations.add_estate" />

    <AuthenticatedLayout :title="estate ? translations.edit_estate : translations.add_estate">
        <template #content>
            <div class="max-w-5xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ estate ? translations.edit_estate : translations.add_estate }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ estate ? 'Update property details and images.' : 'Add a new property to your portfolio.'
                            }}
                        </p>
                    </div>
                    <Link :href="route('estates.index')"
                        class="flex items-center text-sm font-bold text-gray-400 hover:text-brand-maroon transition-colors group">
                        <Icon icon="carbon:arrow-left" class="mr-2 group-hover:-translate-x-1 transition-transform" />
                        {{ isEn ? 'Back to List' : 'العودة للقائمة' }}
                    </Link>
                </div>

                <form @submit.prevent="submitForm" class="space-y-8">
                    <!-- Main Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column: Content (EN/AR Tabs) -->
                        <div class="lg:col-span-2 space-y-8">
                            <div class="bg-white rounded-[32px] p-8 shadow-sm ring-1 ring-gray-100">

                                <!-- Lang Tabs -->
                                <div class="flex items-center gap-2 mb-8 bg-gray-50 p-1.5 rounded-2xl w-fit">
                                    <button type="button" @click="activeTab = 'en'"
                                        :class="['px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all', activeTab === 'en' ? 'bg-white text-brand-maroon shadow-sm' : 'text-gray-400 hover:text-gray-600']">
                                        {{ translations.en }}
                                    </button>
                                    <button type="button" @click="activeTab = 'ar'"
                                        :class="['px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all', activeTab === 'ar' ? 'bg-white text-brand-maroon shadow-sm' : 'text-gray-400 hover:text-gray-600']">
                                        {{ translations.ar }}
                                    </button>
                                </div>

                                <!-- Tab: English -->
                                <div v-show="activeTab === 'en'" class="space-y-6">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.title }} (EN)</label>
                                        <input v-model="form.title" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.title">
                                        <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.title }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.shortmeta }} (EN)</label>
                                        <input v-model="form.short" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.shortmeta">
                                        <div v-if="form.errors.short" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.short }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.keywords }} (EN)</label>
                                        <input v-model="form.keywords" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            placeholder="tag1, tag2, ...">
                                        <div v-if="form.errors.keywords" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.keywords }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.content }} (EN)</label>
                                        <textarea v-model="form.content" rows="10" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.content"></textarea>
                                        <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.content }}
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab: Arabic -->
                                <div v-show="activeTab === 'ar'" class="space-y-6 text-right" dir="rtl">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.title }} (AR)</label>
                                        <input v-model="form.title_ar" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.title">
                                        <div v-if="form.errors.title_ar" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.title_ar }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.shortmeta }} (AR)</label>
                                        <input v-model="form.short_ar" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.shortmeta">
                                        <div v-if="form.errors.short_ar" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.short_ar }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.keywords }} (AR)</label>
                                        <input v-model="form.keywords_ar" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            placeholder="كلمة1, كلمة2, ...">
                                        <div v-if="form.errors.keywords_ar" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.keywords_ar }}
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.content }} (AR)</label>
                                        <textarea v-model="form.content_ar" rows="10" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700"
                                            :placeholder="translations.content"></textarea>
                                        <div v-if="form.errors.content_ar" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.content_ar }}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Images Section -->
                            <div class="bg-white rounded-[32px] p-8 shadow-sm ring-1 ring-gray-100">
                                <h3
                                    class="text-lg font-black text-brand-maroon uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">
                                    {{ translations.images }}
                                </h3>

                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-8">
                                    <!-- Existing Images -->
                                    <div v-for="(img, index) in existingImages" :key="img"
                                        class="relative aspect-square group rounded-2xl overflow-hidden ring-1 ring-gray-100">
                                        <img :src="'/storage/' + img" class="h-full w-full object-cover">
                                        <button type="button" @click="removeExistingImage(img, index)"
                                            class="absolute top-2 right-2 p-1.5 rounded-lg bg-red-500/80 text-white opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm z-10">
                                            <Icon icon="carbon:trash-can" class="text-sm" />
                                        </button>
                                        <div
                                            class="absolute inset-0 bg-brand-maroon/20 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </div>

                                    <!-- New Images Previews -->
                                    <div v-for="(preview, index) in previewImages" :key="index"
                                        class="relative aspect-square group rounded-2xl overflow-hidden ring-1 ring-brand-gold/20 animate-scale-in">
                                        <img :src="preview" class="h-full w-full object-cover">
                                        <button type="button" @click="removeNewImage(index)"
                                            class="absolute top-2 right-2 p-1.5 rounded-lg bg-brand-maroon/80 text-white opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-sm">
                                            <Icon icon="carbon:close" class="text-sm" />
                                        </button>
                                        <div
                                            class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-brand-gold text-[8px] font-black text-brand-maroon uppercase tracking-widest">
                                            New</div>
                                    </div>

                                    <!-- Upload Placeholder -->
                                    <label
                                        class="relative aspect-square cursor-pointer active:scale-95 transition-all group">
                                        <input type="file" multiple @change="handleImageUpload" class="hidden">
                                        <div
                                            class="h-full w-full flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-400 group-hover:border-brand-gold group-hover:bg-brand-gold/5 transition-all">
                                            <Icon icon="carbon:cloud-upload"
                                                class="text-3xl text-gray-400 group-hover:text-brand-gold transition-colors" />
                                            <span
                                                class="text-[10px] font-black text-gray-400 group-hover:text-brand-gold uppercase tracking-widest mt-2">Upload</span>
                                        </div>
                                    </label>

                                    <div v-if="form.errors.images" class="text-red-500 text-sm mt-1">
                                        {{ form.errors.images }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Settings -->
                        <div class="space-y-8">
                            <div class="bg-white rounded-[32px] p-8 shadow-sm ring-1 ring-gray-100 sticky top-8">
                                <h3
                                    class="text-lg font-black text-brand-maroon uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">
                                    {{ isEn ? 'Configuration' : 'الإعدادات' }}
                                </h3>

                                <div class="space-y-6">
                                    <!-- Slug -->
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.slug }}</label>
                                        <input v-model="form.slug" type="text" required
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700"
                                            placeholder="property-slug-here">
                                        <div v-if="form.errors.slug" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.slug }}
                                        </div>
                                    </div>

                                    <!-- Type -->
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.type }}</label>
                                        <select v-model="form.type" required
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700">
                                            <option value="" disabled>{{ translations.type }}</option>
                                            <option v-for="(label, key) in types" :key="key" :value="key">{{ label }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.type }}
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">
                                            {{ translations.city }}</label>
                                        <select v-model="form.city" required
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700">
                                            <option value="" disabled>{{ translations.city }}</option>
                                            <option v-for="city in cities" :key="city.id" :value="city.id">
                                                {{ isEn ? city.name : city.name_ar }}</option>
                                        </select>
                                    </div>

                                    <!-- Town -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label
                                                class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">
                                                {{ translations.town }}
                                            </label>
                                            <Icon v-if="isLoadingTowns" icon="carbon:circle-dash"
                                                class="text-brand-gold animate-spin" />
                                        </div>
                                        <select v-model="form.town_id" :disabled="!form.city || isLoadingTowns"
                                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700 disabled:opacity-50">
                                            <option value="" disabled>{{ translations.town }}</option>
                                            <option v-for="(town, index) in towns" :key="index" :value="town.id">
                                                {{ isEn ? town.name : town.name_ar }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.town_id" class="text-red-500 text-sm mt-1">
                                            {{ form.errors.town_id }}
                                        </div>
                                    </div>

                                    <!-- Prices -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label
                                                class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">
                                                {{ translations.min }}
                                            </label>
                                            <div class="relative">
                                                <input v-model="form.min" type="number"
                                                    class="w-full pl-4 pr-8 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700"
                                                    placeholder="0">
                                                <span
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-300">$</span>
                                            </div>
                                            <div v-if="form.errors.min" class="text-red-500 text-sm mt-1">
                                                {{ form.errors.min }}
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label
                                                class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">
                                                {{ translations.max }}
                                            </label>
                                            <div class="relative">
                                                <input v-model="form.max" type="number"
                                                    class="w-full pl-4 pr-8 py-3 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-700"
                                                    placeholder="0">
                                                <span
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-gray-300">$</span>
                                            </div>
                                            <div v-if="form.errors.max" class="text-red-500 text-sm mt-1">
                                                {{ form.errors.max }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-6">
                                        <button type="submit" :disabled="form.processing"
                                            class="w-full flex items-center justify-center px-8 py-4 rounded-2xl bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-sm disabled:opacity-50 group">
                                            <Icon v-if="form.processing" icon="carbon:circle-dash"
                                                class="text-xl mr-3 animate-spin" />
                                            <Icon v-else :icon="estate ? 'carbon:save' : 'carbon:add-alt'"
                                                class="text-xl mr-3 group-hover:rotate-12 transition-transform" />
                                            {{ estate ? translations.update : translations.add }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fade-in-down 0.5s ease-out forwards;
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
</style>
