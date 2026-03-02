<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    post: {
        type: Object,
        default: null,
    },
    translations: Object,
});

const form = useForm({
    id: props.post?.id || null,
    title: props.post?.title || '',
    title_ar: props.post?.title_ar || '',
    slug: props.post?.slug || '',
    short: props.post?.short || '',
    short_ar: props.post?.short_ar || '',
    keywords: props.post?.keywords || '',
    keywords_ar: props.post?.keywords_ar || '',
    content: props.post?.content || '',
    content_ar: props.post?.content_ar || '',
    image: null,
    user_id: props.post?.user_id || page.props.auth.user.id,
    _method: props.post ? 'PUT' : 'POST',
});

const activeLang = ref('en'); // en, ar
const imagePreview = ref(props.post?.image ? '/storage/' + props.post.image : null);

const handleImageUpload = (e) => {
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
    if (props.post) {
        // For file uploads in Laravel/Inertia, we use POST with _method=PUT
        form.post(route('posts.update', props.post.id), {
            forceFormData: true,
            preserveScroll: true,
        });
    } else {
        form.post(route('posts.store'), {
            forceFormData: true,
        });
    }
};

const slugify = (text) => {
    return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w-]+/g, '')
        .replace(/--+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
};

const updateSlug = () => {
    if (!props.post && form.title) {
        form.slug = slugify(form.title);
    }
};
</script>

