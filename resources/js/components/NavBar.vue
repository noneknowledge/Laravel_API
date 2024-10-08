<script setup lang="ts">
import { ref, inject } from 'vue'
import MenuIcon from '../icons/MenuIcon.vue'
import GearIcon from '../icons/GearIcon.vue'
import LogInIcon from '../icons/LogInIcon.vue'
import LogOutIcon from '../icons/LogOutIcon.vue'
import ProfileIcon from '../icons/ProfileIcon.vue'
import NotiIcon from '../icons/NotiIcon.vue'
import NoteIcon from '../icons/NoteIcon.vue'
import { RouterLink, useRouter } from 'vue-router'
import ToDo from './ToDo.vue'
import { customDebounce, customThrottle } from '../helper/'
import SearchPrompt from '../components/SearchPrompt.vue'

const [token, setToken] = inject('token')
const isDropdown = ref(false)
const isToDo = ref(false)
const keyword = ref('')
const router = useRouter()
const prompt = ref([])
let interval

const URL = inject('url')
const searchCb = (value) => {
    axios
        .get(`${URL}/prompt/${value}`)
        .then((res) => {
            var data = res.data.data
            if (data) {
                prompt.value = data
            } else {
                prompt.value = []
            }
        })
        .catch((e) => {
            console.log(e)
        })
}
const searchUser = () => {
    prompt.value = []
    router.push(`/search/${keyword.value.trim()}`)
}
const inputchange = () => {
    interval = customDebounce(interval, searchCb, keyword.value.trim(), 200)
}
</script>

<template>
    <!-- XL menu -->
    <div class="d-none d-md-flex bg-black align-items-center justify-content-between px-5 py-2">
        <!-- Left side  -->
        <div>
            <RouterLink class="btn btn-lg text-white" to="/">Home</RouterLink>
            <RouterLink class="btn btn-lg text-white" to="/workspace">Dashboard</RouterLink>
        </div>
        <!-- Left side  -->
        <section class="d-flex">
            <button class="btn btn-success" data-toggle="collapse" data-target="#collapseSearch">
                Search
            </button>
            <form @submit.prevent="searchUser" class="collapse" id="collapseSearch">
                <input
                    required
                    @input="inputchange"
                    v-model="keyword"
                    class="form-control"
                    placeholder="Input user name"
                />
                <SearchPrompt v-if="prompt.length > 0" :users="prompt" />
            </form>
        </section>
        <!-- Right side -->
        <div class="d-flex justify-content-between position-relative">
            <RouterLink to="/login" v-show="!token" class="btn btn-lg text-white btn-outline-info">
                <LogInIcon /> Log in
            </RouterLink>
            <div v-show="token">
                <button class="h4 btn btn-lg text-white btn-outline-danger mx-2">
                    <NotiIcon /> Notification
                </button>

                <img
                    width="40px"
                    class="cursor-pointer rounded-circle"
                    @click="() => (isDropdown = !isDropdown)"
                    src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1722211200&semt=ais_hybrid"
                />

                <!-- Drop down section -->
                <drop-down
                    style="z-index: 20"
                    v-show="isDropdown"
                    class="text-black bg-white offset border position-absolute rounded p-3"
                >
                    <RouterLink
                        v-if="token"
                        class="text-decoration-none"
                        :to="'/profile/' + token.userid"
                        ><p class="fs-4 text-black text-center">
                            <ProfileIcon /> Profile
                        </p></RouterLink
                    >

                    <hr />
                    <a
                        class="text-decoration-none"
                        @click="
                            () => {
                                isToDo = !isToDo
                                isDropdown = !isDropdown
                            }
                        "
                        href="#"
                        ><p class="fs-4 text-black text-center"><NoteIcon />To do list</p></a
                    >
                    <hr />
                    <p class="cursor-pointer fs-4 text text-cente" @click="setToken(undefined)">
                        <LogOutIcon /> Log Out
                    </p>
                </drop-down>
                <!-- Drop down section -->

                <!-- To Do list section -->
                <aside style="z-index: 10" class="position-absolute offset">
                    <ToDo :isClick="isToDo" />
                </aside>
                <!-- To Do list section -->
            </div>
        </div>
    </div>

    <!-- Mobile menu -->

    <div class="text-lg d-md-none bg-secondary d-flex justify-content-between px-5 py-2">
        <MenuIcon />
        mobile menu
    </div>
</template>

<style scoped>
.offset {
    top: 60px;
    right: 10px;
}
</style>
