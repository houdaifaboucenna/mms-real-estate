<script setup>
import EstateCard from '@/Components/EstateCard.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, usePage, useForm, InfiniteScroll } from '@inertiajs/vue3';
import { computed, watch } from 'vue';

const props = defineProps({
    translations: Object,
    estates: Object,
    types: Object,
    cities: Object,
    maxPrice: Number,
    minPrice: Number,
    title: String,
});

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');
const query = computed(() => page.url.includes('?') ? new URLSearchParams(page.url.split('?')[1]) : new URLSearchParams())

const filterForm = useForm({
    city: query.value.get('city') || '',
    town: query.value.get('town') || '',
    type: query.value.get('type') || '',
    from: query.value.get('from') || null,
    to: query.value.get('to') || null,
});
const submitFilters = () => {
    filterForm.get(route('app.estate_filter'), {
        preserveScroll: true,
        preserveState: true,
        reset: ['estates'],
    });
};

// Dynamic Towns based on selected City
const availableTowns = computed(() => {
    if (!filterForm.city) return [];
    const city = props.cities.find(c => c.id == filterForm.city);
    return city ? city.towns : [];
});

// Reset town when city changes
watch(() => filterForm.city, () => {
    filterForm.town = '';
});

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

                    <InfiniteScroll v-else data="estates"
                        class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <EstateCard v-for="estate in estates.data" :key="estate.id" :estate="estate" :is-en="isEn"
                            :types="types" variant="list" />
                    </InfiniteScroll>

                    <!-- End of results -->
                    <p v-if="estates.data.length > 0 && !estates.next_page_url"
                        class="py-8 text-center text-sm font-medium text-gray-400">
                        {{ isEn ? 'No more results' : 'لا مزيد من النتائج' }}
                    </p>
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
