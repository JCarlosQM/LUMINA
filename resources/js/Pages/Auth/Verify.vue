<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{ email: string }>();
const page = usePage();
const status = computed(() => (page.props.status as string | null) ?? null);

const form = useForm({
    email: props.email,
    code: '',
});

const resendForm = useForm({
    email: props.email,
});

function submit(): void {
    form.post('/verificar');
}

function resend(): void {
    resendForm.post('/reenviar-codigo', { preserveScroll: true });
}
</script>

<template>
    <main class="flex min-h-screen flex-col items-center justify-center bg-stone-100 px-6 py-12">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            <h1 class="text-2xl font-bold text-stone-900">Verifica tu correo</h1>
            <p class="mt-1 text-sm text-stone-600">
                Hemos enviado un código de 6 dígitos a <strong>{{ form.email || 'tu correo' }}</strong
                >. Caduca en 10 minutos.
            </p>

            <p v-if="status" class="mt-4 rounded bg-emerald-50 p-3 text-sm text-emerald-800">{{ status }}</p>

            <form class="mt-6 space-y-4" @submit.prevent="submit">
                <div>
                    <label class="text-sm font-medium text-stone-700" for="code">Código de 6 dígitos</label>
                    <input
                        id="code"
                        v-model="form.code"
                        type="text"
                        inputmode="numeric"
                        autocomplete="one-time-code"
                        maxlength="6"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2 tracking-widest"
                    />
                    <p v-if="form.errors.code" class="mt-1 text-sm text-red-700">{{ form.errors.code }}</p>
                </div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded bg-stone-900 px-4 py-2 font-semibold text-white disabled:opacity-50"
                >
                    Verificar
                </button>
            </form>

            <div class="mt-4 text-center">
                <button
                    type="button"
                    :disabled="resendForm.processing"
                    class="text-sm font-semibold text-stone-900 underline disabled:opacity-50"
                    @click="resend"
                >
                    Reenviar código
                </button>
                <p v-if="resendForm.errors.email" class="mt-1 text-sm text-red-700">{{ resendForm.errors.email }}</p>
            </div>
        </div>
    </main>
</template>
