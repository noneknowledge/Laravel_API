<script setup>
import UserCard from '../components/UserCard.vue'
import axios from 'axios'
import { ref, watch, inject } from 'vue'
import { useRoute } from 'vue-router'

const users = ref([])
const route = useRoute()
const isLoading = ref(true)

const URL = inject('url')
const searchUser = (value) => {
    users.value = []
    isLoading.value = true
    axios
        .get(`${URL}/search/${value}`)
        .then((res) => {
            isLoading.value = false
            var data = res.data.data
            if (data) {
                users.value = data
            } else {
                users.value = []
            }
        })
        .catch((e) => {
            console.log(e)
        })
}
searchUser(route.params.keyword)
watch(
    () => route.params.keyword,
    () => {
        searchUser(route.params.keyword)
    }
)
</script>
<template>
    <div style="background-color: #b3c8cf; min-height: 90vh">
        <div class="container p-1">
            <hr />
            <div v-if="isLoading">
                <h1 class="text-center">Loading...</h1>
            </div>
            <div v-else>
                <UserCard class="m-2" v-if="users.length > 0" v-for="user in users" :user="user" />
                <div v-else>
                    <h1 class="text-center">User not found ! &#128531;</h1>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
hr {
    border-top: 1px dashed;
}
</style>
