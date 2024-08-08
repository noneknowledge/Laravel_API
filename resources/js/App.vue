<script setup>
import { RouterLink, RouterView } from 'vue-router'
import NavBar from './components/NavBar.vue'
</script>

<template>
    <div class="body-style">
        <NavBar />

        <RouterView />
    </div>
</template>
