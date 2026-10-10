<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const appName = 'Lumina';
const tagline = 'Descubre lo esencial. Vive lo auténtico.';
</script>

<template>
    <main class="flex min-h-screen flex-col items-center justify-center gap-4 bg-stone-100 px-6 text-center">
        <p class="text-xs font-semibold uppercase tracking-widest text-stone-500">Base técnica en construcción</p>
        <h1 class="text-4xl font-bold text-stone-900">{{ appName }}</h1>
        <p class="max-w-md text-stone-600">{{ tagline }}</p>
        <nav class="mt-2 flex gap-3 text-sm">
            <Link href="/registro" class="rounded bg-stone-900 px-4 py-2 font-semibold text-white">Registrarse</Link>
            <Link href="/entrar" class="rounded border border-stone-300 px-4 py-2">Entrar</Link>
        </nav>
    </main>
</template>
