<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    post: Object,
    isEn: Boolean,
})
</script>

<template>
    <div
        class="col-span-1 border-brand-maroon/10 h-full overflow-hidden transition-all duration-300 hover:-translate-y-1">
        <div
            class="flex h-full flex-col overflow-hidden rounded-xl bg-white shadow-md ring-1 ring-black/5 transition-all hover:shadow-xl group">
            <!-- Image Area -->
            <div class="relative aspect-[16/10] w-full overflow-hidden">
                <img :src="'/storage/' + post.image" :alt="isEn ? post.title : post.title_ar"
                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110" />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                </div>
            </div>

            <!-- Content Area -->
            <div class="flex flex-1 flex-col p-5">
                <Link :href="route('app.post', { post: post.slug })"
                    class="mb-3 block text-xl font-bold text-brand-maroon transition-colors hover:text-brand-red leading-tight">
                    {{ isEn ? post.title : post.title_ar }}
                </Link>

                <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                    <span class="flex items-center gap-1.5 text-sm font-medium text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ new Date(post.created_at).toLocaleDateString() }}
                    </span>

                    <Link :href="route('app.post', { post: post.slug })"
                        class="text-sm font-bold text-brand-gold hover:text-brand-maroon transition-colors">
                        {{ isEn ? 'Read More' : 'اقرأ المزيد' }} →
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>