<script setup>
import ContactForm from '@/Components/Form/ContactForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import md5 from 'md5';

const props = defineProps({
    translations: Object,
    post: Object,
    comments: Object,
});

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const commentForm = useForm({
    name: '',
    email: '',
    content: '',
    post_id: props.post.id,
});

function getGravatar(email) {
    return 'https://www.gravatar.com/avatar/' + md5(email.toLowerCase()) + '?s=100&d=identicon';
}

</script>

<template>

    <Head :title="post.title" />

    <AppLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">

                <!-- Main Post Content -->
                <div class="lg:col-span-2">
                    <article class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                        <!-- Featured Image -->
                        <div class="relative h-[300px] sm:h-[450px] w-full overflow-hidden">
                            <img :src="'/storage/' + post.image" :alt="isEn ? post.title : post.title_ar"
                                class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            </div>
                            <div class="absolute bottom-6 left-6 right-6 lg:bottom-10 lg:left-10 lg:right-10">
                                <h1
                                    class="text-3xl font-extrabold text-white sm:text-4xl md:text-5xl tracking-tight leading-tight">
                                    {{ isEn ? post.title : post.title_ar }}
                                </h1>
                            </div>
                        </div>

                        <!-- Post Body -->
                        <div class="p-6 sm:p-10 lg:p-12">
                            <div class="flex items-center gap-4 border-b border-gray-100 pb-8 mb-8">
                                <span
                                    class="inline-flex items-center rounded-full bg-brand-gold/10 px-3 py-1 text-sm font-semibold text-brand-gold ring-1 ring-inset ring-brand-gold/20">
                                    {{ isEn ? 'Real Estate News' : 'أخبار العقارات' }}
                                </span>
                                <span class="flex items-center gap-1.5 text-sm font-medium text-gray-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ new Date(post.created_at).toLocaleDateString() }}
                                </span>
                            </div>

                            <div class="prose prose-lg prose-brand-maroon max-w-none text-gray-700 leading-relaxed"
                                v-html="isEn ? post.content : post.content_ar">
                            </div>
                        </div>
                    </article>

                    <!-- Comments Section -->
                    <div class="mt-12 overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                        <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4 sm:px-10">
                            <h3 class="text-xl font-bold text-brand-maroon flex items-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                {{ translations.comments }}
                            </h3>
                        </div>

                        <div class="p-6 sm:p-10">
                            <!-- Comment List -->
                            <div class="space-y-8">
                                <div v-for="comment in comments" :key="comment.id" class="flex gap-4">
                                    <img :src="getGravatar(comment.email)" :alt="comment.name"
                                        class="h-12 w-12 shrink-0 rounded-full border-2 border-brand-gold/20 shadow-sm">
                                    <div class="flex-1 rounded-2xl bg-gray-50 p-4 ring-1 ring-gray-100">
                                        <p class="font-bold text-brand-maroon mb-1">{{ comment.name }}</p>
                                        <p class="text-gray-600 text-sm leading-normal">{{ comment.content }}</p>
                                    </div>
                                </div>
                                <p v-if="!comments.length" class="text-center text-gray-400 italic">
                                    {{ translations.be_first_comment }}
                                </p>
                            </div>

                            <!-- Comment Form -->
                            <div class="mt-12 pt-8 border-t border-gray-100">
                                <h4 class="text-lg font-bold text-brand-maroon mb-6">{{ translations.add_comment }}</h4>
                                <form
                                    @submit.prevent="commentForm.post(route('comments.store'), { onSuccess: () => commentForm.reset() })"
                                    class="space-y-6">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <input type="text" v-model="commentForm.name"
                                                :placeholder="translations.name"
                                                class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-brand-gold focus:ring-brand-gold">
                                        </div>
                                        <div>
                                            <input type="email" v-model="commentForm.email"
                                                :placeholder="translations.email"
                                                class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-brand-gold focus:ring-brand-gold">
                                        </div>
                                    </div>
                                    <div>
                                        <textarea v-model="commentForm.content" rows="4"
                                            :placeholder="translations.add_comment + ' ...'"
                                            class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm focus:border-brand-gold focus:ring-brand-gold"></textarea>
                                    </div>
                                    <button type="submit" :disabled="commentForm.processing"
                                        class="inline-flex items-center justify-center rounded-lg bg-brand-maroon px-8 py-3 text-sm font-bold text-white shadow-lg transition-transform hover:scale-105 active:scale-95 disabled:opacity-50">
                                        {{ translations.add_comment }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Area -->
                <aside class="space-y-8 lg:col-span-1">
                    <div class="sticky top-28 overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">
                        <div class="p-6 sm:p-8">
                            <ContactForm :translations="translations.contact_form" />
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </AppLayout>

</template>

<style scoped></style>
