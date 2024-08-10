<script setup>
import ProjectCard from '../components/ProjectCard.vue'
import PopProject from '../components/PopProject.vue'
import { useToken } from '../stores/'
import axios from 'axios'
import { ref } from 'vue'
import { customCache, clearKey } from '../stores/'

const [token, setToken] = useToken()
const URL = import.meta.env.VITE_API_URL + '/project'
const testD = ref(0)
const cacheClearKey = clearKey
console.log('Clear key ')
console.log(cacheClearKey.value)

const fetcher = async () => {
    console.log('fetcher run')
    const res = await axios.get(URL, { headers: { Authorization: `Bearer ${token.value}` } })
    const data = res.data.data
    return data
}

const cache = customCache('workSpace', fetcher, testD).then((res) => {
    console.log('Success')
    console.log(res)
})

const data = ref()

// const fetchData = () => {
//     axios
//         .get(URL, { headers: { Authorization: `Bearer ${token.value}` } })
//         .then((res) => {
//             data.value = res.data.data
//             console.log(res.data.data)
//         })
//         .catch((err) => {
//             console.log(err)
//             if (err.message.includes('401')) {
//                 alert('User session expired')
//                 setToken(undefined)
//             }
//         })
// }

// fetchData()

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
            <h1>{{ cacheClearKey }}</h1>
            <button @click="cacheClearKey++">Increase</button>
            <div class="row d-flex justify-content-center gap-5">
                <ProjectCard v-for="project in data" :project="project" />
            </div>
        </div>
    </div>
</template>
