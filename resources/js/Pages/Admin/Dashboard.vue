<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');
const translations = computed(() => page.props.globalTranslations);

const props = defineProps({
    stats: Object,
    estates_by_city: Array,
    estates_by_type: Array,
});

// Calculate percentages for bars
const formatDistribution = (data) => {
    const total = data.reduce((sum, item) => sum + item.count, 0);
    return data.map(item => ({
        ...item,
        percentage: total > 0 ? (item.count / total) * 100 : 0
    })).sort((a, b) => b.count - a.count);
};

const citiesDistribution = computed(() => formatDistribution(props.estates_by_city));
const typesDistribution = computed(() => formatDistribution(props.estates_by_type));

</script>

<template>

    <Head :title="translations.overview" />

    <AuthenticatedLayout :title="translations.overview">
        <template #content>
            <div class="space-y-8 animate-fade-in-down">
                <!-- Header Section -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">{{ translations.overview }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">Welcome back to your real estate command
                            center.</p>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Articles Stat -->
                    <div
                        class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md hover:ring-brand-gold/30">
                        <div class="flex items-center justify-between">
                            <div
                                class="rounded-xl bg-brand-maroon/5 p-3 text-brand-maroon group-hover:bg-brand-maroon group-hover:text-white transition-colors">
                                <span class="iconify text-2xl" data-icon="carbon:document"></span>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest text-emerald-600">{{
                                translations.published }}</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-400 uppercase tracking-wider">{{
                                translations.articles }}</h3>
                            <p class="text-4xl font-extrabold text-brand-maroon">{{ stats.posts_count }}</p>
                        </div>
                    </div>

                    <!-- Comments Stat -->
                    <div
                        class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md hover:ring-brand-gold/30">
                        <div class="flex items-center justify-between">
                            <div
                                class="rounded-xl bg-blue-50 p-3 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <span class="iconify text-2xl" data-icon="carbon:chat"></span>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest text-blue-600">{{
                                translations.received }}</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-400 uppercase tracking-wider">{{
                                translations.comments }}</h3>
                            <p class="text-4xl font-extrabold text-brand-maroon">{{ stats.comments_count }}</p>
                        </div>
                    </div>

                    <!-- Estates Stat -->
                    <div
                        class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md hover:ring-brand-gold/30">
                        <div class="flex items-center justify-between">
                            <div
                                class="rounded-xl bg-brand-gold/10 p-3 text-brand-gold group-hover:bg-brand-gold group-hover:text-brand-maroon transition-colors">
                                <span class="iconify text-2xl" data-icon="carbon:home"></span>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest text-brand-gold">Active</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-400 uppercase tracking-wider">{{ translations.estates
                                }}</h3>
                            <p class="text-4xl font-extrabold text-brand-maroon">{{ stats.estates_count }}</p>
                        </div>
                    </div>

                    <!-- Messages Stat -->
                    <div
                        class="group overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-all hover:shadow-md hover:ring-brand-gold/30">
                        <div class="flex items-center justify-between">
                            <div
                                class="rounded-xl bg-purple-50 p-3 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <span class="iconify text-2xl" data-icon="carbon:email"></span>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-widest text-purple-600">Total</span>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-lg font-bold text-gray-400 uppercase tracking-wider">{{
                                translations.messages }}</h3>
                            <p class="text-4xl font-extrabold text-brand-maroon">{{ stats.contacts_count }}</p>
                        </div>
                    </div>
                </div>

                <!-- Visualization Sections -->
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                    <!-- Estates by Cities -->
                    <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                        <div class="border-b border-gray-50 bg-gray-50/50 px-8 py-6">
                            <h2 class="flex items-center text-xl font-extrabold text-brand-maroon">
                                <span class="iconify mr-3 text-brand-gold" data-icon="carbon:map"></span>
                                {{ translations.estatescities }}
                            </h2>
                        </div>
                        <div class="p-8 space-y-6">
                            <div v-for="city in citiesDistribution" :key="city.name" class="space-y-2">
                                <div class="flex items-end justify-between">
                                    <span class="text-sm font-bold text-gray-700">{{ isEn ? city.name : city.name_ar
                                        }}</span>
                                    <span
                                        class="text-xs font-extrabold text-brand-maroon bg-brand-gold/10 px-2 py-0.5 rounded-full">{{
                                            city.count }} {{ translations.estates }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full bg-brand-maroon transition-all duration-1000 ease-out"
                                        :style="{ width: city.percentage + '%' }"></div>
                                </div>
                            </div>
                            <div v-if="citiesDistribution.length === 0" class="py-10 text-center">
                                <p class="text-sm font-medium text-gray-400 italic">No city data available.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Estates by Types -->
                    <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-100">
                        <div class="border-b border-gray-50 bg-gray-50/50 px-8 py-6">
                            <h2 class="flex items-center text-xl font-extrabold text-brand-maroon">
                                <span class="iconify mr-3 text-brand-gold" data-icon="carbon:category"></span>
                                {{ translations.estatestypes }}
                            </h2>
                        </div>
                        <div class="p-8 space-y-6">
                            <div v-for="type in typesDistribution" :key="type.type" class="space-y-2">
                                <div class="flex items-end justify-between">
                                    <span class="text-sm font-bold text-gray-700">{{ type.label }}</span>
                                    <span
                                        class="text-xs font-extrabold text-brand-maroon bg-brand-gold/10 px-2 py-0.5 rounded-full">{{
                                            type.count }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full bg-brand-gold transition-all duration-1000 ease-out"
                                        :style="{ width: type.percentage + '%' }"></div>
                                </div>
                            </div>
                            <div v-if="typesDistribution.length === 0" class="py-10 text-center">
                                <p class="text-sm font-medium text-gray-400 italic">No type data available.</p>
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