<script setup lang="ts">
import axios from 'axios'
import { ref } from 'vue'
import { useToken } from '../stores/'

const data = ref()
const isError = ref()
const [token, setToken] = useToken()

const fetchData = () => {
    const res = axios
        .get(`http://localhost:8000/api`, {
            headers: {
                Authorization: `Bearer ${token.value}`
            }
        })
        .then((res) => (data.value = res.data))
        .catch((e) => (data.value = e.message))
}

fetchData()
</script>

<template>
    <h1>{{ data }}</h1>
</template>
