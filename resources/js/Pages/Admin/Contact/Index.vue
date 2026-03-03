<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    contacts: Array,
    translations: Object,
});

const isModalOpen = ref(false);
const selectedContact = ref(null);

const openPreview = (contact) => {
    selectedContact.value = contact;
    isModalOpen.value = true;
};

const closePreview = () => {
    isModalOpen.value = false;
    selectedContact.value = null;
};

const deleteContact = (id) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure?')) {
        router.delete(route('contacts.destroy', id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>

    <Head :title="translations.all_contacts" />

    <AuthenticatedLayout :title="translations.all_contacts">
        <template #content>
            <div class="max-w-7xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header Section -->
                <div
                    class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100/50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div
                                class="h-10 w-10 rounded-2xl bg-brand-maroon/5 flex items-center justify-center text-brand-maroon">
                                <Icon icon="carbon:email" class="text-2xl" />
                            </div>
                            <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                                {{ translations.all_contacts }}
                            </h1>
                        </div>
                        <p class="text-sm font-medium text-gray-500 max-w-lg">
                            {{ isEn ?
                                'Manage and respond to messages received from your website visitors.' :
                                'إدارة والرد على الرسائل المستلمة من زوار موقعك الإلكتروني.' }}
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
                                        {{ translations.email }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100">
                                        {{ translations.phone }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100">
                                        {{ translations.date }}
                                    </th>
                                    <th
                                        class="px-8 py-6 text-[10px] font-black uppercase text-brand-maroon/40 tracking-[0.2em] border-b border-gray-100 w-40 text-right">
                                        {{ translations.actions }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="(contact, index) in contacts" :key="contact.id"
                                    class="group hover:bg-gray-50/50 transition-colors">
                                    <td
                                        class="px-8 py-6 whitespace-nowrap font-black text-xs text-brand-maroon/30 tracking-widest italic text-center">
                                        #{{ index + 1 }}
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-sm font-bold text-brand-maroon">
                                            {{ contact.name }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-xs font-medium text-gray-500">
                                            {{ contact.email }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-xs font-bold text-brand-gold tracking-wider">
                                            {{ contact.phone }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div
                                            class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-gray-400">
                                            <Icon icon="carbon:calendar" class="text-sm" />
                                            {{ new Date(contact.created_at).toLocaleDateString() }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right text-right">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <button @click="openPreview(contact)"
                                                class="p-2.5 rounded-xl bg-white shadow-sm ring-1 ring-gray-100 text-brand-gold hover:bg-brand-gold hover:text-white transition-all transform hover:-translate-y-0.5 active:scale-90"
                                                v-tooltip="translations.preview">
                                                <Icon icon="carbon:view" class="text-lg" />
                                            </button>
                                            <button @click="deleteContact(contact.id)"
                                                class="p-2.5 rounded-xl bg-white shadow-sm ring-1 ring-gray-100 text-brand-maroon hover:bg-brand-maroon hover:text-white transition-all transform hover:-translate-y-0.5 active:scale-90"
                                                v-tooltip="translations.delete">
                                                <Icon icon="carbon:trash-can" class="text-lg" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-if="contacts.length === 0">
                                    <td colspan="6" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center gap-4">
                                            <div
                                                class="h-20 w-20 rounded-[32px] bg-gray-50 flex items-center justify-center text-gray-200">
                                                <Icon icon="carbon:email" class="text-5xl" />
                                            </div>
                                            <div
                                                class="text-sm font-black text-gray-400 uppercase tracking-widest font-arabic">
                                                {{ isEn ? 'No messages found' : 'لم يتم العثور على رسائل' }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="opacity-0"
                enter-to-class="opacity-100" leave-active-class="transition duration-200 ease-in"
                leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <!-- Backdrop -->
                    <div class="absolute inset-0 bg-brand-maroon/20 backdrop-blur-md" @click="closePreview"></div>

                    <!-- Modal Content -->
                    <div
                        class="relative bg-white w-full max-w-2xl rounded-[40px] shadow-2xl overflow-hidden animate-modal-in ring-1 ring-gray-100">
                        <div class="p-8 md:p-12">
                            <!-- Modal Header -->
                            <div class="flex items-center justify-between mb-10 pb-6 border-b border-gray-50">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-brand-gold/10 flex items-center justify-center text-brand-gold">
                                        <Icon icon="carbon:email" class="text-2xl" />
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-extrabold text-brand-maroon tracking-tight">
                                            {{ translations.contact }}
                                        </h3>
                                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mt-1">
                                            {{ selectedContact?.date }}
                                        </p>
                                    </div>
                                </div>
                                <button @click="closePreview"
                                    class="h-10 w-10 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-brand-maroon hover:text-white transition-all active:scale-95">
                                    <Icon icon="carbon:close" class="text-2xl" />
                                </button>
                            </div>

                            <!-- Modal Body -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-brand-maroon/30 uppercase tracking-widest">{{
                                            translations.name }}</label>
                                    <p class="text-sm font-bold text-brand-maroon">{{ selectedContact?.name }}</p>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-brand-maroon/30 uppercase tracking-widest">{{
                                            translations.email }}</label>
                                    <p class="text-sm font-bold text-gray-600">{{ selectedContact?.email }}</p>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-brand-maroon/30 uppercase tracking-widest">{{
                                            translations.phone }}</label>
                                    <p class="text-sm font-bold text-brand-gold tracking-widest font-mono italic">{{
                                        selectedContact?.phone }}</p>
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-[10px] font-black text-brand-maroon/30 uppercase tracking-widest">{{
                                            translations.date }}</label>
                                    <p class="text-sm font-bold text-gray-600">{{ selectedContact?.date }}</p>
                                </div>
                                <div class="md:col-span-2 space-y-4 pt-4 border-t border-gray-50">
                                    <label
                                        class="text-[10px] font-black text-brand-maroon/30 uppercase tracking-widest block">{{
                                            translations.message }}</label>
                                    <div
                                        class="bg-gray-50/50 p-8 rounded-[32px] text-sm text-gray-600 leading-relaxed italic min-h-[150px]">
                                        {{ selectedContact?.message }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fade-in-down 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
