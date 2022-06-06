<template>
    <app-layout title="Dashboard">
        <template #header>
                <h4 class="mb-sm-0 font-size-18">Dashboard</h4>
        </template>

        <div class="py-12">
            <h1>Dashboard</h1>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/BackendLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'

export default defineComponent({
    components: {
        AppLayout,
        Welcome,
    },

})
</script>
