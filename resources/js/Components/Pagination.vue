<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    links: Array,
})
</script>

<template>
    <nav class="col-span-full">
        <ul class="pagination flex justify-center gap-2">
            <li :class="['border border-gray-300', 'py-2 px-4', 'rounded', { 'active': link.active, 'disabled': !link.url }]"
                v-for="link in links" :key="link.label">
                <Link v-if="link.url" :href="link.url" v-html="link.label"></Link>
                <span v-else v-html="link.label"></span>
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