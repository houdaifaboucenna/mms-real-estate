<script setup>
import { useToast } from '@/Composables/useToast';
import { Icon } from '@iconify/vue';
import { watch } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const { toast, showToast, hideToast } = useToast();

watch(() => page.props.flash, (flash) => {
    if (flash.success) showToast(flash.success, 'success');
    if (flash.error) showToast(flash.error, 'error');
}, { immediate: true });

</script>

<template>
    <Transition name="fade">
        <div class="fixed top-4 right-4 z-50" v-if="toast" :key="toast.message"
            :style="{ '--toast-duration': toast.duration + 'ms' }">
            <div
                :class="['relative overflow-hidden rounded-lg p-4 shadow-lg flex items-center gap-2', toast.type === 'success' ? 'bg-green-200' : 'bg-red-200']">
                <Icon :icon="toast.type === 'success' ? 'carbon:checkmark-filled' : 'carbon:alert-filled'"
                    :class="['text-2xl', toast.type === 'success' ? 'text-green-700' : 'text-red-700']" />
                <p class="text-sm font-bold">{{ toast.message }}</p>
                <button @click="hideToast" class="ml-2 text-gray-500 hover:text-gray-700">
                    <Icon icon="carbon:close" class="text-lg" />
                </button>

                <!-- Progress bar -->
                <div class="absolute bottom-0 left-0 h-1 w-full">
                    <div :class="['h-full progress-bar', toast.type === 'success' ? 'bg-green-600' : 'bg-red-600']">
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.fade-enter-active {
    transition: all 0.3s ease-out;
}

.fade-leave-active {
    transition: all 0.2s ease-in;
}

.fade-enter-from {
    opacity: 0;
    transform: translateX(100px);
}

.fade-leave-to {
    opacity: 0;
    transform: translateX(100px);
}

.progress-bar {
    animation: shrink var(--toast-duration, 3000ms) linear forwards;
}

@keyframes shrink {
    from {
        width: 100%;
    }

    to {
        width: 0%;
    }
}
</style>