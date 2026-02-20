<script setup>
import ContactForm from '@/Components/Form/ContactForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    translations: Object,
    estate: Object,
    others: Object,
});

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

// Carousel State
const activeImageIndex = ref(0);

// Use real estate images if available, otherwise examples
const images = computed(() => {
    if (Array.isArray(props.estate.image) && props.estate.image.length > 0) {
        return props.estate.image.map(img => img.startsWith('http') ? img : '/storage/' + img);
    }
    return [
        'https://placehold.co/1200x800/450706/white?text=Property+Image+1',
        'https://placehold.co/1200x800/d1b57a/450706?text=Property+Image+2',
        'https://placehold.co/1200x800/450706/white?text=Property+Image+3',
    ];
});

const nextImage = () => {
    activeImageIndex.value = (activeImageIndex.value + 1) % images.value.length;
};

const prevImage = () => {
    activeImageIndex.value = (activeImageIndex.value - 1 + images.value.length) % images.value.length;
};

const setIndex = (index) => {
    activeImageIndex.value = index;
};

</script>

<template>

    <Head :title="estate.title" />

    <AppLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">

                <!-- Main Content Area -->
                <div class="lg:col-span-2 space-y-10">

                    <!-- Estate Header & Carousel -->
                    <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                        <!-- Carousel Container -->
                        <div class="relative aspect-[16/10] w-full overflow-hidden bg-gray-900 group">
                            <!-- Main Image -->
                            <Transition enter-active-class="transition duration-500 ease-out"
                                enter-from-class="opacity-0 scale-105" enter-to-class="opacity-100 scale-100"
                                leave-active-class="transition duration-500 ease-in"
                                leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95"
                                mode="out-in">
                                <img :key="activeImageIndex" :src="images[activeImageIndex]"
                                    class="h-full w-full object-cover" :alt="estate.title" />
                            </Transition>

                            <!-- Navigation Controls -->
                            <div
                                class="absolute inset-0 flex items-center justify-between p-4 opacity-0 transition-opacity group-hover:opacity-100">
                                <button @click="prevImage"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur-sm transition hover:bg-black/50">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="nextImage"
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur-sm transition hover:bg-black/50">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Image Counter Overlay -->
                            <div
                                class="absolute bottom-4 right-4 rounded-lg bg-black/40 px-3 py-1.5 text-sm font-bold text-white backdrop-blur-md">
                                {{ activeImageIndex + 1 }} / {{ images.length }}
                            </div>
                        </div>

                        <!-- Thumbnails Area -->
                        <div class="flex gap-2.5 p-4 overflow-x-auto bg-gray-50/50 scrollbar-hide">
                            <button v-for="(img, index) in images" :key="index" @click="setIndex(index)"
                                class="relative h-20 w-32 shrink-0 overflow-hidden rounded-lg transition-all"
                                :class="activeImageIndex === index ? 'ring-2 ring-brand-gold opacity-100' : 'opacity-60 hover:opacity-100'">
                                <img :src="img" class="h-full w-full object-cover" />
                            </button>
                        </div>

                        <!-- Estate Basic Info Overlay -->
                        <div class="p-8 sm:p-10">
                            <h1
                                class="text-3xl font-extrabold text-brand-maroon sm:text-4xl tracking-tight leading-tight mb-4">
                                {{ isEn ? estate.title : estate.title_ar }}
                            </h1>
                            <p class="text-lg text-gray-600 leading-relaxed font-medium">
                                {{ isEn ? estate.short : estate.short_ar }}
                            </p>

                            <!-- Detailed Info Boxes -->
                            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                                <div
                                    class="rounded-xl border border-gray-100 bg-gray-50 p-6 text-center transition hover:shadow-md">
                                    <div
                                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-maroon/10 text-brand-maroon">
                                        <span class="iconify" data-icon="healthicons:city-outline"
                                            data-width="28"></span>
                                    </div>
                                    <span class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{
                                        translations.city }}</span>
                                    <span class="block font-bold text-gray-900">{{ estate.city.name }}</span>
                                </div>

                                <div
                                    class="rounded-xl border border-gray-100 bg-gray-50 p-6 text-center transition hover:shadow-md">
                                    <div
                                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-gold/10 text-brand-gold">
                                        <span class="iconify" data-icon="maki:town-hall" data-width="24"></span>
                                    </div>
                                    <span class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{
                                        translations.town }}</span>
                                    <span class="block font-bold text-gray-900">{{ estate.town.name }}</span>
                                </div>

                                <div
                                    class="rounded-xl border border-gray-100 bg-gray-50 p-6 text-center transition hover:shadow-md">
                                    <div
                                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-brand-red/10 text-brand-red">
                                        <span class="iconify" data-icon="mdi:home-city-outline" data-width="28"></span>
                                    </div>
                                    <span class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-1">{{
                                        translations.type }}</span>
                                    <span class="block font-bold text-gray-900">{{ estate.type }}</span>
                                </div>

                                <div
                                    class="rounded-xl border border-gray-100 bg-brand-maroon p-6 text-center text-white shadow-lg ring-1 ring-white/10">
                                    <div
                                        class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-brand-gold">
                                        <span class="iconify" data-icon="dashicons:money-alt" data-width="28"></span>
                                    </div>
                                    <span class="block text-xs font-bold uppercase tracking-wider text-white/60 mb-1">{{
                                        translations.price }}</span>
                                    <div
                                        class="font-extrabold flex flex-col sm:flex-row items-center justify-center gap-1">
                                        <span>{{ estate.min }}$</span>
                                        <span class="hidden sm:inline">-</span>
                                        <span>{{ estate.max }}$</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estate Description -->
                    <div class="overflow-hidden rounded-2xl bg-white p-8 sm:p-10 shadow-xl ring-1 ring-black/5">
                        <h2 class="text-2xl font-bold text-brand-maroon mb-6 flex items-center gap-3">
                            <span class="h-8 w-1.5 rounded-full bg-brand-gold"></span>
                            {{ translations.overview_and_details }}
                        </h2>
                        <div class="prose prose-lg prose-brand-maroon max-w-none text-gray-700 leading-relaxed"
                            v-html="isEn ? estate.content : estate.content_ar">
                        </div>
                    </div>

                    <!-- Similar Projects -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-brand-maroon">{{ translations.similar }}</h3>
                            <div class="h-1 flex-1 mx-6 bg-gray-100 rounded-full"></div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div v-for="other in others" :key="other.id"
                                class="group relative overflow-hidden rounded-2xl bg-white shadow-xl transition-all hover:-translate-y-1 hover:shadow-2xl ring-1 ring-black/5">
                                <Link :href="route('app.estate', other.slug)" class="block">
                                    <div class="aspect-[16/10] overflow-hidden">
                                        <img :src="'/storage/' + other.image[0]" :alt="other.title"
                                            class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                                    </div>
                                    <div class="p-6">
                                        <div
                                            class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-brand-gold mb-3">
                                            <span class="rounded-full bg-brand-gold/10 px-2.5 py-1">{{ other.type
                                            }}</span>
                                        </div>
                                        <h4
                                            class="text-xl font-bold text-brand-maroon transition-colors group-hover:text-brand-red mb-3">
                                            {{ isEn ? other.title : other.title_ar }}
                                        </h4>
                                        <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                            <svg class="h-4 w-4 text-brand-gold" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span class="truncate">{{ other.city.name }}, {{ other.town.name }}</span>
                                        </div>
                                        <div
                                            class="flex items-center justify-between border-t border-gray-50 pt-4 mt-4">
                                            <span class="text-lg font-extrabold text-brand-maroon">
                                                {{ other.min }}$ <span class="text-gray-400 font-normal">-</span> {{
                                                    other.max }}$
                                            </span>
                                            <span
                                                class="text-brand-gold font-bold text-sm group-hover:translate-x-1 transition-transform">
                                                {{ translations.view_details }} →
                                            </span>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Sidebar Area -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-28 space-y-8">
                        <!-- Contact Card -->
                        <div class="overflow-hidden rounded-2xl bg-white p-8 shadow-xl ring-1 ring-black/5">
                            <ContactForm :translations="translations.contact_form" />
                        </div>

                        <!-- Badge / CTA -->
                        <div class="relative overflow-hidden rounded-2xl bg-brand-maroon p-8 text-white shadow-2xl">
                            <div class="relative z-10">
                                <h4 class="text-xl font-bold mb-4">
                                    {{ translations.interested_in_this_property }}
                                </h4>
                                <p class="text-white/80 text-sm leading-relaxed mb-6">
                                    {{ translations.all_details_and_legal_consultation }}
                                </p>
                                <a :href="'https://wa.me/' + page.props.settings.whatsapp.replace(/\s/g, '')"
                                    target="_blank"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-whatsapp px-6 py-3 font-bold text-white transition hover:bg-brand-whatsapp/90 shadow-lg shadow-emerald-900/40">
                                    <span class="iconify" data-icon="bi:whatsapp"></span>
                                    {{ translations.whatsapp_consultation }}
                                </a>
                            </div>
                            <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-white/5"></div>
                            <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-brand-gold/10"></div>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </AppLayout>

</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}

.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
