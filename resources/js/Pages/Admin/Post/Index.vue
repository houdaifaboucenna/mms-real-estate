<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    posts: Array,
    translations: Object,
});

const isModalOpen = ref(false);
const selectedPost = ref(null);

const openPreview = (post) => {
    selectedPost.value = post;
    isModalOpen.value = true;
};

const closePreview = () => {
    isModalOpen.value = false;
    selectedPost.value = null;
};

const deletePost = (id) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure?')) {
        router.delete(route('posts.destroy', id), {
            preserveScroll: true,
        });
    }
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString(page.props.locale === 'ar' ? 'ar-EG' : 'en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};
</script>

<template>

    <Head :title="translations.all_articles" />

    <AuthenticatedLayout :title="translations.all_articles">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ translations.all_articles }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ isEn ? 'Manage your blog posts and articles.' : 'إدارة المقالات والتدوينات الخاصة بك.' }}
                        </p>
                    </div>
                    <Link :href="route('posts.create')"
                        class="flex items-center px-6 py-3 rounded-2xl bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-xs group">
                        <Icon icon="carbon:add-alt" class="text-xl mr-2 group-hover:rotate-12 transition-transform" />
                        {{ translations.add_article }}
                    </Link>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-[40px] shadow-2xl shadow-gray-200/50 overflow-hidden ring-1 ring-gray-100">
                    <div class="overflow-x-auto min-h-[400px]">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50/50 sticky top-0 z-10">
                                <tr>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                        {{ translations.number }}</th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                        {{ translations.title }}</th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                        {{ translations.writer }}</th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                        {{ translations.date }}</th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100 text-center">
                                        {{ translations.actions }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="(post, index) in posts.data" :key="post.id"
                                    class="group hover:bg-gray-50/50 transition-colors">
                                    <td
                                        class="px-8 py-5 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic group-hover:text-brand-gold transition-colors">
                                        #{{ post.id }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-16 w-16 rounded-2xl overflow-hidden ring-1 ring-gray-100 shrink-0 group-hover:ring-brand-gold/30 transition-all">
                                                <img :src="'/storage/' + post.image"
                                                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                            </div>
                                            <div class="flex flex-col max-w-md">
                                                <span
                                                    class="text-sm font-bold text-brand-maroon group-hover:text-brand-red transition-colors line-clamp-1">{{
                                                        isEn ? post.title : post.title_ar }}</span>
                                                <span
                                                    class="text-[10px] text-gray-400 font-medium truncate italic mt-0.5">{{
                                                        post.slug }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="h-8 w-8 rounded-full bg-brand-maroon/5 flex items-center justify-center text-brand-maroon font-black text-[10px]">
                                                {{ post.user.name.charAt(0) }}
                                            </div>
                                            <span class="text-xs font-bold text-gray-600">{{ post.user.name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-gray-600">
                                                {{ formatDate(post.created_at) }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 font-medium tracking-tighter">
                                                {{ isEn ? 'Posted' : 'نشرت' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="openPreview(post)"
                                                class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-brand-gold/10 hover:text-brand-gold-dark transition-all group/btn"
                                                v-tooltip="translations.preview">
                                                <Icon icon="carbon:view"
                                                    class="text-lg group-hover/btn:scale-110 transition-transform" />
                                            </button>
                                            <Link :href="route('posts.edit', post.id)"
                                                class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-brand-maroon/10 hover:text-brand-maroon transition-all group/btn"
                                                v-tooltip="translations.edit">
                                                <Icon icon="carbon:edit"
                                                    class="text-lg group-hover/btn:scale-110 transition-transform" />
                                            </Link>
                                            <button @click="deletePost(post.id)"
                                                class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 transition-all group/btn"
                                                v-tooltip="translations.delete">
                                                <Icon icon="carbon:trash-can"
                                                    class="text-lg group-hover/btn:scale-110 transition-transform" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="posts.data.length === 0">
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 ring-1 ring-gray-100">
                                                <Icon icon="carbon:document-blank" class="text-4xl text-gray-200" />
                                            </div>
                                            <h3 class="text-brand-maroon font-bold text-lg italic">
                                                {{ isEn ? 'No articles found' : 'لا يوجد مقالات' }}</h3>
                                            <p class="text-gray-400 text-sm mt-1">
                                                {{ isEn ? 'Get started by creating your first article.'
                                                    : 'ابدأ بإنشاء أول مقال لك.' }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <Pagination :links="posts.links" />
            </div>

            <!-- Preview Modal -->
            <div v-show="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                @click.self="closePreview">
                <!-- Overlay -->
                <div class="absolute inset-0 bg-brand-maroon/40 backdrop-blur-md transition-opacity duration-500"
                    :class="isModalOpen ? 'opacity-100' : 'opacity-0'"></div>

                <!-- Modal Box -->
                <div
                    class="relative bg-white w-full max-w-4xl max-h-[90vh] rounded-[40px] shadow-2xl overflow-hidden animate-modal-in ring-1 ring-gray-100 flex flex-col">
                    <!-- Modal Header -->
                    <div
                        class="px-10 py-8 bg-gray-50/50 border-b border-gray-100 flex items-center justify-between shrink-0">
                        <div class="flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-2xl bg-brand-gold/10 flex items-center justify-center text-brand-gold-dark font-black text-lg">
                                #
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-brand-maroon tracking-tight">{{ translations.article
                                    }} Preview</h3>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-0.5">Article
                                    Details Overview</p>
                            </div>
                        </div>
                        <button @click="closePreview"
                            class="p-4 rounded-2xl bg-white hover:bg-gray-100 text-gray-400 hover:text-brand-maroon transition-all shadow-sm ring-1 ring-gray-100">
                            <Icon icon="carbon:close" class="text-2xl" />
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div v-if="selectedPost" class="p-10 overflow-y-auto custom-scrollbar flex-grow">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                            <!-- Image Column -->
                            <div class="space-y-6">
                                <div
                                    class="aspect-square rounded-[32px] overflow-hidden shadow-xl ring-1 ring-gray-100">
                                    <img :src="'/storage/' + selectedPost.image" class="h-full w-full object-cover">
                                </div>

                                <div class="bg-gray-50/50 rounded-3xl p-6 space-y-4 ring-1 ring-gray-100">
                                    <div
                                        class="flex items-center justify-between text-xs font-bold uppercase tracking-widest text-brand-maroon/40 border-b border-gray-100 pb-3">
                                        <span>Publication Info</span>
                                        <Icon icon="carbon:information" />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-brand-maroon/60 uppercase">{{
                                            translations.writer }}</span>
                                        <span class="text-xs font-bold text-gray-700">{{ selectedPost.user.name
                                            }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-black text-brand-maroon/60 uppercase">{{
                                            translations.date }}</span>
                                        <span class="text-xs font-bold text-gray-700">{{
                                            formatDate(selectedPost.created_at) }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Column -->
                            <div class="space-y-8">
                                <div class="space-y-2">
                                    <h4 class="text-xs font-black text-brand-gold-dark uppercase tracking-[0.2em]">Title
                                    </h4>
                                    <p class="text-2xl font-extrabold text-brand-maroon leading-tight">
                                        {{ isEn ? selectedPost.title : selectedPost.title_ar }}
                                    </p>
                                </div>

                                <div class="space-y-4">
                                    <h4
                                        class="text-xs font-black text-brand-gold-dark uppercase tracking-[0.2em] border-b border-gray-100 pb-2">
                                        {{ translations.content }}</h4>
                                    <div class="prose prose-sm prose-brand-maroon max-w-none text-gray-600 font-medium leading-relaxed max-h-[300px] overflow-y-auto pr-4 custom-scrollbar"
                                        v-html="isEn ? selectedPost.content : selectedPost.content_ar">
                                    </div>
                                </div>

                                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-[10px] font-black text-brand-maroon/40 uppercase tracking-widest">Slug
                                            Reference</span>
                                        <span class="text-[10px] font-bold text-gray-400 italic">/articles/{{
                                            selectedPost.slug }}</span>
                                    </div>
                                    <Link :href="route('posts.edit', selectedPost.id)"
                                        class="px-6 py-3 rounded-xl bg-brand-maroon text-white text-[10px] font-black uppercase tracking-widest hover:bg-brand-maroon/90 shadow-lg shadow-brand-maroon/10 transition-all active:scale-95">
                                        Full Edit
                                    </Link>
                                </div>
                            </div>
                        </div>
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

.animate-modal-in {
    animation: modal-in 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
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

@keyframes modal-in {
    from {
        opacity: 0;
        transform: scale(0.9) translateY(20px);
    }

    to {
        opacity: 1;
        transform: scale(1) translateY(0);
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
</style>
