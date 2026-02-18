<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
    isEn: Boolean,
})
</script>

<template>
    <div class="col-span-1 mb-2">
        <div class="post">
            <div class="post-img w-full h-48">
                <img :src="'/storage/' + post.image" :alt="isEn ? post.title : post.title_ar">
            </div>
            <Link :href="route('app.post', { post: post.slug })" class="post-title">
                {{ isEn ? post.title : post.title_ar }}
            </Link>
            <div class="post-date">{{ new Date(post.created_at).toLocaleDateString() }}</div>
        </div>
    </div>
</template>