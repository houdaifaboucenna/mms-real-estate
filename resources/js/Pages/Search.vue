<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import PostCard from '@/Components/PostCard.vue';

const props = defineProps({
    translations: Object,
    estates: Object,
    posts: Object,
    faqs: Object,
});

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const activeFaqIndex = ref(null);

const parseImages = (imageStr) => {
    try {
        return JSON.parse(imageStr);
    } catch (e) {
        return [];
    }
};
</script>

<template>

    <Head :title="translations.search_res" />

    <AppLayout>
        <div class="space-y-16 pb-20">
            <!-- Premium Banner -->
            <div class="relative h-[300px] w-full overflow-hidden">
                <img src="/images/background/background-1.jpg" :alt="translations.search_res"
                    class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-r from-brand-maroon/90 via-brand-maroon/60 to-transparent">
                </div>

                <div class="absolute inset-0 flex items-center px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl w-full">
                        <nav class="mb-4 flex text-sm font-medium text-brand-gold-dark" aria-label="Breadcrumb">
                            <Link :href="route('app.home')" class="hover:text-white transition-colors">
                                {{ translations.home }}
                            </Link>
                            <span class="mx-2 text-white/40">/</span>
                            <span class="text-white">{{ translations.search_res }}</span>
                        </nav>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                            {{ translations.search_res }}
                        </h1>
                    </div>
                </div>
            </div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-16">

                <!-- Estates Results -->
                <section v-if="estates && estates.length > 0" class="space-y-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h2 class="text-2xl font-bold text-brand-maroon flex items-center gap-3">
                            <span class="iconify text-brand-gold-dark" data-icon="carbon:home"></span>
                            {{ translations.estates }}
                            <span
                                class="ml-2 rounded-full bg-brand-maroon/5 px-3 py-1 text-sm font-bold text-brand-maroon">
                                {{ estates.length }}
                            </span>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div v-for="estate in estates" :key="estate.id"
                            class="group relative overflow-hidden rounded-2xl bg-white shadow-lg transition-all hover:-translate-y-2 hover:shadow-2xl ring-1 ring-black/5">
                            <Link :href="route('app.estate', estate.slug)" class="block">
                                <div class="relative aspect-[16/10] overflow-hidden">
                                    <img v-if="parseImages(estate.image)[0]"
                                        :src="'/storage/' + parseImages(estate.image)[0]" :alt="estate.title"
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

                                <div class="p-6">
                                    <h4
                                        class="mb-3 text-lg font-bold text-brand-maroon transition-colors group-hover:text-brand-red line-clamp-1">
                                        {{ isEn ? estate.title : estate.title_ar }}
                                    </h4>

                                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                                        <span class="iconify text-brand-gold-dark flex-shrink-0"
                                            data-icon="carbon:location-filled"></span>
                                        <span class="truncate">{{ isEn ? estate.city.name : estate.city.name_ar }}, {{
                                            isEn ? estate.town.name : estate.town.name_ar }}</span>
                                    </div>

                                    <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                        <span class="text-base font-extrabold text-brand-maroon">
                                            {{ estate.min }}$ - {{ estate.max }}$
                                        </span>
                                        <span class="text-brand-gold-dark font-bold text-sm">
                                            {{ translations.view_details }}</span>
                                    </div>
                                </div>
                            </Link>
                        </div>
                    </div>
                </section>

                <!-- Articles Results -->
                <section v-if="posts && posts.length > 0" class="space-y-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h2 class="text-2xl font-bold text-brand-maroon flex items-center gap-3">
                            <span class="iconify text-brand-gold" data-icon="carbon:document"></span>
                            {{ translations.articles }}
                            <span
                                class="ml-2 rounded-full bg-brand-maroon/5 px-3 py-1 text-sm font-bold text-brand-maroon">
                                {{ posts.length }}
                            </span>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <PostCard v-for="post in posts" :key="post.id" :post="post" />
                    </div>
                </section>

                <!-- FAQ Results -->
                <section v-if="faqs && faqs.length > 0" class="space-y-8">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h2 class="text-2xl font-bold text-brand-maroon flex items-center gap-3">
                            <span class="iconify text-brand-gold-dark" data-icon="carbon:help"></span>
                            {{ translations.faq }}
                            <span
                                class="ml-2 rounded-full bg-brand-maroon/5 px-3 py-1 text-sm font-bold text-brand-maroon">
                                {{ faqs.length }}
                            </span>
                        </h2>
                    </div>

                    <div class="space-y-4 max-w-4xl">
                        <div v-for="(faq, index) in faqs" :key="faq.id"
                            class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition-all hover:shadow-md">
                            <button @click="activeFaqIndex = activeFaqIndex === index ? null : index"
                                class="flex w-full items-center justify-between p-6 text-left transition-colors hover:bg-gray-50">
                                <span class="text-lg font-bold text-brand-maroon">
                                    {{ isEn ? faq.question : faq.question_ar }}
                                </span>
                                <span
                                    class="ml-4 flex h-8 w-8 items-center justify-center rounded-full bg-brand-maroon/5 text-brand-maroon transition-transform duration-300"
                                    :class="{ 'rotate-180 bg-brand-gold text-white': activeFaqIndex === index }">
                                    <span class="iconify" data-icon="carbon:chevron-down"></span>
                                </span>
                            </button>

                            <Transition enter-active-class="transition duration-300 ease-out"
                                enter-from-class="opacity-0 -translate-y-4 scale-95"
                                enter-to-class="opacity-100 translate-y-0 scale-100"
                                leave-active-class="transition duration-200 ease-in"
                                leave-from-class="opacity-100 translate-y-0 scale-100"
                                leave-to-class="opacity-0 -translate-y-4 scale-95">
                                <div v-if="activeFaqIndex === index" class="border-t border-gray-50 bg-gray-50/50 p-6">
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ isEn ? faq.answer : faq.answer_ar }}
                                    </p>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </section>

                <!-- No Results Found -->
                <div v-if="(!estates || estates.length === 0) && (!posts || posts.length === 0) && (!faqs || faqs.length === 0)"
                    class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                        <span class="iconify" data-icon="carbon:search" data-width="48"></span>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900">{{ translations.nofound }}</h3>
                    <p class="mt-4 text-lg text-gray-500 max-w-lg mx-auto">
                        {{ translations.nofound_desc }}
                    </p>
                    <Link :href="route('app.home')"
                        class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-maroon px-8 py-3 font-bold text-white transition hover:bg-brand-maroon-dark shadow-lg shadow-maroon-900/20 active:scale-95">
                        {{ translations.back_to_home }}
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* Mobile adjustments */
@media (max-width: 640px) {
    .grid {
        gap: 1.5rem;
    }
}
</style>
