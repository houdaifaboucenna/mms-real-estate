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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 rounded-lg relative">
            <div class="grid grid-cols-1 gap-4" style="background-color: #ffffffd5;">
                <div class="col-span-1">

                    <!-- Banner -->
                    <div class="banner">
                        <img src="/images/background/background-2.jpg" alt="" class="w-full h-64 rounded-t-lg">
                        <div class="overlay"></div>
                        <h1 class="text-white text-4xl font-bold -mt-16 mb-10 py-3 px-4">{{ translations.all_articles }}
                        </h1>
                    </div>

                    <!-- Posts list -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4" id="posts">
                        <!-- Post Item -->
                        <PostCard v-for="post in posts.data" :key="post.id" :post="post" :isEn="isEn" />

                        <!-- Pagination -->
                        <Pagination :links="posts.links" />
                    </div>

                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped></style>
