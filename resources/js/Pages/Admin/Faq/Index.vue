<script setup>
import Pagination from '@/Components/Pagination.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    faqs: Array,
    translations: Object,
});

const deleteFaq = (id) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure?')) {
        router.delete(route('faq.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>

    <Head :title="translations.faq" />

    <AuthenticatedLayout :title="translations.faq">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header Section -->
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100/50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                <Icon icon="carbon:help-desk" class="text-2xl" />
                            </div>
                            <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                                {{ translations.faq }}
                            </h1>
                        </div>
                        <p class="text-sm font-medium text-gray-500 max-w-lg">
                            {{ isEn ? 'Manage frequently asked questions to help your users find answers quickly.'
                                : 'قم بإدارة الأسئلة الشائعة لمساعدة مستخدميك في العثور على الإجابات بسرعة.' }}
                        </p>
                    </div>

                    <Link :href="route('faq.create')"
                        class="flex items-center justify-center gap-3 px-8 py-4 rounded-2xl bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-xs group">
                        <Icon icon="carbon:add-alt" class="text-xl group-hover:rotate-12 transition-transform" />
                        {{ translations.add_question }}
                    </Link>
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
                                        {{ translations.question }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100 w-32">
                                        {{ translations.show_home }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100 w-40 text-right">
                                        {{ translations.actions }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="(faq, index) in faqs.data" :key="faq.id"
                                    class="group hover:bg-gray-50/50 transition-colors">
                                    <td
                                        class="px-8 py-5 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic text-center">
                                        #{{ index + 1 }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="space-y-1.5 max-w-2xl">
                                            <div
                                                class="text-sm font-bold text-brand-maroon group-hover:text-brand-gold transition-colors line-clamp-1">
                                                {{ faq.question }}
                                            </div>
                                            <div class="text-[11px] font-medium text-gray-400 line-clamp-1 italic"
                                                dir="rtl">
                                                {{ faq.question_ar }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div :class="[
                                                'h-2 w-2 rounded-full animate-pulse',
                                                faq.show_home ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-gray-300'
                                            ]"></div>
                                            <span :class="[
                                                'text-[10px] font-black uppercase tracking-widest',
                                                faq.show_home ? 'text-emerald-600' : 'text-gray-400'
                                            ]">
                                                {{ faq.show_home ? translations.enabled : translations.disabled }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <Link :href="route('faq.edit', faq.id)"
                                                class="p-2.5 rounded-xl bg-white shadow-sm ring-1 ring-gray-100 text-brand-gold hover:bg-brand-gold hover:text-white transition-all transform hover:-translate-y-0.5 active:scale-90"
                                                v-tooltip="translations.edit">
                                                <Icon icon="carbon:edit" class="text-lg" />
                                            </Link>
                                            <button @click="deleteFaq(faq.id)"
                                                class="p-2.5 rounded-xl bg-white shadow-sm ring-1 ring-gray-100 text-brand-maroon hover:bg-brand-maroon hover:text-white transition-all transform hover:-translate-y-0.5 active:scale-90"
                                                v-tooltip="translations.delete">
                                                <Icon icon="carbon:trash-can" class="text-lg" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="faqs.data.length === 0">
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="h-20 w-20 rounded-[32px] bg-gray-50 flex items-center justify-center text-gray-200">
                                                <Icon icon="carbon:help-desk" class="text-5xl" />
                                            </div>
                                            <div class="text-sm font-black text-gray-400 uppercase tracking-widest">
                                                {{ isEn ? 'No questions found' : 'لم يتم العثور على أسئلة' }}
                                            </div>
                                            <Link :href="route('faq.create')"
                                                class="text-brand-gold text-xs font-bold hover:underline">
                                                {{ translations.add_question }}
                                            </Link>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <Pagination :links="faqs.links" />
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
    border-radius: 40px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(69, 7, 6, 0.1);
}
</style>
