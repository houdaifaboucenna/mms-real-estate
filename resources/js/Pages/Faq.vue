<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();
const isEn = computed(() => page.props.locale === 'en');

const props = defineProps({
    translations: Object,
    faqs: Array,
});

const accordion = ref(null);

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
});
</script>

<template>

    <Head :title="translations.faq" />

    <AppLayout>
        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 rounded-lg relative" style="background-color: #ffffffd5;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="col-span-2">
                    <!-- FAQ -->
                    <div class="flex flex-col gap-4" id="faq-row">
                        <h2 class="text-3xl font-bold">{{ translations.faq }}</h2>

                        <div class="flex flex-col gap-4">
                            <div class="bg-white rounded-lg" v-for="faq in faqs" :key="faq.id">
                                <div class="card-header" role="tab">
                                    <h5>
                                        <button @click="accordion === faq.id ? accordion = null : accordion = faq.id">
                                            <span class="iconify" data-icon="bi:bookmark-plus"></span>
                                            {{ isEn ? faq.question : faq.question_ar }}
                                        </button>
                                    </h5>
                                </div>
                                <div v-show="accordion === faq.id" role="tabpanel">
                                    <div class="card-body">
                                        {{ isEn ? faq.answer : faq.answer_ar }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1">

                    <!-- Contact Form -->
                    <form @submit.prevent="form.post(route('contacts.store'))" id="c-form" class="text-center">

                        <!-- Show success message-->
                        <div class="alert alert-success" role="alert" v-if="page.props.flash.success">
                            {{ page.props.flash.success }}
                        </div>

                        <h3>{{ translations.getin }}</h3>
                        <p>{{ translations.fillin }}</p>

                        <div class="form-group">
                            <input class="form-control" type="text" v-model="form.name"
                                :placeholder="translations.name">
                            <span v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="email" v-model="form.email"
                                :placeholder="translations.email">
                            <span v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</span>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="tel" v-model="form.phone"
                                :placeholder="translations.phone">
                            <span v-if="form.errors.phone" class="text-danger">{{ form.errors.phone }}</span>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control" v-model="form.message" rows="4"
                                :placeholder="translations.message"></textarea>
                            <span v-if="form.errors.message" class="text-danger">{{ form.errors.message }}</span>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ translations.contactus }}</button>

                    </form>

                </div>
            </div>
        </div>
    </AppLayout>

</template>

<style scoped></style>
