<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const translations = computed(() => page.props.globalTranslations);

const props = defineProps({
    estate: Object,
    types: Object,
    isEn: Boolean,
    variant: {
        type: String,
        default: 'list',
    },
});

const typeLabel = computed(() => props.types?.[props.estate.type] || props.estate.type);
</script>

<template>
    <Link :href="route('app.estate', estate.slug)" :class="[
        'group block overflow-hidden rounded-2xl bg-white ring-1 ring-black/5 transition-all hover:-translate-y-2 hover:shadow-2xl',
        variant === 'list' ? 'shadow-xl' : 'shadow-md',
    ]">
        <!-- Image -->
        <div :class="['relative overflow-hidden', variant === 'list' ? 'aspect-[16/10]' : 'h-48']">
            <img v-if="estate.image && estate.image[0]" :src="'/storage/' + estate.image[0]"
                :alt="isEn ? estate.title : estate.title_ar"
                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
            <img v-else src="/images/background/background-5.jpg" :alt="isEn ? estate.title : estate.title_ar"
                class="h-full w-full object-cover">

            <!-- Type badge -->
            <div class="absolute right-3 top-3">
                <span
                    class="rounded-lg bg-white/90 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-maroon shadow-lg backdrop-blur-sm">
                    {{ typeLabel }}
                </span>
            </div>
        </div>

        <!-- Content -->
        <div :class="['flex flex-col', variant === 'list' ? 'p-6' : 'p-4']">
            <h3 :class="[
                'font-bold text-brand-maroon transition-colors group-hover:text-brand-red line-clamp-1',
                variant === 'list' ? 'mb-3 text-xl' : 'mb-2 text-base',
            ]">
                {{ isEn ? estate.title : estate.title_ar }}
            </h3>

            <div v-if="estate.city" class="mb-3 flex items-center gap-2 text-sm text-gray-500">
                <span class="iconify text-brand-gold flex-shrink-0" data-icon="carbon:location-filled"></span>
                <span class="truncate">{{ estate.city.name }}<template v-if="estate.town">, {{ estate.town.name
                }}</template></span>
            </div>

            <p v-if="variant === 'list'" class="mb-6 text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ isEn ? estate.short : estate.short_ar }}
            </p>

            <div class="mt-auto flex items-center justify-between border-t border-gray-100 pt-3">
                <div class="flex flex-col">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">
                        {{ translations?.price }}
                    </span>
                    <span :class="['font-extrabold text-brand-maroon', variant === 'list' ? 'text-lg' : 'text-base']">
                        {{ estate.min }}$ <span class="font-normal text-gray-400">–</span> {{ estate.max }}$
                    </span>
                </div>
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-maroon text-white transition group-hover:bg-brand-gold">
                    <span class="iconify" data-icon="carbon:arrow-right"></span>
                </span>
            </div>
        </div>
    </Link>
</template>