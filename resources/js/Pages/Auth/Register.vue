<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const status = computed(() => (page.props.status as string | null) ?? null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit(): void {
    form.post('/registro');
}
</script>

<template>
    <main class="flex min-h-screen flex-col items-center justify-center bg-stone-100 px-6 py-12">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            <h1 class="text-2xl font-bold text-stone-900">Crear cuenta</h1>
            <p class="mt-1 text-sm text-stone-600">Te enviaremos un código de 6 dígitos para verificar tu correo.</p>

            <p v-if="status" class="mt-4 rounded bg-emerald-50 p-3 text-sm text-emerald-800">{{ status }}</p>

            <form class="mt-6 space-y-4" @submit.prevent="submit">
                <div>
                    <label class="text-sm font-medium text-stone-700" for="name">Nombre</label>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        autocomplete="name"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2"
                    />
                    <p v-if="form.errors.name" class="mt-1 text-sm text-red-700">{{ form.errors.name }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-stone-700" for="email">Correo</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2"
                    />
                    <p v-if="form.errors.email" class="mt-1 text-sm text-red-700">{{ form.errors.email }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-stone-700" for="password">Contraseña</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2"
                    />
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-700">{{ form.errors.password }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-stone-700" for="password_confirmation">
                        Confirmar contraseña
                    </label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2"
                    />
                </div>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded bg-stone-900 px-4 py-2 font-semibold text-white disabled:opacity-50"
                >
                    Registrarse
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-stone-600">
                ¿Ya tienes cuenta? <Link href="/entrar" class="font-semibold text-stone-900">Entrar</Link>
            </p>
        </div>
    </main>
</template>
