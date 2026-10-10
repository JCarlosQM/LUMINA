<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit(): void {
    form.post('/entrar');
}
</script>

<template>
    <main class="flex min-h-screen flex-col items-center justify-center bg-stone-100 px-6 py-12">
        <div class="w-full max-w-md rounded-xl bg-white p-8 shadow">
            <h1 class="text-2xl font-bold text-stone-900">Entrar</h1>
            <p class="mt-1 text-sm text-stone-600">Accede con tu correo y contraseña.</p>

            <form class="mt-6 space-y-4" @submit.prevent="submit">
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
                        autocomplete="current-password"
                        class="mt-1 w-full rounded border border-stone-300 px-3 py-2"
                    />
                    <p v-if="form.errors.password" class="mt-1 text-sm text-red-700">{{ form.errors.password }}</p>
                </div>
                <label class="flex items-center gap-2 text-sm text-stone-700">
                    <input v-model="form.remember" type="checkbox" /> Recuérdame
                </label>
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full rounded bg-stone-900 px-4 py-2 font-semibold text-white disabled:opacity-50"
                >
                    Entrar
                </button>
            </form>

            <p class="mt-4 text-center text-sm text-stone-600">
                ¿Sin cuenta? <Link href="/registro" class="font-semibold text-stone-900">Registrarse</Link>
            </p>
        </div>
    </main>
</template>
