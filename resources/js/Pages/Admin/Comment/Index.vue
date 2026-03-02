<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    comments: Array,
    translations: Object,
});

const deleteComment = (id) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure?')) {
        router.delete(route('comments.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>

    <Head :title="translations.all_comments" />

    <AuthenticatedLayout :title="translations.all_comments">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header Section -->
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100/50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                <Icon icon="carbon:chat" class="text-2xl" />
                            </div>
                            <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                                {{ translations.all_comments }}
                            </h1>
                        </div>
                        <p class="text-sm font-medium text-gray-500 max-w-lg">
                            {{ isEn ?
                                'Review and manage comments left by your visitors on articles.' :
                                'مراجعة وإدارة التعليقات التي يتركها الزوار على المقالات.' }}
                        </p>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="bg-white rounded-[40px] shadow-sm ring-1 ring-gray-100 overflow-hidden group/table">
                    <div class="overflow-x-auto custom-scrollbar">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100 w-20 text-center">
                                        {{ translations.number }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100">
                                        {{ translations.name }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100">
                                        {{ translations.comment }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100">
                                        {{ translations.article }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100 w-32 border-l border-gray-100/50">
                                        {{ translations.actions }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="(comment, index) in comments" :key="comment.id"
                                    class="group hover:bg-gray-50/50 transition-colors">
                                    <td
                                        class="px-8 py-6 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic text-center">
                                        #{{ index + 1 }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="relative group/avatar">
                                                <img :src="comment.gravatar" :alt="comment.name"
                                                    class="h-12 w-12 rounded-2xl object-cover ring-2 ring-white shadow-sm transition-transform group-hover/avatar:scale-110">
                                                <div
                                                    class="absolute -bottom-1 -right-1 h-4 w-4 bg-emerald-500 border-2 border-white rounded-full">
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-bold text-brand-maroon group-hover:text-brand-gold transition-colors">
                                                    {{ comment.name }}
                                                </span>
                                                <span class="text-[10px] font-medium text-gray-400">
                                                    {{ comment.email }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 max-w-xs">
                                        <p class="text-xs font-medium text-gray-600 leading-relaxed line-clamp-2">
                                            {{ comment.content }}
                                        </p>
                                        <div
                                            class="mt-2 flex items-center gap-1.5 text-[9px] font-black uppercase tracking-widest text-gray-400">
                                            <Icon icon="carbon:calendar" class="text-xs" />
                                            {{ comment.date }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <Link v-if="comment.post" :href="route('app.post', comment.post.slug)"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-50 text-[11px] font-bold text-gray-500 hover:bg-brand-gold/10 hover:text-brand-gold transition-all group/link">
                                            <Icon icon="carbon:article"
                                                class="text-sm transition-transform group-hover/link:rotate-12" />
                                            <span class="line-clamp-1">{{ comment.post.title }}</span>
                                        </Link>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap border-l border-gray-100/50">
                                        <div class="flex items-center justify-center">
                                            <button @click="deleteComment(comment.id)"
                                                class="flex items-center justify-center h-10 w-10 rounded-2xl bg-gray-50 text-gray-400 hover:bg-brand-maroon hover:text-white transition-all transform hover:-translate-y-1 active:scale-90 group/btn shadow-sm hover:shadow-brand-maroon/20">
                                                <Icon icon="carbon:trash-can"
                                                    class="text-lg group-hover/btn:scale-110" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="comments.length === 0">
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="h-20 w-20 rounded-[32px] bg-gray-50 flex items-center justify-center text-gray-200">
                                                <Icon icon="carbon:chat-off" class="text-5xl" />
                                            </div>
                                            <div
                                                class="text-sm font-black text-gray-400 uppercase tracking-widest font-arabic">
                                                {{ isEn ? 'No comments found' : 'لم يتم العثور على تعليقات' }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
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

.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
    width: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(69, 7, 6, 0.05);
    border-radius: 20px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(69, 7, 6, 0.1);
}
</style>