<template>

    <Head :title="post ? translations.edit_article : translations.add_article" />

    <AuthenticatedLayout :title="post ? translations.edit_article : translations.add_article">
        <template #content>
            <div class="max-w-5xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ post ? translations.edit_article : translations.add_article }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ isEn ? 'Fill in the details below to publish your article.'
                                : 'اكمل البيانات أدناه لنشر مقالك.' }}
                        </p>
                    </div>
                    <Link :href="route('posts.index')"
                        class="flex items-center text-sm font-bold text-gray-400 hover:text-brand-maroon transition-colors group">
                        <Icon icon="carbon:arrow-left" class="mr-2 group-hover:-translate-x-1 transition-transform" />
                        {{ isEn ? 'Back to List' : 'العودة للقائمة' }}
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Form Layout -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Left Column: Main Info -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- Content Card -->
                            <div
                                class="bg-white rounded-[32px] p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 border-b-4 border-brand-maroon">
                                <!-- Lang Tabs -->
                                <div class="flex items-center justify-between mb-8">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 rounded-xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                            <Icon icon="carbon:document" class="text-xl" />
                                        </div>
                                        <h3 class="text-lg font-bold text-brand-maroon">{{ isEn ? 'Article Content' :
                                            'محتوى المقال' }}</h3>
                                    </div>
                                    <div class="flex bg-gray-50 p-1 rounded-2xl ring-1 ring-gray-100">
                                        <button type="button" @click="activeLang = 'en'"
                                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all"
                                            :class="activeLang === 'en' ? 'bg-white shadow-md text-brand-maroon' : 'text-gray-400 hover:text-gray-600'">
                                            {{ translations.en }}
                                        </button>
                                        <button type="button" @click="activeLang = 'ar'"
                                            class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all"
                                            :class="activeLang === 'ar' ? 'bg-white shadow-md text-brand-maroon' : 'text-gray-400 hover:text-gray-600'">
                                            {{ translations.ar }}
                                        </button>
                                    </div>
                                </div>

                                <!-- Dynamic Inputs -->
                                <div class="space-y-8" v-show="activeLang === 'en'">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.title }} (EN)</label>
                                        <input v-model="form.title" @input="updateSlug" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            :placeholder="translations.title">
                                        <div v-if="form.errors.title"
                                            class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">
                                            {{ form.errors.title }}</div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.shortmeta }} (EN)</label>
                                        <input v-model="form.short" type="text"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            :placeholder="translations.shortmeta">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.keywords }} (EN)</label>
                                        <input v-model="form.keywords" type="text"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            placeholder="key1, key2...">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.content }} (EN)</label>
                                        <textarea v-model="form.content" rows="12" required
                                            class="w-full px-6 py-4 rounded-[32px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-600 leading-relaxed shadow-inner custom-scrollbar"
                                            :placeholder="translations.content"></textarea>
                                        <div v-if="form.errors.content"
                                            class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">
                                            {{ form.errors.content }}</div>
                                    </div>
                                </div>

                                <div class="space-y-8 text-right" v-show="activeLang === 'ar'" dir="rtl">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.title }} (AR)</label>
                                        <input v-model="form.title_ar" type="text" required
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            :placeholder="translations.title">
                                        <div v-if="form.errors.title_ar"
                                            class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">
                                            {{ form.errors.title_ar }}</div>
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.shortmeta }} (AR)</label>
                                        <input v-model="form.short_ar" type="text"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            :placeholder="translations.shortmeta">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.keywords }} (AR)</label>
                                        <input v-model="form.keywords_ar" type="text"
                                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-700 shadow-inner"
                                            placeholder="كلمة١, كلمة٢...">
                                    </div>
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest mr-1">{{
                                                translations.content }} (AR)</label>
                                        <textarea v-model="form.content_ar" rows="12" required
                                            class="w-full px-6 py-4 rounded-[32px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-gray-600 leading-relaxed shadow-inner custom-scrollbar"
                                            :placeholder="translations.content"></textarea>
                                        <div v-if="form.errors.content_ar"
                                            class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">
                                            {{ form.errors.content_ar }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Image & Settings -->
                        <div class="space-y-8">
                            <!-- Image Card -->
                            <div class="bg-white rounded-[32px] p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100">
                                <h3
                                    class="text-lg font-black text-brand-maroon uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">
                                    {{ translations.images }}
                                </h3>

                                <div class="space-y-6">
                                    <div v-if="imagePreview"
                                        class="relative group aspect-[16/10] rounded-2xl overflow-hidden shadow-lg ring-1 ring-gray-100">
                                        <img :src="imagePreview"
                                            class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <button type="button" @click="imagePreview = null; form.image = null"
                                            class="absolute top-2 right-2 p-2 rounded-xl bg-white shadow-xl text-brand-red opacity-0 group-hover:opacity-100 transition-all hover:scale-110">
                                            <Icon icon="carbon:trash-can" class="text-xl" />
                                        </button>
                                    </div>
                                    <label v-else
                                        class="flex flex-col items-center justify-center aspect-[16/10] rounded-2xl border-2 border-dashed border-gray-200 hover:border-brand-gold hover:bg-brand-gold/5 transition-all cursor-pointer group">
                                        <Icon icon="carbon:cloud-upload"
                                            class="text-4xl text-gray-300 group-hover:text-brand-gold transition-colors" />
                                        <span
                                            class="text-[10px] font-black text-gray-400 group-hover:text-brand-gold uppercase tracking-widest mt-2">{{
                                                translations.add }} {{ translations.images }}</span>
                                        <input type="file" @change="handleImageUpload" class="hidden" accept="image/*">
                                    </label>
                                    <div v-if="form.errors.image"
                                        class="text-red-500 text-[10px] font-bold uppercase tracking-tighter">
                                        {{ form.errors.image }}
                                    </div>
                                </div>
                            </div>

                            <!-- Settings Card -->
                            <div
                                class="bg-white rounded-[32px] p-8 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100 sticky top-8">
                                <h3
                                    class="text-lg font-black text-brand-maroon uppercase tracking-widest mb-6 border-b border-gray-50 pb-4">
                                    SEO {{ translations.slug }}
                                </h3>
                                <div class="space-y-6">
                                    <div class="space-y-2">
                                        <label
                                            class="text-xs font-black text-brand-maroon uppercase tracking-widest ml-1">{{
                                                translations.slug }}</label>
                                        <input v-model="form.slug" type="text" required
                                            class="w-full px-6 py-4 rounded-xl bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/20 focus:border-brand-gold transition-all font-medium text-sm text-gray-500 shadow-inner italic"
                                            placeholder="article-slug-here">
                                        <div v-if="form.errors.slug"
                                            class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">
                                            {{ form.errors.slug }}</div>
                                    </div>

                                    <div class="pt-4 space-y-3">
                                        <button type="submit" :disabled="form.processing"
                                            class="w-full flex items-center justify-center px-8 py-5 rounded-2xl bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-xs disabled:opacity-50 group">
                                            <Icon v-if="form.processing" icon="line-md:loading-twotone-loop"
                                                class="text-xl mr-3" />
                                            <Icon v-else :icon="post ? 'carbon:save' : 'carbon:add-alt'"
                                                class="text-xl mr-3 group-hover:rotate-12 transition-transform" />
                                            {{ post ? translations.update : translations.add }}
                                        </button>
                                        <Link :href="route('posts.index')"
                                            class="w-full flex items-center justify-center px-8 py-4 rounded-2xl bg-gray-50 text-gray-400 font-black uppercase tracking-widest text-[10px] hover:bg-gray-100 transition-all">
                                            {{ isEn ? 'Cancel Changes' : 'إلغاء التغييرات' }}
                                        </Link>
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

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(69, 7, 6, 0.1);
    border-radius: 40px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(69, 7, 6, 0.2);
}

textarea {
    resize: none;
}
</style>
