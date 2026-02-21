<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { computed, ref, onMounted, onUnmounted } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings);
const locale = computed(() => page.props.locale);
const isEn = computed(() => locale.value === 'en');
const latestPosts = computed(() => page.props.latestPosts ?? []);
const propertyTypes = computed(() => page.props.propertyTypes ?? []);
const translations = computed(() => page.props.translations);

defineProps({
    title: { type: String, default: '' },
});


const navLinks = [
    { name: 'Home', nameAr: 'الرئيسية', route: 'app.home' },
    { name: 'Properties', nameAr: 'العقارات', route: 'app.estates' },
    { name: 'Blog', nameAr: 'المدونة', route: 'app.posts' },
    { name: 'About', nameAr: 'من نحن', route: 'app.about' },
    { name: 'Contact Us', nameAr: 'اتصل بنا', route: 'app.contact' },
    { name: 'FAQ', nameAr: 'الأسئلة', route: 'app.faq' },
];

/* ─── Mobile menu toggle ────────────────── */
const mobileOpen = ref(false);

/* ─── Scroll-to-top visibility ──────────── */
const showScrollTop = ref(false);
function onScroll() {
    showScrollTop.value = window.scrollY > 200;
}
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
onMounted(() => window.addEventListener('scroll', onScroll));
onUnmounted(() => window.removeEventListener('scroll', onScroll));

/* ─── Search ────────────────────────────── */
const searchQuery = ref('');
function submitSearch() {
    if (searchQuery.value.trim()) {
        router.get(route('app.search'), { q: searchQuery.value }, { preserveState: true });
    }
}
</script>

