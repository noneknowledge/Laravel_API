<script setup>
import ProjectCard from '../components/ProjectCard.vue'
import PopProject from '../components/PopProject.vue'
import { useToken } from '../stores/'
import axios from 'axios'
import { ref } from 'vue'

const data = ref([1, 2, 3, 4, 5])
const [token, setToken] = useToken()
console.log(token.value)
const URL = import.meta.env.VITE_API_URL + '/project'

const handleChildProject = (newProject) => {
    data.value.push(newProject)
    axios
        .post(URL, newProject, {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        .then((res) => console.log(res))
        .catch((err) => {
            if (err.message.includes('401')) {
                alert('User session expired')
            } else {
                console.warn(err.response)
            }
        })
}
</script>

<template>
    <div style="background-color: #b3c8cf">
        <div class="container">
            <div class="text-center py-2">
                <PopProject @addProject="handleChildProject" />
            </div>
            <div class="row d-flex justify-content-center gap-5">
                <ProjectCard v-for="project in data.length" />
            </div>
        </div>
    </div>
</template>
