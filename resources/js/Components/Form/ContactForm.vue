<script setup>
import { usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    translations: Object,
});

const page = usePage();

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
});

</script>

<template>
    <div class="relative">
        <form @submit.prevent="form.post(route('contacts.store'), { onSuccess: () => form.reset() })" class="space-y-5">

            <!-- Success Message -->
            <Transition enter-active-class="transition duration-300 ease-out"
                enter-from-class="opacity-0 -translate-y-2" enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-200 ease-in" leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2">
                <div v-if="page.props.flash.success"
                    class="flex items-center gap-3 rounded-lg border border-emerald-100 bg-emerald-50 p-4 text-sm font-medium text-emerald-700 shadow-sm">
                    <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ page.props.flash.success }}
                </div>
            </Transition>

            <div class="mb-6">
                <h3 class="text-2xl font-bold text-brand-maroon">{{ translations.getin }}</h3>
                <p class="mt-1 text-sm text-gray-500">{{ translations.fillin }}</p>
            </div>

            <!-- Name Field -->
            <div class="space-y-1">
                <input v-model="form.name" type="text" :placeholder="translations.name"
                    class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition-all focus:border-brand-gold focus:ring-brand-gold"
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.name }">
                <p v-if="form.errors.name" class="text-xs font-medium text-red-600">{{ form.errors.name }}</p>
            </div>

            <!-- Email Field -->
            <div class="space-y-1">
                <input v-model="form.email" type="email" :placeholder="translations.email"
                    class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition-all focus:border-brand-gold focus:ring-brand-gold"
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.email }">
                <p v-if="form.errors.email" class="text-xs font-medium text-red-600">{{ form.errors.email }}</p>
            </div>

            <!-- Phone Field -->
            <div class="space-y-1">
                <input v-model="form.phone" type="tel" :placeholder="translations.phone"
                    class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition-all focus:border-brand-gold focus:ring-brand-gold"
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.phone }">
                <p v-if="form.errors.phone" class="text-xs font-medium text-red-600">{{ form.errors.phone }}</p>
            </div>

            <!-- Message Field -->
            <div class="space-y-1">
                <textarea v-model="form.message" rows="4" :placeholder="translations.message"
                    class="block w-full rounded-lg border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 shadow-sm transition-all focus:border-brand-gold focus:ring-brand-gold"
                    :class="{ 'border-red-300 focus:border-red-500 focus:ring-red-500': form.errors.message }"></textarea>
                <p v-if="form.errors.message" class="text-xs font-medium text-red-600">{{ form.errors.message }}</p>
            </div>

            <button type="submit" :disabled="form.processing"
                class="group relative flex w-full items-center justify-center gap-2 overflow-hidden rounded-lg bg-brand-maroon px-6 py-3.5 text-sm font-bold text-white shadow-xl transition-all hover:bg-brand-maroon-dark active:scale-[0.98] disabled:opacity-70">
                <span class="relative z-10">{{ translations.contactus }}</span>
                <svg v-if="form.processing" class="h-4 w-4 animate-spin text-white" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <svg v-else class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </div>
</template>