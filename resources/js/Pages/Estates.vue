<script setup>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, usePage, useForm } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');
const query = computed(() => page.url.includes('?') ? new URLSearchParams(page.url.split('?')[1]) : new URLSearchParams())

const props = defineProps({
    translations: Object,
    estates: Object,
    types: Object,
    cities: Object,
    maxPrice: Number,
    minPrice: Number,
    title: String,
});

const filterForm = useForm({
    city: query.value.get('city') || '',
    town: query.value.get('town') || '',
    type: query.value.get('type') || '',
    from: query.value.get('from') || null,
    to: query.value.get('to') || null,
});

// Dynamic Towns based on selected City
const availableTowns = computed(() => {
    if (!filterForm.city) return [];
    const city = props.cities.find(c => c.id == filterForm.city);
    return city ? city.towns : [];
});

// watch(() => page.url, () => {
//     filterForm.city = query.value.get('city') || '';
//     filterForm.town = query.value.get('town') || '';
//     filterForm.type = query.value.get('type') || '';
//     filterForm.from = query.value.get('from') || null;
//     filterForm.to = query.value.get('to') || null;
// }, { immediate: true });

// Reset town when city changes
watch(() => filterForm.city, () => {
    filterForm.town = '';
});

const submitFilters = () => {
    filterForm.get(route('app.estate_filter'), {
        preserveScroll: true,
        preserveState: true,
    });
};

</script>

