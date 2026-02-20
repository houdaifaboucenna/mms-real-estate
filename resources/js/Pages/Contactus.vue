<script setup>
import ContactForm from '@/Components/Form/ContactForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const settings = computed(() => page.props.settings);

const props = defineProps({
    translations: Object
});

</script>

<template>

    <Head :title="translations.contactus" />

    <AppLayout>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">

                <!-- Contact Info & Map -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Cards Grid -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Address Card -->
                        <div
                            class="rounded-2xl bg-white p-8 shadow-xl ring-1 ring-black/5 transition-all hover:scale-[1.02]">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-maroon/10 text-brand-maroon mb-6">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-brand-maroon mb-2">{{ translations.address }}</h3>
                            <p class="text-gray-600 leading-relaxed">{{ translations.adrs }}</p>
                        </div>

                        <!-- Quick Contact Card -->
                        <div
                            class="rounded-2xl bg-white p-8 shadow-xl ring-1 ring-black/5 transition-all hover:scale-[1.02]">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-gold/10 text-brand-gold mb-6">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-brand-maroon mb-4">{{ isEn ? 'Get in Touch' : 'تواصل معنا'
                            }}</h3>
                            <ul class="space-y-4">
                                <li>
                                    <a :href="'tel:' + settings.phone"
                                        class="group flex items-center gap-3 text-gray-600 transition hover:text-brand-red">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-50 group-hover:bg-brand-red/10 group-hover:text-brand-red transition-colors italic">
                                            <span class="iconify" data-icon="bi:telephone-fill"></span>
                                        </span>
                                        <span class="font-medium">{{ settings.phone }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a :href="'https://wa.me/' + settings.whatsapp.replace(/\s/g, '')" target="_blank"
                                        class="group flex items-center gap-3 text-gray-600 transition hover:text-brand-whatsapp">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-50 group-hover:bg-brand-whatsapp group-hover:text-white transition-colors">
                                            <span class="iconify" data-icon="bi:whatsapp"></span>
                                        </span>
                                        <span class="font-medium">{{ settings.whatsapp }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a :href="'mailto:' + settings.email"
                                        class="group flex items-center gap-3 text-gray-600 transition hover:text-blue-600">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-50 group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                                            <span class="iconify" data-icon="carbon:email"></span>
                                        </span>
                                        <span class="font-medium truncate">{{ settings.email }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div class="overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-black/5">
                        <iframe class="w-full grayscale-[0.2] transition-all hover:grayscale-0"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2424.2872037611833!2d28.683593633557063!3d41.011689714781575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caa09a133a8ac5%3A0xef56e6d6a8ae2a8d!2sNam%C4%B1k%20Kemal%2C%20Haramidere%20Yolu%2C%2034513%20Esenyurt%2F%C4%B0stanbul%2C%20Turkey!5e0!3m2!1sen!2sdz!4v1640074649258!5m2!1sen!2sdz"
                            height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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
