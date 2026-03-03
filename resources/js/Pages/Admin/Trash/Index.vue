<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    posts: Object,
    estates: Object,
    translations: Object,
});

const activeTab = ref('posts');

const restoreItem = (id, type) => {
    router.post(route('trash.restore', { id, type }), {}, {
        preserveScroll: true,
    });
};

const forceDeleteItem = (id, type) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure you want to delete this item permanently?')) {
        router.delete(route('trash.forceDelete', { id, type }), {
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

    <Head :title="translations.trash" />

    <AuthenticatedLayout :title="translations.trash">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ translations.trash }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ isEn ?
                                'Manage deleted items and restore them if needed.'
                                : 'إدارة العناصر المحذوفة واستعادتها إذا لزم الأمر.' }}
                        </p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-4 border-b border-gray-100">
                    <button @click="activeTab = 'posts'" :class="[
                        'pb-4 text-sm font-bold transition-all px-4 relative',
                        activeTab === 'posts' ? 'text-brand-maroon' : 'text-gray-400 hover:text-gray-600'
                    ]">
                        {{ translations.articles }}
                        <div v-if="activeTab === 'posts'"
                            class="absolute bottom-0 left-0 right-0 h-1 bg-brand-maroon rounded-t-full"></div>
                    </button>
                    <button @click="activeTab = 'estates'" :class="[
                        'pb-4 text-sm font-bold transition-all px-4 relative',
                        activeTab === 'estates' ? 'text-brand-maroon' : 'text-gray-400 hover:text-gray-600'
                    ]">
                        {{ translations.estates }}
                        <div v-if="activeTab === 'estates'"
                            class="absolute bottom-0 left-0 right-0 h-1 bg-brand-maroon rounded-t-full"></div>
                    </button>
                </div>

                <!-- Table Section: Posts -->
                <div v-if="activeTab === 'posts'" class="space-y-6">
                    <div
                        class="bg-white rounded-[40px] shadow-2xl shadow-gray-200/50 overflow-hidden ring-1 ring-gray-100">
                        <div class="overflow-x-auto min-h-[400px]">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50/50">
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
                                    <tr v-for="post in posts.data" :key="post.id"
                                        class="group hover:bg-gray-50/50 transition-colors">
                                        <td
                                            class="px-8 py-5 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic group-hover:text-brand-gold transition-colors">
                                            #{{ post.id }}
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="h-12 w-12 rounded-xl overflow-hidden ring-1 ring-gray-100 shrink-0">
                                                    <img :src="'/storage/' + post.image"
                                                        class="h-full w-full object-cover">
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-brand-maroon line-clamp-1">
                                                        {{ isEn ? post.title : post.title_ar }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="text-xs font-bold text-gray-600">{{ post.user.name }}</span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="text-xs font-bold text-gray-600">{{
                                                formatDate(post.deleted_at) }}</span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="restoreItem(post.id, 'post')"
                                                    class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-green-50 hover:text-green-600 transition-all font-bold uppercase text-[10px] tracking-widest flex items-center gap-2">
                                                    <Icon icon="carbon:undo" class="text-lg" />
                                                    {{ translations.restore }}
                                                </button>
                                                <button @click="forceDeleteItem(post.id, 'post')"
                                                    class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all font-bold uppercase text-[10px] tracking-widest flex items-center gap-2">
                                                    <Icon icon="carbon:trash-can" class="text-lg" />
                                                    {{ translations.force_delete }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="posts.data.length === 0">
                                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">
                                            {{ isEn ? 'No deleted articles found.' : 'لا يوجد مقالات محذوفة.' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="posts.links" />
                </div>

                <!-- Table Section: Estates -->
                <div v-if="activeTab === 'estates'" class="space-y-6">
                    <div
                        class="bg-white rounded-[40px] shadow-2xl shadow-gray-200/50 overflow-hidden ring-1 ring-gray-100">
                        <div class="overflow-x-auto min-h-[400px]">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50/50">
                                    <tr>
                                        <th
                                            class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                            {{ translations.number }}</th>
                                        <th
                                            class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                            {{ translations.title }}</th>
                                        <th
                                            class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                            {{ translations.city }}</th>
                                        <th
                                            class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100">
                                            {{ translations.date }}</th>
                                        <th
                                            class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-brand-maroon/40 border-b border-gray-100 text-center">
                                            {{ translations.actions }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr v-for="estate in estates.data" :key="estate.id"
                                        class="group hover:bg-gray-50/50 transition-colors">
                                        <td
                                            class="px-8 py-5 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic group-hover:text-brand-gold transition-colors">
                                            #{{ estate.id }}
                                        </td>
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="h-12 w-12 rounded-xl overflow-hidden ring-1 ring-gray-100 shrink-0">
                                                    <img :src="'/storage/' + (estate.image ? estate.image[0] : '')"
                                                        class="h-full w-full object-cover">
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold text-brand-maroon line-clamp-1">
                                                        {{ isEn ? estate.title : estate.title_ar }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="text-xs font-bold text-gray-600">{{ isEn ? estate.city.name :
                                                estate.city.name_ar }}</span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="text-xs font-bold text-gray-600">{{
                                                formatDate(estate.deleted_at) }}</span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button @click="restoreItem(estate.id, 'estate')"
                                                    class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-green-50 hover:text-green-600 transition-all font-bold uppercase text-[10px] tracking-widest flex items-center gap-2">
                                                    <Icon icon="carbon:undo" class="text-lg" />
                                                    {{ translations.restore }}
                                                </button>
                                                <button @click="forceDeleteItem(estate.id, 'estate')"
                                                    class="p-2.5 rounded-xl bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all font-bold uppercase text-[10px] tracking-widest flex items-center gap-2">
                                                    <Icon icon="carbon:trash-can" class="text-lg" />
                                                    {{ translations.force_delete }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="estates.data.length === 0">
                                        <td colspan="5" class="px-8 py-20 text-center text-gray-400 italic">
                                            {{ isEn ? 'No deleted estates found.' : 'لا يوجد عقارات محذوفة.' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Pagination :links="estates.links" />
                </div>
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
</style>
