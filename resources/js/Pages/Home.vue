<script setup>
import EstateCard from '@/Components/EstateCard.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, Head, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    types: Object,
    cities: Array,
    maxPrice: Number,
    minPrice: Number,
    posts: Array,
    postCount: Number,
    faqs: Array,
    faqCount: Number,
    estates: Array,
    estateCount: Number,
});

const openFaq = ref(null);
const toggleFaq = (id) => {
    openFaq.value = openFaq.value === id ? null : id;
};
</script>

<template>

    <Head :title="isEn ? 'Home' : 'الرئيسية'" />

    <AppLayout>
        <div class="space-y-20 pb-20">

            <!-- ─── Hero ─────────────────────────────────────────────── -->
            <section class="relative h-[520px] w-full overflow-hidden -mt-8">
                <img src="/images/background/background-5.jpg" alt="Hero"
                    class="h-full w-full object-cover object-center">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-brand-maroon/95 via-brand-maroon/70 to-brand-maroon/20">
                </div>

                <div class="absolute inset-0 flex items-center px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-7xl w-full">
                        <p class="mb-3 text-sm font-bold uppercase tracking-[0.25em] text-brand-gold">
                            {{ isEn ? 'Premium Real Estate' : 'عقارات مميزة' }}
                        </p>
                        <h1 class="text-5xl md:text-6xl font-extrabold text-white leading-tight tracking-tight max-w-2xl">
                            {{ isEn ? 'Find Your Dream Property' : 'ابحث عن عقارك المثالي' }}
                        </h1>
                        <p class="mt-4 text-lg text-white/75 max-w-xl leading-relaxed">
                            {{ isEn
                                ? 'Browse through our wide selection of premium properties across the best locations.'
                                : 'تصفح مجموعتنا الواسعة من العقارات الفاخرة في أفضل المواقع.' }}
                        </p>
                        <div class="mt-8 flex flex-wrap gap-4">
                            <Link :href="route('app.estates')"
                                class="inline-flex items-center gap-2 rounded-xl bg-brand-gold px-7 py-3.5 text-sm font-bold text-brand-maroon shadow-xl transition hover:-translate-y-1 hover:shadow-brand-gold/30 active:scale-95">
                                {{ isEn ? 'View All Properties' : 'عرض جميع العقارات' }}
                                <span class="rounded-full bg-brand-maroon/10 px-2 py-0.5 text-xs">{{
                                    estateCount }}</span>
                            </Link>
                            <Link :href="route('app.contact')"
                                class="inline-flex items-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 px-7 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20 active:scale-95">
                                {{ isEn ? 'Contact Us' : 'تواصل معنا' }}
                            </Link>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-20">

                <!-- ─── Property Types ───────────────────────────────── -->
                <section>
                    <div class="mb-8 flex items-end justify-between">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase tracking-widest text-brand-gold">
                                {{ isEn ? 'Browse by' : 'تصفح حسب' }}
                            </p>
                            <h2 class="text-3xl font-extrabold text-brand-maroon">
                                {{ isEn ? 'Property Types' : 'أنواع العقارات' }}
                            </h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                        <Link v-for="(label, key) in types" :key="key"
                            :href="route('app.estate_filter', { type: key })"
                            class="group flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-gray-100 bg-white p-6 text-center font-bold text-gray-600 shadow-sm transition-all hover:-translate-y-1 hover:border-brand-gold hover:bg-brand-maroon hover:text-white hover:shadow-lg">
                            <span
                                class="iconify text-3xl text-brand-maroon transition group-hover:text-brand-gold"
                                data-icon="carbon:building"></span>
                            <span class="text-sm">{{ label }}</span>
                        </Link>
                    </div>
                </section>

                <!-- ─── Featured Estates ─────────────────────────────── -->
                <section v-if="estates.length">
                    <div class="mb-8 flex items-end justify-between">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase tracking-widest text-brand-gold">
                                {{ isEn ? 'Hand-picked' : 'مختارة بعناية' }}
                            </p>
                            <h2 class="text-3xl font-extrabold text-brand-maroon">
                                {{ isEn ? 'Featured Properties' : 'عقارات مميزة' }}
                            </h2>
                        </div>
                        <Link :href="route('app.estates')"
                            class="flex items-center gap-1 text-sm font-bold text-brand-maroon/60 transition hover:text-brand-maroon">
                            {{ isEn ? 'See All' : 'عرض الكل' }}
                            <span class="iconify" data-icon="carbon:arrow-right"></span>
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <EstateCard v-for="estate in estates" :key="estate.id" :estate="estate" :is-en="isEn"
                            :types="types" variant="grid" />
                    </div>
                </section>

                <!-- ─── Latest Posts ─────────────────────────────────── -->
                <section v-if="posts.length">
                    <div class="mb-8 flex items-end justify-between">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase tracking-widest text-brand-gold">
                                {{ isEn ? 'Our Blog' : 'مدونتنا' }}
                            </p>
                            <h2 class="text-3xl font-extrabold text-brand-maroon">
                                {{ isEn ? 'Latest Articles' : 'أحدث المقالات' }}
                            </h2>
                        </div>
                        <Link :href="route('app.posts')"
                            class="flex items-center gap-1 text-sm font-bold text-brand-maroon/60 transition hover:text-brand-maroon">
                            {{ isEn ? 'See All' : 'عرض الكل' }} ({{ postCount }})
                            <span class="iconify" data-icon="carbon:arrow-right"></span>
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <Link v-for="post in posts" :key="post.id" :href="route('app.post', post.slug)"
                            class="group overflow-hidden rounded-2xl bg-white shadow-md ring-1 ring-black/5 transition-all hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative h-48 overflow-hidden">
                                <img v-if="post.image" :src="`/storage/${post.image}`"
                                    :alt="isEn ? post.title : post.title_ar"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div v-else
                                    class="flex h-full items-center justify-center bg-brand-maroon/10">
                                    <span class="iconify text-4xl text-brand-maroon/30"
                                        data-icon="carbon:document"></span>
                                </div>
                            </div>
                            <div class="p-5">
                                <h3
                                    class="mb-2 font-bold text-brand-maroon line-clamp-2 transition-colors group-hover:text-brand-red">
                                    {{ isEn ? post.title : post.title_ar }}
                                </h3>
                                <time class="text-xs font-medium text-gray-400">
                                    {{ new Date(post.created_at).toLocaleDateString(isEn ? 'en-US' : 'ar-EG', {
                                        year: 'numeric', month: 'short', day: 'numeric'
                                    }) }}
                                </time>
                            </div>
                        </Link>
                    </div>
                </section>

                <!-- ─── FAQ ──────────────────────────────────────────── -->
                <section v-if="faqs.length">
                    <div class="mb-8 flex items-end justify-between">
                        <div>
                            <p class="mb-1 text-xs font-bold uppercase tracking-widest text-brand-gold">
                                {{ isEn ? 'Got Questions?' : 'لديك أسئلة؟' }}
                            </p>
                            <h2 class="text-3xl font-extrabold text-brand-maroon">
                                {{ isEn ? 'Frequently Asked Questions' : 'الأسئلة الشائعة' }}
                            </h2>
                        </div>
                        <Link :href="route('app.faq')"
                            class="flex items-center gap-1 text-sm font-bold text-brand-maroon/60 transition hover:text-brand-maroon">
                            {{ isEn ? 'See All' : 'عرض الكل' }} ({{ faqCount }})
                            <span class="iconify" data-icon="carbon:arrow-right"></span>
                        </Link>
                    </div>

                    <div class="space-y-3">
                        <div v-for="faq in faqs" :key="faq.id"
                            class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                            <button type="button" @click="toggleFaq(faq.id)"
                                class="flex w-full items-center justify-between px-6 py-5 text-left">
                                <span class="pr-8 text-sm font-bold text-brand-maroon">
                                    {{ isEn ? faq.question : faq.question_ar }}
                                </span>
                                <span :class="[
                                    'flex-shrink-0 flex h-7 w-7 items-center justify-center rounded-full transition-all duration-300',
                                    openFaq === faq.id
                                        ? 'bg-brand-maroon text-white rotate-180'
                                        : 'bg-gray-100 text-brand-maroon',
                                ]">
                                    <span class="iconify text-sm" data-icon="carbon:chevron-down"></span>
                                </span>
                            </button>

                            <Transition enter-active-class="transition-all duration-300 ease-out"
                                enter-from-class="opacity-0 max-h-0"
                                enter-to-class="opacity-100 max-h-96"
                                leave-active-class="transition-all duration-200 ease-in"
                                leave-from-class="opacity-100 max-h-96"
                                leave-to-class="opacity-0 max-h-0">
                                <div v-if="openFaq === faq.id" class="overflow-hidden">
                                    <p class="border-t border-gray-50 px-6 py-5 text-sm leading-relaxed text-gray-600">
                                        {{ isEn ? faq.answer : faq.answer_ar }}
                                    </p>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </AppLayout>
</template>
