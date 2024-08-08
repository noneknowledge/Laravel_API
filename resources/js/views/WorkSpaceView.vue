<script setup>
import ProjectCard from '../components/ProjectCard.vue'
import axios from 'axios'
import { ref } from 'vue'

const data = [1, 2, 3, 4, 5]
</script>

<template>
    <div style="background-color: #b3c8cf">
        <h1 class="text-center">Work space</h1>
        <div class="row d-flex justify-content-center gap-5">
            <ProjectCard v-for="project in data" />
        </div>
    </div>
</template>
