<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    estates: Array,
    types: Object,
    translations: Object,
});

const activeTab = ref('all');
const selectedEstate = ref(null);
const isModalOpen = ref(false);

const filteredEstates = computed(() => {
    if (activeTab.value === 'all') return props.estates;
    return props.estates.filter(estate => estate.type === activeTab.value);
});

const openPreview = (estate) => {
    selectedEstate.value = estate;
    isModalOpen.value = true;
};

const closePreview = () => {
    isModalOpen.value = false;
    selectedEstate.value = null;
};

const deleteEstate = (id) => {
    if (confirm(props.translations.confirm_delete || 'Are you sure?')) {
        router.delete(route('estates.destroy', id), {
            preserveScroll: true,
        });
    }
};

</script>

<template>

    <Head :title="translations.all_estates" />

    <AuthenticatedLayout :title="translations.all_estates">
        <template #content>
            <div class="space-y-8 animate-fade-in-down">
                <!-- Header & Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">{{ translations.all_estates
                        }}</h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">Manage your property portfolio with precision.
                        </p>
                    </div>
                    <Link :href="route('estates.create')"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-brand-maroon text-white font-bold shadow-lg shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-0.5 transition-all group">
                        <Icon icon="carbon:add" class="text-lg mr-2 group-hover:rotate-90 transition-transform" />
                        {{ translations.add_estate }}
                    </Link>
                </div>

                <!-- Tabs Navigation -->
                <div class="flex flex-wrap items-center gap-2 border-b border-gray-100 pb-1">
                    <button @click="activeTab = 'all'" :class="[
                        'px-6 py-3 text-sm font-bold transition-all border-b-2 uppercase tracking-wider',
                        activeTab === 'all'
                            ? 'border-brand-gold text-brand-maroon bg-brand-gold/5'
                            : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-gray-50'
                    ]">
                        {{ isEn ? 'All' : 'الكل' }}
                    </button>
                    <button v-for="(label, key) in types" :key="key" @click="activeTab = key" :class="[
                        'px-6 py-3 text-sm font-bold transition-all border-b-2 uppercase tracking-wider',
                        activeTab === key
                            ? 'border-brand-gold text-brand-maroon bg-brand-gold/5'
                            : 'border-transparent text-gray-400 hover:text-gray-600 hover:bg-gray-50'
                    ]">
                        {{ label }}
                    </button>
                </div>

                <!-- Estates Table -->
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50 border-b border-gray-100">
                                <tr>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest">
                                        {{ translations.id }}</th>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest">
                                        {{ translations.title }}</th>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest">
                                        {{ translations.type }}</th>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest">
                                        {{ translations.city }}</th>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest">
                                        {{ translations.price }}</th>
                                    <th
                                        class="px-8 py-4 text-xs font-extrabold text-brand-maroon uppercase tracking-widest text-right">
                                        {{ translations.actions }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="estate in filteredEstates" :key="estate.id"
                                    class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span class="text-sm font-black text-gray-600">#{{ estate.id }}</span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex items-center">
                                            <div
                                                class="h-12 w-16 flex-shrink-0 overflow-hidden rounded-lg bg-gray-100 ring-1 ring-gray-200">

                                                <img v-if="estate.image !== null" :src="'/storage/' + estate.image[0]"
                                                    class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                <div v-else class="h-full w-full flex items-center justify-center">No
                                                    image</div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-brand-maroon truncate max-w-[200px]">
                                                    {{ estate.title }}
                                                </div>
                                                <div
                                                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                                                    {{ estate.town?.name || 'Unknown Town' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-brand-gold/10 text-brand-gold-dark ring-1 ring-brand-gold/20">
                                            {{ types[estate.type] || estate.type }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-600">{{ estate.city?.name }}</div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="text-sm font-black text-brand-maroon">
                                            {{ estate.min?.toLocaleString() }} $ <span
                                                class="text-gray-300 font-medium">-</span> {{
                                                    estate.max?.toLocaleString() }} $
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="openPreview(estate)"
                                                class="p-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all"
                                                :title="translations.preview">
                                                <Icon icon="carbon:view" class="text-lg" />
                                            </button>
                                            <Link :href="route('estates.edit', estate.id)"
                                                class="p-2 rounded-lg bg-brand-maroon/10 text-brand-maroon hover:bg-brand-maroon hover:text-white transition-all"
                                                :title="translations.edit">
                                                <Icon icon="carbon:edit" class="text-lg" />
                                            </Link>
                                            <button @click="deleteEstate(estate.id)"
                                                class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all"
                                                :title="translations.delete">
                                                <Icon icon="carbon:trash-can" class="text-lg" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="filteredEstates.length === 0">
                                    <td colspan="6" class="px-8 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <Icon icon="carbon:search-locate" class="text-5xl text-gray-200 mb-4" />
                                            <p class="text-lg font-bold text-gray-400">No estates found in this
                                                category.</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Preview Modal -->
            <Transition name="modal">
                <div v-if="isModalOpen"
                    class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 lg:p-8 overflow-y-auto">
                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-brand-maroon/80 backdrop-blur-sm" @click="closePreview"></div>

                    <!-- Content -->
                    <div
                        class="relative w-full max-w-4xl bg-white rounded-[40px] shadow-2xl overflow-hidden animate-scale-in">
                        <button @click="closePreview"
                            class="absolute top-6 right-6 z-10 p-2 rounded-full bg-white/20 hover:bg-white text-white hover:text-brand-maroon transition-all backdrop-blur-md">
                            <Icon icon="carbon:close" class="text-2xl" />
                        </button>

                        <div class="grid grid-cols-1 md:grid-cols-2 h-full min-h-[500px]">
                            <!-- Left: Images -->
                            <div class="relative bg-gray-100 flex items-center justify-center">
                                <img :src="'/storage/' + (typeof selectedEstate.image === 'string' ? JSON.parse(selectedEstate.image)[0] : selectedEstate.image[0])"
                                    class="h-full w-full object-cover">
                                <div class="absolute bottom-6 left-6 right-6 flex items-center gap-2">
                                    <span
                                        class="px-3 py-1 bg-brand-maroon/90 text-[10px] font-black text-white uppercase tracking-widest rounded-full backdrop-blur-sm">
                                        {{ selectedEstate.type }}
                                    </span>
                                    <span
                                        class="px-3 py-1 bg-brand-gold/90 text-[10px] font-black text-brand-maroon uppercase tracking-widest rounded-full backdrop-blur-sm">
                                        {{ selectedEstate.city?.name }}
                                    </span>
                                </div>
                            </div>
                            <!-- Right: Info -->
                            <div class="p-10 space-y-6 flex flex-col justify-center">
                                <div>
                                    <h2 class="text-3xl font-black text-brand-maroon leading-tight">{{
                                        selectedEstate.title }}</h2>
                                    <p class="text-brand-gold font-bold text-lg mt-1">Starting from {{
                                        selectedEstate.min?.toLocaleString() }} $</p>
                                </div>
                                <div class="space-y-4 text-gray-600">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 rounded-lg bg-gray-50 text-gray-400">
                                            <Icon icon="carbon:map" class="text-lg" />
                                        </div>
                                        <span class="text-sm font-medium">{{ selectedEstate.town?.name }}, {{
                                            selectedEstate.city?.name }}</span>
                                    </div>
                                    <div class="prose prose-sm max-w-none text-gray-500 italic line-clamp-6"
                                        v-html="selectedEstate.content"></div>
                                </div>
                                <div class="pt-6 flex gap-3">
                                    <Link :href="route('estates.edit', selectedEstate.id)"
                                        class="flex-1 px-6 py-3 rounded-xl bg-brand-maroon text-white font-bold text-center hover:bg-brand-maroon/90 transition-all">
                                        {{ translations.edit }}
                                    </Link>
                                    <button @click="closePreview"
                                        class="px-6 py-3 rounded-xl bg-gray-100 text-gray-600 font-bold hover:bg-gray-200 transition-all">
                                        Close
                                    </button>
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
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}
</style>