<template>

    <Head :title="translations.estates" />

    <AppLayout>
        <div class="space-y-12 pb-20">
            <!-- Premium Banner -->
            <div class="relative h-[400px] w-full overflow-hidden">
                <img src="/images/background/background-5.jpg" :alt="translations.estates"
                    class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-maroon/90 via-brand-maroon/60 to-transparent">
                </div>

                <div class="absolute inset-0 flex items-center px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl w-full">
                        <nav class="mb-6 flex text-sm font-medium text-brand-gold/90" aria-label="Breadcrumb">
                            <Link :href="route('app.home')" class="hover:text-white transition-colors">
                                {{ translations.home }}
                            </Link>
                            <span class="mx-2 text-white/40">/</span>
                            <span class="text-white">{{ translations.estates }}</span>
                        </nav>
                        <h1 class="text-5xl md:text-6xl font-extrabold text-white tracking-tight leading-tight">
                            {{ title || translations.all_estates }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Advanced Search Filters -->
                <div
                    class="relative -mt-16 z-20 overflow-hidden rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-black/5">
                    <form @submit.prevent="submitFilters"
                        class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-6 items-end">

                        <!-- City Select -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-brand-maroon uppercase tracking-wider">{{
                                translations.city }}</label>
                            <select v-model="filterForm.city"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-brand-gold focus:ring-brand-gold transition-all">
                                <option value="">{{ translations.ch_city }}</option>
                                <option v-for="city in cities" :key="city.id" :value="city.id">
                                    {{ isEn ? city.name : city.name_ar }}
                                </option>
                            </select>
                        </div>

                        <!-- Town Select -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-brand-maroon uppercase tracking-wider">{{
                                translations.town }}</label>
                            <select v-model="filterForm.town" :disabled="!filterForm.city"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-brand-gold focus:ring-brand-gold transition-all disabled:opacity-50">
                                <option value="">{{ translations.ch_town }}</option>
                                <option v-for="town in availableTowns" :key="town.id" :value="town.id">
                                    {{ isEn ? town.name : town.name_ar }}
                                </option>
                            </select>
                        </div>

                        <!-- Type Select -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-brand-maroon uppercase tracking-wider">{{
                                translations.type }}</label>
                            <select v-model="filterForm.type"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-brand-gold focus:ring-brand-gold transition-all">
                                <option value="">{{ translations.ch_type }}</option>
                                <option v-for="(type, i) in types" :key="i" :value="i">
                                    {{ type }}
                                </option>
                            </select>
                        </div>

                        <!-- Min Price -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-brand-maroon uppercase tracking-wider">
                                {{ translations.min_price }} ($)
                            </label>
                            <input type="number" v-model="filterForm.from" :min="minPrice" :max="maxPrice"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-brand-gold focus:ring-brand-gold">
                        </div>

                        <!-- Max Price -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-brand-maroon uppercase tracking-wider">
                                {{ translations.max_price }} ($)
                            </label>
                            <input type="number" v-model="filterForm.to" :min="minPrice" :max="maxPrice"
                                class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm focus:border-brand-gold focus:ring-brand-gold">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" :disabled="filterForm.processing"
                            class="flex h-10 items-center justify-center gap-2 rounded-lg bg-brand-maroon px-6 font-bold text-white transition hover:bg-brand-maroon-dark shadow-lg shadow-maroon-900/20 active:scale-95 disabled:opacity-70">
                            <span class="iconify" data-icon="carbon:search"></span>
                            {{ translations.search }}
                        </button>
                    </form>
                </div>

                <!-- Estates Grid -->
                <div class="mt-16 space-y-12">
                    <div v-if="estates.data.length === 0"
                        class="flex flex-col items-center justify-center py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <div
                            class="mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                            <span class="iconify" data-icon="carbon:home" data-width="48"></span>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">{{ translations.nofound }}</h3>
                        <p class="mt-2 text-gray-500">{{ translations.adjust_filters }}</p>
                        <Link :href="route('app.estates')"
                            class="mt-6 font-bold text-brand-maroon hover:text-brand-gold transition-colors underline decoration-2 underline-offset-4">
                            {{ translations.reset_filters }}
                        </Link>
                    </div>

                    <div v-else class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div v-for="estate in estates.data" :key="estate.id"
                            class="group relative overflow-hidden rounded-2xl bg-white shadow-xl transition-all hover:-translate-y-2 hover:shadow-2xl ring-1 ring-black/5">
                            <Link :href="route('app.estate', estate.slug)" class="block">
                                <!-- Image with Type Badge -->
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img v-if="estate.image && estate.image[0]" :src="'/storage/' + estate.image[0]"
                                        :alt="estate.title"
                                        class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <img v-else src="/images/background/background-5.jpg" :alt="estate.title"
                                        class="h-full w-full object-cover">

                                    <div class="absolute right-4 top-4">
                                        <span
                                            class="rounded-lg bg-white/90 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-maroon shadow-lg backdrop-blur-sm">
                                            {{ estate.type }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="p-6">
                                    <h4
                                        class="mb-3 text-xl font-bold text-brand-maroon transition-colors group-hover:text-brand-red line-clamp-1">
                                        {{ isEn ? estate.title : estate.title_ar }}
                                    </h4>

                                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                        <span class="iconify text-brand-gold flex-shrink-0"
                                            data-icon="carbon:location-filled"></span>
                                        <span class="truncate">{{ estate.city.name }}, {{ estate.town.name }}</span>
                                    </div>

                                    <p class="mb-6 text-sm text-gray-600 line-clamp-2 leading-relaxed">
                                        {{ isEn ? estate.short : estate.short_ar }}
                                    </p>

                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold uppercase tracking-wider text-gray-400">{{
                                                translations.price }}</span>
                                            <span class="text-lg font-extrabold text-brand-maroon">
                                                {{ estate.min }}$ <span class="text-gray-400 font-normal">-</span> {{
                                                    estate.max }}$
                                            </span>
                                        </div>
                                        <span
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-maroon text-white transition group-hover:bg-brand-gold">
                                            <span class="iconify" data-icon="carbon:arrow-right"></span>
                                        </span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>

                    <!-- Modern Pagination -->
                    <div class="mt-16 flex justify-center">
                        <Pagination :links="estates.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped>
/* Optional: smooth field focus */
select,
input {
    outline: none;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
</style>
