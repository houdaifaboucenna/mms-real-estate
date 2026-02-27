<script setup>
import ContactForm from '@/Components/Form/ContactForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    translations: Object,
    faqs: Array,
});

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const accordion = ref(null);

</script>

<template>

    <Head :title="translations.faq" />

    <AppLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-8">
                    <!-- FAQ Header -->
                    <div class="border-l-4 border-brand-gold pl-6 py-2 mb-10">
                        <h2 class="text-4xl font-extrabold text-brand-maroon tracking-tight">{{ translations.faq }}</h2>
                        <p class="mt-2 text-lg text-gray-500 italic">{{ translations.faq_header }}</p>
                    </div>

                    <!-- FAQ List -->
                    <div class="space-y-4">
                        <div v-for="faq in faqs" :key="faq.id"
                            class="overflow-hidden rounded-2xl bg-white shadow-md ring-1 ring-black/5 transition-all"
                            :class="{ 'ring-brand-gold/30 shadow-brand-gold/10': accordion === faq.id }">

                            <button @click="accordion === faq.id ? accordion = null : accordion = faq.id"
                                class="flex w-full items-center justify-between px-6 py-5 text-left transition-colors hover:bg-gray-50/50">
                                <span class="flex items-center gap-4">
                                    <span
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-colors"
                                        :class="accordion === faq.id ? 'bg-brand-maroon text-white' : 'bg-brand-gold/10 text-brand-gold-dark'">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-lg font-bold transition-colors"
                                        :class="accordion === faq.id ? 'text-brand-maroon' : 'text-gray-700'">
                                        {{ isEn ? faq.question : faq.question_ar }}
                                    </span>
                                </span>
                                <svg class="h-6 w-6 transition-transform duration-300 text-gray-400"
                                    :class="{ 'rotate-180 text-brand-gold-dark': accordion === faq.id }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <Transition enter-active-class="transition duration-200 ease-out"
                                enter-from-class="max-h-0 opacity-0" enter-to-class="max-h-[500px] opacity-100"
                                leave-active-class="transition duration-150 ease-in"
                                leave-from-class="max-h-[500px] opacity-100" leave-to-class="max-h-0 opacity-0">
                                <div v-show="accordion === faq.id">
                                    <div
                                        class="px-20 pb-6 text-gray-600 leading-relaxed border-t border-gray-50/50 pt-4">
                                        {{ isEn ? faq.answer : faq.answer_ar }}
                                    </div>
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-28 rounded-2xl bg-white p-8 shadow-xl ring-1 ring-black/5">
                        <ContactForm :translations="translations.contact_form" />
                    </div>
                </aside>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped></style>
