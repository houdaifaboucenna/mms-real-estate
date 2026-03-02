<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref, computed } from 'vue';
import { Icon } from '@iconify/vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const isEn = computed(() => usePage().props.locale === 'en');

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};

const translations = {
    title: isEn.value ? 'Danger Zone' : 'منطقة الخطر',
    desc: isEn.value ? 'Once your account is deleted, all of its data will be permanently lost. This action is irreversible.' : 'بمجرد حذف حسابك، ستفقد جميع بياناته نهائيًا. هذا الإجراء غير قابل للتراجع.',
    delete_btn: isEn.value ? 'Delete My Account' : 'حذف حسابي',
    modal_title: isEn.value ? 'Are you absolutely sure?' : 'هل أنت متأكد تمامًا؟',
    modal_desc: isEn.value ? 'Please enter your password to confirm you want to permanently delete your account.' : 'يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف حسابك نهائيًا.',
    password: isEn.value ? 'Current Password' : 'كلمة المرور الحالية',
    cancel: isEn.value ? 'Cancel' : 'إلغاء',
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-2xl bg-red-100 flex items-center justify-center text-red-600">
                    <Icon icon="carbon:warning-alt" class="text-2xl" />
                </div>
                <h2 class="text-2xl font-black text-red-600 tracking-tight">
                    {{ translations.title }}
                </h2>
            </div>

            <p class="text-sm font-medium text-gray-500 max-w-xl">
                {{ translations.desc }}
            </p>
        </header>

        <button @click="confirmUserDeletion"
            class="inline-flex items-center gap-3 px-8 py-3 rounded-2xl bg-white border-2 border-red-100 text-red-600 text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white hover:border-red-600 transition-all active:scale-95 group shadow-sm hover:shadow-red-200">
            <Icon icon="carbon:trash-can" class="text-lg" />
            {{ translations.delete_btn }}
        </button>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-10 md:p-12">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-14 w-14 rounded-3xl bg-red-50 flex items-center justify-center text-red-600">
                        <Icon icon="carbon:security-warning" class="text-3xl" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-black text-brand-maroon tracking-tight">
                            {{ translations.modal_title }}
                        </h2>
                        <p class="text-xs font-medium text-gray-500 mt-1">
                            {{ translations.modal_desc }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <InputLabel for="password" :value="translations.password"
                        class="text-[10px] font-black uppercase tracking-widest text-brand-maroon/30" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="block w-full border-gray-100 focus:ring-red-500 focus:border-red-500 bg-gray-50/30 rounded-2xl"
                        :placeholder="translations.password" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-10 flex justify-end gap-3">
                    <SecondaryButton @click="closeModal"
                        class="rounded-xl border-gray-100 text-gray-500 hover:bg-gray-50">
                        {{ translations.cancel }}
                    </SecondaryButton>

                    <button :disabled="form.processing" @click="deleteUser"
                        class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-red-600 text-white text-xs font-black uppercase tracking-widest hover:bg-red-700 transition-all active:scale-95 disabled:opacity-25">
                        <Icon icon="carbon:trash-can" class="text-lg" />
                        {{ translations.delete_btn }}
                    </button>
                </div>
            </div>
        </Modal>
    </section>
</template>
