import { ref } from 'vue';

const toast = ref(null);
let timeoutId = null;

export function useToast() {

    const showToast = (message, type = 'success', duration = 3000) => {
        clearTimeout(timeoutId);
        toast.value = { message, type, duration };
        timeoutId = setTimeout(() => {
            toast.value = null;
        }, duration);
    };

    const hideToast = () => {
        clearTimeout(timeoutId);
        toast.value = null;
    };

    return { toast, showToast, hideToast };
}