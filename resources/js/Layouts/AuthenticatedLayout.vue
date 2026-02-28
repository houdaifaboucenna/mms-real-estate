<script setup>
import { computed, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const isSidebarOpen = ref(false);

const page = usePage();
const appName = computed(() => page.props.config.app_name);
const auth = computed(() => page.props.auth);
const translations = computed(() => page.props.globalTranslations);

const toggleSidebar = () => {
    isSidebarOpen.value = !isSidebarOpen.value;
};

</script>

<template>
    <div class="min-h-screen bg-gray-50 font-sans text-gray-900">
        <!-- Sidebar Navigation -->
        <aside :class="[
            'fixed left-0 top-0 z-50 h-screen w-72 transform bg-brand-maroon text-white transition-transform duration-300 ease-in-out lg:translate-x-0',
            isSidebarOpen ? 'translate-x-0' : '-translate-x-full'
        ]">
            <!-- Sidebar Header -->
            <div class="flex h-20 items-center justify-between border-b border-brand-maroon-dark/50 px-6">
                <Link :href="route('app.home')" class="group flex items-center space-x-3">
                    <img class="h-10 w-10 rounded-lg shadow-lg ring-2 ring-brand-gold/20" src="/images/logo.jpg"
                        alt="logo">
                    <div class="flex flex-col">
                        <span
                            class="text-lg font-extrabold tracking-tight text-white group-hover:text-brand-gold transition-colors">{{
                                appName }}</span>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-brand-gold/60">{{
                            translations.view_website }}</span>
                    </div>
                </Link>
                <button @click="toggleSidebar" class="rounded-lg p-2 hover:bg-white/10 lg:hidden">
                    <span class="iconify text-2xl" data-icon="carbon:close"></span>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6 flex-grow overflow-y-auto px-4 space-y-1">
                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('admin.dashboard') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('admin.dashboard')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:dashboard"></span>
                    {{ translations.overview }}
                </Link>

                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('posts.*') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('posts.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:document"></span>
                    {{ translations.articles }}
                </Link>

                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('comments.*') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('comments.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:chat"></span>
                    {{ translations.comments }}
                </Link>

                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('estates.*') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('estates.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:home"></span>
                    {{ translations.estates }}
                </Link>

                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('contacts.*') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('contacts.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:email"></span>
                    {{ translations.messages }}
                </Link>

                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('faq.*') ? 'bg-brand-gold text-brand-maroon shadow-lg shadow-gold-500/20' : 'text-white/70 hover:bg-white/5 hover:text-white'
                ]" :href="route('faq.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:help"></span>
                    {{ translations.faq }}
                </Link>
            </nav>

            <!-- Bottom Navigation -->
            <div class="mt-auto border-t border-brand-maroon-dark/50 p-4 space-y-1">
                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('settings.*') ? 'bg-brand-gold text-brand-maroon' : 'text-white/70 hover:bg-white/5'
                ]" :href="route('settings.index')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:settings"></span>
                    {{ translations.settings }}
                </Link>
                <Link :class="[
                    'group flex items-center rounded-xl px-4 py-3 text-sm font-bold transition-all duration-200',
                    route().current('profile.*') ? 'bg-brand-gold text-brand-maroon' : 'text-white/70 hover:bg-white/5'
                ]" :href="route('profile.edit')">
                    <span class="iconify mr-3 text-xl" data-icon="carbon:user"></span>
                    {{ translations.profile }}
                </Link>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex flex-col min-h-screen lg:pl-72">
            <!-- Header -->
            <header
                class="sticky top-0 z-40 flex h-20 w-full items-center justify-between border-b border-gray-100 bg-white/80 px-6 backdrop-blur-md">
                <div class="flex items-center">
                    <button @click="toggleSidebar"
                        class="mr-4 rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
                        <span class="iconify text-2xl" data-icon="carbon:menu"></span>
                    </button>
                    <!-- Quick Breadcrumb/Title placeholder -->
                    <div class="hidden sm:block">
                        <h2 class="text-xl font-extrabold text-brand-maroon tracking-tight">
                            {{ translations.overview }}
                        </h2>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center space-x-3 rounded-full border border-gray-100 bg-white p-1 pr-4 transition hover:bg-gray-50 hover:shadow-sm">
                            <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-2 ring-brand-gold/10"
                                :src="auth.user.profile.image_url" alt="Avatar">
                            <div class="flex flex-col text-left">
                                <span class="text-sm font-bold text-brand-maroon">{{ auth.user.name }}</span>
                                <span
                                    class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">Administrator</span>
                            </div>
                        </button>

                        <!-- Dropdown Content (Tailwind simple implementation) -->
                        <div
                            class="absolute right-0 top-full mt-2 w-56 origin-top-right scale-0 rounded-2xl border border-gray-100 bg-white p-2 shadow-2xl transition-all duration-200 group-hover:scale-100">
                            <Link
                                class="flex items-center rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors"
                                :href="route('profile.edit')">
                                <span class="iconify mr-3 text-brand-maroon" data-icon="carbon:user"></span>
                                {{ translations.profile }}
                            </Link>
                            <Link
                                class="flex items-center rounded-xl px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors"
                                :href="route('settings.index')">
                                <span class="iconify mr-3 text-brand-maroon" data-icon="carbon:settings"></span>
                                {{ translations.settings }}
                            </Link>
                            <div class="my-2 border-t border-gray-50"></div>
                            <Link
                                class="flex w-full items-center rounded-xl px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition-colors"
                                :href="route('logout')" method="post" as="button">
                                <span class="iconify mr-3" data-icon="carbon:logout"></span>
                                {{ translations.logout }}
                            </Link>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-grow p-6 lg:p-10">
                <!-- Content Header Slot (Optional) -->
                <div v-if="$slots.header" class="mb-8 flex items-center justify-between">
                    <slot name="header" />
                </div>

                <!-- Alert Messages (Shared across Admin) -->
                <div v-if="page.props.flash.success"
                    class="mb-6 overflow-hidden rounded-2xl bg-emerald-50 border-l-4 border-emerald-500 p-4 shadow-sm animate-fade-in-down">
                    <div class="flex items-center">
                        <span class="iconify text-2xl text-emerald-500" data-icon="carbon:checkmark-filled"></span>
                        <p class="ml-3 text-sm font-bold text-emerald-800">{{ page.props.flash.success }}</p>
                    </div>
                </div>

                <!-- Slot for Dashboard Content -->
                <slot name="content" />
            </main>

            <!-- Copyright footer -->
            <footer class="mt-auto border-t border-gray-100 bg-white py-6 px-10">
                <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-widest">
                    {{ translations.copyright }}
                </p>
            </footer>
        </div>

        <!-- Mobile Sidebar Overlay -->
        <div v-if="isSidebarOpen" @click="toggleSidebar"
            class="fixed inset-0 z-40 bg-brand-maroon/20 backdrop-blur-sm transition-opacity lg:hidden"></div>
    </div>
</template>

<style>
/* Custom animations */
@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-down {
    animation: fade-in-down 0.4s ease-out forwards;
}

/* Scrollbar styling for sidebar */
aside::-webkit-scrollbar {
    width: 4px;
}

aside::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
}
</style>
