<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
})
</script>

<template>
    <nav class="col-span-full mt-10" v-if="links.length > 3">
        <ul class="flex flex-wrap justify-center gap-2">
            <li v-for="link in links" :key="link.label">
                <Link v-if="link.url" :href="link.url" v-html="link.label"
                    class="inline-flex min-w-[42px] items-center justify-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm transition-all hover:border-brand-maroon hover:bg-brand-maroon hover:text-white"
                    :class="{ '!border-brand-maroon !bg-brand-maroon !text-white !shadow-brand-maroon/20': link.active }">
                </Link>
                <span v-else v-html="link.label"
                    class="inline-flex min-w-[42px] items-center justify-center rounded-lg border border-gray-100 bg-gray-50 px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed">
                </span>
            </li>
        </ul>
    </nav>
</template>

<style scoped>
.active {
    background-color: #1a8b58;
    color: #fff;
    border-color: #1a8b58;
}
</style>