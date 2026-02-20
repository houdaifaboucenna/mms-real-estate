<script setup>
import Pagination from '@/Components/Pagination.vue';
import PostCard from '@/Components/PostCard.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    translations: Object,
    posts: Object,
});
</script>

<template>

    <Head :title="translations.posts" />

    <AppLayout>
        <div class="relative overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
            <!-- Banner Section -->
            <div class="relative h-[320px] w-full overflow-hidden">
                <img src="/images/background/background-2.jpg" :alt="translations.all_articles"
                    class="h-full w-full object-cover">
                <!-- Advanced Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-brand-maroon/90 via-brand-maroon/40 to-transparent">
                </div>

                <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12">
                    <div class="relative z-10 max-w-3xl">
                        <nav class="mb-4 flex text-sm font-medium text-brand-gold/90" aria-label="Breadcrumb">
                            <span>{{ isEn ? 'Home' : 'الرئيسية' }}</span>
                            <span class="mx-2 text-white/40">/</span>
                            <span class="text-white">{{ translations.posts }}</span>
                        </nav>
                        <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">
                            {{ translations.all_articles }}
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="bg-gray-50/50 p-6 md:p-10">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="posts">
                    <!-- Post Item -->
                    <PostCard v-for="post in posts.data" :key="post.id" :post="post" :isEn="isEn" />
                </div>

                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    <Pagination :links="posts.links" />
                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped></style>
