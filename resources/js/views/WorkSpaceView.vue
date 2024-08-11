<script setup>
import ProjectCard from '../components/ProjectCard.vue'
import PopProject from '../components/PopProject.vue'
import axios from 'axios'
import { ref, inject } from 'vue'
import { customCache, clearKey } from '../stores/'

const [token, setToken] = inject('token')
const URL = import.meta.env.VITE_API_URL + '/project'
const cacheClearKey = clearKey
const key = 'workSpace'
const fetcher = async () => {
    console.log('fetcher run')
    try {
        const res = await axios.get(URL, { headers: { Authorization: `Bearer ${token.value}` } })
        const data = res.data.data
        return data
    } catch (e) {
        if (e.message.includes('401')) {
            alert('Login session expired')
            setToken(undefined)
        }
        console.warn(e)
        return undefined
    }
}
const data = ref()
customCache(key, fetcher).then((res) => {
    data.value = res
})

const handleChildProject = (newProject) => {
    axios
        .post(URL, newProject, {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        .then((res) => {
            // cacheClearKey.value = key
            data.value.push(res.data.data)
        })
        .catch((err) => {
            if (err.message.includes('401')) {
                alert('User session expired')
                setToken(undefined)
            } else {
                console.warn(err.response)
            }
        })
}
</script>

<template>
    <div style="background-color: #b3c8cf; min-height: 90vh">
        <div class="container">
            <div class="text-center py-2">
                <PopProject @addProject="handleChildProject" />
            </div>

            <div class="row d-flex justify-content-center gap-5">
                <ProjectCard v-for="project in data" :project="project" />
            </div>
        </div>
    </div>
</template>
