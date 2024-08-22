<script setup>
import { useRoute } from 'vue-router'
import { ref, inject } from 'vue'
</script>
<template>
    <h2>Edit member view</h2>

    <h1>{{ $route.params.id }}</h1>
</template>
