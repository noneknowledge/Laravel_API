<script setup>
import SettingMember from '../components/SettingMember.vue'
import SettingProject from '../components/SettingProject.vue'
import LoadingSnippet from '../components/LoadingSnippet.vue'
import { useRoute } from 'vue-router'
import { ref, watch, inject } from 'vue'
import axios from 'axios'
import { customCache } from '../stores/'

const route = useRoute()
const key = ref(`/setting/${route.params.id}`)
const [token, setToken] = inject('token')
const URL = inject('url') + key.value
const curTab = ref()
const projectSetting = ref()
const isLoading = ref(true)

const fetcher = async () => {
    console.log('fetcher! ')
    try {
        const res = await axios.get(URL, {
            headers: { Authorization: `Bearer ${token.value.access_token}` }
        })
        return res.data
    } catch (e) {
        if (e.message.includes('401')) {
            alert('Login session expired')
            setToken(undefined)
        }
        console.warn(e)
        return undefined
    }
}

customCache(key.value, fetcher)
    .then((res) => {
        isLoading.value = false
        console.log(res)
        projectSetting.value = res
    })
    .catch((err) => console.warn(err))

watch(
    () => route.params.id,
    () => {
        isLoading.value = true
        key.value = `/setting/${route.params.id}`
        customCache(key.value, fetcher)
            .then((res) => {
                isLoading.value = false
                console.log(res)
                projectSetting.value = res
            })
            .catch((err) => console.warn(err))
    }
)
</script>
<template>
    <div>
        <Transition
            ><section class="position-absolute" v-show="isLoading">
                Loading...<LoadingSnippet /></section
        ></Transition>
        <div v-if="!isLoading" class="container">
            <h2 class="text-center">Setting</h2>

            <nav class="ps-4 d-flex gap-5">
                <h3
                    @click="curTab = 'member'"
                    :class="[curTab === 'member' ? 'active-tab' : 'inactive-tab']"
                    class="rounded-top p-3"
                >
                    Member
                </h3>
                <h3
                    @click="curTab = 'detail'"
                    :class="[curTab === 'detail' ? 'active-tab' : 'inactive-tab']"
                    class="rounded-top p-3"
                >
                    Project detail
                </h3>
            </nav>

            <section class="border rounded" style="min-height: 60vh">
                <div v-if="projectSetting">
                    <h2 class="text-center">Main content</h2>
                    <SettingMember v-if="curTab === 'member'"></SettingMember>
                    <SettingProject v-if="curTab === 'detail'"></SettingProject>
                </div>
                <div v-else>Error!</div>
            </section>
        </div>
    </div>
</template>

<style scoped>
.inactive-tab {
    border: 2px solid black;
    background-color: gray;
    color: white;
}
.inactive-tab:hover {
    scale: 1.1;
    background-color: #4b70f5;
}
.active-tab {
    background-color: white;
    border-top: 5px solid green;
    border-right: 2px solid green;
    border-left: 2px solid green;
    scale: 1.3;
    font-style: none;
    font-style: italic;
    font-weight: normal;
    text-decoration: underline;
}
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
