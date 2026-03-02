<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Icon } from '@iconify/vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    faq: {
        type: Object,
        default: null,
    },
    translations: Object,
});

const form = useForm({
    id: props.faq?.id || null,
    question: props.faq?.question || '',
    question_ar: props.faq?.question_ar || '',
    answer: props.faq?.answer || '',
    answer_ar: props.faq?.answer_ar || '',
    show_home: props.faq ? !!props.faq.show_home : false,
});

const activeLang = ref('en'); // en, ar

const submit = () => {
    if (props.faq) {
        form.put(route('faq.update', props.faq.id), {
            onSuccess: () => {
                // Handle success if needed
            },
        });
    } else {
        form.post(route('faq.store'), {
            onSuccess: () => {
                // Handle success if needed
            },
        });
    }
};
</script>

<template>

    <Head :title="faq ? translations.edit_question : translations.add_question" />

    <AuthenticatedLayout :title="faq ? translations.edit_question : translations.add_question">
        <template #content>
            <div class="max-w-4xl mx-auto space-y-8 animate-fade-in-down pb-20">
                <!-- Header -->
                <div
                    class="flex items-center justify-between bg-white/50 backdrop-blur-md p-8 rounded-[40px] shadow-sm ring-1 ring-gray-100/50">
                    <div>
                        <h1 class="text-3xl font-extrabold text-brand-maroon tracking-tight">
                            {{ faq ? translations.edit_question : translations.add_question }}
                        </h1>
                        <p class="text-sm font-medium text-gray-500 mt-1">
                            {{ faq ?
                                (isEn ? 'Update your existing question and answer.' : 'تحديث السؤال والجواب الحالي.') :
                                (isEn ? 'Create a new question and answer for your FAQ section.'
                                    : 'إنشاء سؤال وجواب جديد لقسم الأسئلة الشائعة.') }}
                        </p>
                    </div>
                    <Link :href="route('faq.index')"
                        class="flex items-center text-sm font-bold text-gray-400 hover:text-brand-maroon transition-colors group">
                        <Icon icon="carbon:arrow-left" class="mr-2 group-hover:-translate-x-1 transition-transform" />
                        {{ isEn ? 'Back to List' : 'العودة للقائمة' }}
                    </Link>
                </div>

                <form @submit.prevent="submit" class="space-y-8">
                    <!-- Main Content Panel -->
                    <div class="bg-white rounded-[40px] p-10 shadow-xl shadow-gray-200/50 ring-1 ring-gray-100">
                        <!-- Lang and Settings Row -->
                        <div class="flex items-center justify-between mb-10 pb-6 border-b border-gray-50">
                            <div class="flex items-center gap-2 bg-gray-50 p-1.5 rounded-2xl w-fit">
                                <button type="button" @click="activeLang = 'en'"
                                    :class="['px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all', activeLang === 'en' ? 'bg-white text-brand-maroon shadow-sm' : 'text-gray-400 hover:text-gray-600']">
                                    {{ translations.en }}
                                </button>
                                <button type="button" @click="activeLang = 'ar'"
                                    :class="['px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all', activeLang === 'ar' ? 'bg-white text-brand-maroon shadow-sm' : 'text-gray-400 hover:text-gray-600']">
                                    {{ translations.ar }}
                                </button>
                            </div>

                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <span class="text-[10px] font-black text-brand-maroon/40 uppercase tracking-widest">
                                        {{ translations.show_home }}
                                    </span>
                                    <div class="relative inline-flex items-center h-6 w-11 rounded-full p-1 transition-colors duration-200 ease-in-out focus:outline-none"
                                        :class="form.show_home ? 'bg-emerald-500' : 'bg-gray-200'"
                                        @click="form.show_home = !form.show_home">
                                        <span
                                            class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform duration-200 ease-in-out"
                                            :class="form.show_home ? 'translate-x-[20px]' : 'translate-x-0'"></span>
                                    </div>
                                    <input type="checkbox" v-model="form.show_home" class="sr-only">
                                </label>
                            </div>
                        </div>

                        <!-- Tab: English -->
                        <div v-show="activeLang === 'en'" class="space-y-8 animate-fade-in">
                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-2 text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em] ml-2">
                                    <Icon icon="carbon:help-desk" class="text-lg text-brand-gold" />
                                    {{ translations.question }} (EN)
                                </label>
                                <input v-model="form.question" type="text" required
                                    class="w-full px-8 py-5 rounded-[24px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                    :placeholder="isEn ? 'Enter the question in English...' : 'أدخل السؤال بالإنجليزية...'">
                                <div v-if="form.errors.question"
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">
                                    {{ form.errors.question }}
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-2 text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em] ml-2">
                                    <Icon icon="carbon:document-view" class="text-lg text-brand-gold" />
                                    {{ translations.answer }} (EN)
                                </label>
                                <textarea v-model="form.answer" rows="8" required
                                    class="w-full px-8 py-5 rounded-[32px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-medium text-gray-600 leading-relaxed shadow-inner"
                                    :placeholder="isEn ? 'Provide the detailed answer in English...' : 'أدخل الإجابة المفصلة بالإنجليزية...'"></textarea>
                                <div v-if="form.errors.answer"
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-1 ml-2">
                                    {{ form.errors.answer }}
                                </div>
                            </div>
                        </div>

                        <!-- Tab: Arabic -->
                        <div v-show="activeLang === 'ar'" class="space-y-8 animate-fade-in text-right" dir="rtl">
                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-2 text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em] mr-2">
                                    <Icon icon="carbon:help-desk" class="text-lg text-brand-gold scale-x-[-1]" />
                                    {{ translations.question }} (AR)
                                </label>
                                <input v-model="form.question_ar" type="text" required
                                    class="w-full px-8 py-5 rounded-[24px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-bold text-gray-700 shadow-inner"
                                    :placeholder="isEn ? 'Enter the question in Arabic...' : 'أدخل السؤال بالعربية...'">
                                <div v-if="form.errors.question_ar"
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-1 mr-2">
                                    {{ form.errors.question_ar }}
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label
                                    class="flex items-center gap-2 text-[10px] font-black text-brand-maroon uppercase tracking-[0.2em] mr-2">
                                    <Icon icon="carbon:document-view" class="text-lg text-brand-gold scale-x-[-1]" />
                                    {{ translations.answer }} (AR)
                                </label>
                                <textarea v-model="form.answer_ar" rows="8" required
                                    class="w-full px-8 py-5 rounded-[32px] bg-gray-50 border-transparent focus:bg-white focus:ring-2 focus:ring-brand-gold/30 focus:border-brand-gold transition-all text-sm font-medium text-gray-600 leading-relaxed shadow-inner font-arabic"
                                    :placeholder="isEn ? 'Provide the detailed answer in Arabic...' : 'أدخل الإجابة المفصلة بالعربية...'"></textarea>
                                <div v-if="form.errors.answer_ar"
                                    class="text-red-500 text-[10px] font-black uppercase tracking-widest mt-1 mr-2">
                                    {{ form.errors.answer_ar }}
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-12 pt-10 border-t border-gray-50 flex items-center justify-end gap-4">
                            <button type="submit" :disabled="form.processing"
                                class="flex items-center justify-center gap-3 px-12 py-5 rounded-[24px] bg-brand-maroon text-white font-black uppercase tracking-widest shadow-xl shadow-brand-maroon/20 hover:bg-brand-maroon/90 hover:-translate-y-1 active:scale-95 transition-all text-sm disabled:opacity-50 group">
                                <Icon v-if="form.processing" icon="line-md:loading-twotone-loop" class="text-xl" />
                                <Icon v-else :icon="faq ? 'carbon:save' : 'carbon:add-alt'"
                                    class="text-xl group-hover:rotate-12 transition-transform" />
                                {{ faq ? translations.update : translations.add }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in-down {
    animation: fade-in-down 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-fade-in {
    animation: fade-in 0.4s ease-out forwards;
}

@keyframes fade-in-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

textarea {
    resize: none;
}
</style>
