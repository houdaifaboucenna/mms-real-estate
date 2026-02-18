<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    translations: Object,
});
</script>

<template>

    <Head :title="translations.about" />

    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 rounded-lg relative">
            <div class="grid grid-cols-1 gap-4" style="background-color: #ffffffd5;">
                <img src="/images/background/about1.png" alt="about" class="w-full h-96 rounded-t-lg">
                <div class="py-3 px-4">
                    <div class="mb-5">
                        <p class="text-2xl leading-relaxed">
                            {{ translations.who_txt }}
                        </p>
                    </div>
                    <div class="flex gap-4 mb-5">
                        <div>
                            <h2 class="text-4xl mb-3 font-bold">{{ translations.vision }}</h2>
                            <p class="text-2xl leading-relaxed">
                                {{ translations.vision_txt }}
                            </p>
                        </div>
                        <img src="/images/background/about2.png" alt="" class="block h-96">
                    </div>
                    <div class="flex gap-4">
                        <img src="/images/background/about3.png" alt="" class="block h-96">
                        <div>
                            <h2 class="text-4xl mb-3 font-bold">{{ translations.mission }}</h2>
                            <p class="text-2xl leading-relaxed">
                                {{ translations.mission_txt }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>