<template>
    <div :dir="isEn ? 'ltr' : 'rtl'" class="flex min-h-screen flex-col bg-brand-beige font-sans">

        <!-- ═══════════════════ HEADER ═══════════════════ -->
        <header class="sticky top-0 z-50">
            <nav class="bg-gradient-to-l bg-brand-maroon px-[6%] py-3">

                <div class="mx-auto flex max-w-7xl flex-wrap items-end justify-between gap-4">
                    <!-- Logo -->
                    <Link :href="route('app.home')" class="shrink-0">
                        <img src="/images/logo1.png" alt="MmsEstate"
                            class="h-[90px] w-[115px] rounded-lg brightness-110" />
                    </Link>

                    <!-- Mobile: lang switch + hamburger -->
                    <div class="flex items-center gap-3 md:hidden">
                        <Link :href="route('app.switch_lang')"
                            class="rounded-lg bg-brand-gold px-4 py-1 text-sm font-bold text-white shadow">
                            {{ isEn ? 'Ar' : 'En' }}
                        </Link>
                        <button @click="mobileOpen = !mobileOpen"
                            class="rounded p-1 text-gray-200 hover:text-white focus:outline-none">
                            <!-- Hamburger / Close icon -->
                            <svg v-if="!mobileOpen" class="h-7 w-7" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg v-else class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Desktop nav area -->
                    <div class="hidden w-full flex-col items-end md:flex md:w-auto">
                        <!-- Upper row: search + phone + whatsapp + social -->
                        <div class="flex flex-wrap items-center justify-end gap-4">
                            <!-- Search -->
                            <form @submit.prevent="submitSearch" class="flex">
                                <div class="flex overflow-hidden rounded">
                                    <span
                                        class="flex items-center border border-r-0 border-gray-300/30 bg-white/60 px-2">
                                        <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </span>
                                    <input v-model="searchQuery" type="text" :placeholder="translations.search + '... '"
                                        class="border border-l-0 border-gray-300/30 bg-white/40 px-3 py-1.5 text-sm text-gray-100 placeholder-gray-300 focus:outline-none" />
                                </div>
                            </form>

                            <!-- Phone -->
                            <a v-if="settings.phone" :href="`tel:${settings.phone}`"
                                class="flex items-center gap-2 text-gray-300 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                                <span class="text-sm">{{ settings.phone }}</span>
                            </a>

                            <!-- WhatsApp -->
                            <a v-if="settings.whatsapp" :href="`https://wa.me/${settings.whatsapp?.replace(/\s/g, '')}`"
                                target="_blank"
                                class="flex items-center gap-2 text-brand-whatsapp transition hover:text-green-300">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                                <span class="text-sm text-gray-300">{{ settings.whatsapp }}</span>
                            </a>

                            <!-- Social icons -->
                            <div class="flex items-center gap-1">
                                <a v-if="settings.facebook" :href="settings.facebook" target="_blank"
                                    class="p-1.5 text-gray-400 transition hover:text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                                <a v-if="settings.instagram" :href="settings.instagram" target="_blank"
                                    class="p-1.5 text-gray-400 transition hover:text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                    </svg>
                                </a>
                                <a v-if="settings.twitter" :href="settings.twitter" target="_blank"
                                    class="p-1.5 text-gray-400 transition hover:text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                    </svg>
                                </a>
                                <a v-if="settings.telegram" :href="settings.telegram" target="_blank"
                                    class="p-1.5 text-gray-400 transition hover:text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0h-.056zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                    </svg>
                                </a>
                                <a v-if="settings.linkedin" :href="settings.linkedin" target="_blank"
                                    class="p-1.5 text-gray-400 transition hover:text-white">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Lower row: nav links -->
                        <ul class="mt-3 flex list-none flex-wrap gap-0.5 p-0">
                            <li v-for="link in navLinks" :key="link.route">
                                <Link :href="route(link.route)"
                                    class="inline-block rounded px-3 py-1.5 text-lg text-gray-300 transition hover:text-white"
                                    :class="{ 'text-white font-semibold': route().current(link.route) }">
                                    {{ isEn ? link.name : link.nameAr }}
                                </Link>
                            </li>
                            <li>
                                <Link :href="route('app.switch_lang')"
                                    class="inline-block rounded-lg bg-indigo-500 px-2.5 py-1 text-base font-bold text-white shadow transition hover:bg-indigo-600">
                                    {{ isEn ? 'Ar' : 'En' }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Mobile dropdown -->
                <Transition enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2">
                    <div v-show="mobileOpen" class="mt-4 flex flex-col gap-2 border-t border-white/20 pt-4 md:hidden">
                        <!-- Phone / WhatsApp -->
                        <div class="flex flex-wrap gap-3 text-sm">
                            <a v-if="settings.phone" :href="`tel:${settings.phone}`"
                                class="flex items-center gap-1 text-gray-300 hover:text-white">
                                📞 {{ settings.phone }}
                            </a>
                            <a v-if="settings.whatsapp" :href="`https://wa.me/${settings.whatsapp?.replace(/\s/g, '')}`"
                                target="_blank" class="flex items-center gap-1 text-gray-300 hover:text-white">
                                💬 {{ settings.whatsapp }}
                            </a>
                        </div>
                        <!-- Nav links -->
                        <Link v-for="link in navLinks" :key="link.route" :href="route(link.route)"
                            class="rounded px-3 py-2 text-gray-200 transition hover:bg-white/10"
                            :class="{ 'bg-white/10 font-semibold': route().current(link.route) }">
                            {{ isEn ? link.name : link.nameAr }}
                        </Link>
                    </div>
                </Transition>
            </nav>
        </header>

        <!-- ═══════════════════ FLASH ═══════════════════ -->
        <div v-if="$page.props.flash?.success" class="bg-emerald-500 py-3 text-center font-medium text-white">
            {{ $page.props.flash.success }}
        </div>

        <!-- ═══════════════════ MAIN ═══════════════════ -->
        <main class="mx-auto w-full max-w-7xl flex-1 px-[6%] py-8">
            <slot />
        </main>

        <!-- ═══════════════════ FOOTER ═══════════════════ -->
        <footer class="relative mt-4 bg-brand-maroon text-white">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-[6%] py-8 sm:grid-cols-2 lg:grid-cols-4">

                <!-- Col 1: Logo -->
                <div class="flex items-start justify-center sm:justify-start">
                    <Link :href="route('app.home')">
                        <img src="/images/logo1.png" alt="MmsEstate"
                            class="h-[130px] w-auto rounded-[10px] brightness-[1.15]" />
                    </Link>
                </div>

                <!-- Col 2: Latest Articles -->
                <div v-if="latestPosts.length">
                    <h3 class="mb-3 text-lg font-medium">{{ translations.latest_articles }}</h3>
                    <ul class="list-none space-y-2 p-0">
                        <li v-for="post in latestPosts" :key="post.id">
                            <Link :href="route('app.post', post.slug)"
                                class="text-gray-300 transition hover:text-white">
                                {{ isEn ? post.title : post.title_ar }}
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Col 3: Property Types -->
                <div v-if="propertyTypes.length">
                    <h3 class="mb-3 text-lg font-medium">{{ translations.property_types }}</h3>
                    <ul class="list-none space-y-2 p-0">
                        <li v-for="type in propertyTypes" :key="type.key">
                            <Link :href="route('app.estate_filter', { type: type.key })"
                                class="text-gray-300 transition hover:text-white">
                                {{ type.label }}
                                <span class="text-sm text-gray-400">({{ type.count }})</span>
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Col 4: Social & Contact -->
                <div>
                    <h3 class="mb-3 text-lg font-medium">{{ translations.stay_connected }}</h3>
                    <!-- Social -->
                    <ul class="mb-4 flex list-none flex-wrap gap-0.5 p-0">
                        <li v-if="settings.facebook">
                            <a :href="settings.facebook" target="_blank"
                                class="inline-block p-1.5 text-gray-400 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                        </li>
                        <li v-if="settings.instagram">
                            <a :href="settings.instagram" target="_blank"
                                class="inline-block p-1.5 text-gray-400 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>
                        </li>
                        <li v-if="settings.twitter">
                            <a :href="settings.twitter" target="_blank"
                                class="inline-block p-1.5 text-gray-400 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                        </li>
                        <li v-if="settings.telegram">
                            <a :href="settings.telegram" target="_blank"
                                class="inline-block p-1.5 text-gray-400 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0h-.056zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                                </svg>
                            </a>
                        </li>
                        <li v-if="settings.linkedin">
                            <a :href="settings.linkedin" target="_blank"
                                class="inline-block p-1.5 text-gray-400 transition hover:text-white">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </li>
                    </ul>

                    <!-- Contact -->
                    <h3 class="mb-2 mt-4 text-lg font-medium">{{ translations.contact_us }}</h3>
                    <ul class="list-none space-y-2 p-0">
                        <li v-if="settings.phone">
                            <a :href="`tel:${settings.phone}`"
                                class="flex items-center gap-2 text-gray-400 transition hover:text-white">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                </svg>
                                <span class="text-sm">{{ settings.phone }}</span>
                            </a>
                        </li>
                        <li v-if="settings.whatsapp">
                            <a :href="`https://wa.me/${settings.whatsapp?.replace(/\s/g, '')}`" target="_blank"
                                class="flex items-center gap-2 text-gray-400 transition hover:text-white">
                                <svg class="h-4 w-4 text-brand-whatsapp" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                                <span class="text-sm">{{ settings.whatsapp }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright bar (darker strip) -->
            <div class="bg-brand-maroon-dark/80 py-3 text-center text-sm text-gray-400">
                © {{ new Date().getFullYear() }} MmsEstate. {{ translations.copyright }}
            </div>
        </footer>

        <!-- ═══════════════════ SCROLL TO TOP ═══════════════════ -->
        <Transition enter-active-class="transition duration-300" enter-from-class="opacity-0 translate-y-4"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 translate-y-4">
            <button v-show="showScrollTop" @click="scrollToTop"
                class="fixed bottom-6 right-6 z-50 flex h-11 w-11 items-center justify-center rounded-full bg-brand-red text-white shadow-lg transition hover:bg-red-700">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>
        </Transition>
    </div>
</template>
