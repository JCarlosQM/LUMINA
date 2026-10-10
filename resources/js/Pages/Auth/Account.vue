<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps<{ user: { name: string; email: string; verified: boolean } }>();

const page = usePage();
const status = computed(() => (page.props.status as string | null) ?? null);

const logoutForm = useForm({});

function logout(): void {
    logoutForm.post('/salir');
}
</script>

<template>
    <main class="flex min-h-screen flex-col items-center justify-center bg-stone-100 px-6 py-12">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            <h1 class="text-2xl font-bold text-stone-900">Mi cuenta</h1>

            <p v-if="status" class="mt-4 rounded bg-emerald-50 p-3 text-sm text-emerald-800">{{ status }}</p>

            <dl class="mt-6 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-stone-600">Nombre</dt><dd>{{ user.name }}</dd></div>
                <div class="flex justify-between"><dt class="text-stone-600">Correo</dt><dd>{{ user.email }}</dd></div>
                <div class="flex justify-between">
                    <dt class="text-stone-600">Estado</dt>
                    <dd>{{ user.verified ? 'Verificada' : 'Pendiente' }}</dd>
                </div>
            </dl>

            <div class="mt-6 flex gap-3">
                <Link href="/" class="rounded border border-stone-300 px-4 py-2 text-sm">Inicio</Link>
                <button
                    type="button"
                    :disabled="logoutForm.processing"
                    class="rounded bg-stone-900 px-4 py-2 text-sm font-semibold text-white disabled:opacity-50"
                    @click="logout"
                >
                    Salir
                </button>
            </div>
        </div>
    </main>
</template>
