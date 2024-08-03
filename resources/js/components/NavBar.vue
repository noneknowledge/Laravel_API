<script setup lang="ts">
import { ref } from 'vue'
import MenuIcon from '../icons/MenuIcon.vue'
import GearIcon from '../icons/GearIcon.vue'
import LogInIcon from '../icons/LogInIcon.vue'
import LogOutIcon from '../icons/LogOutIcon.vue'
import ProfileIcon from '../icons/ProfileIcon.vue'
import NotiIcon from '../icons/NotiIcon.vue'
import { useToken } from '../stores/'
import { RouterLink } from 'vue-router'

// const isLogin = ref(false)
const [token, setToken] = useToken()
const isDropdown = ref(false)
</script>

<template>
    <!-- XL menu -->
    <div class="d-none d-md-flex bg-black align-items-center justify-content-between px-5 py-2">
        <div>
            <RouterLink class="btn btn-lg text-white" to="/">Home</RouterLink>
            <RouterLink class="btn btn-lg text-white" to="/new">New</RouterLink>
            <RouterLink class="btn btn-lg text-white" to="/dashboard">Dashboard</RouterLink>
        </div>

        <div class="h4 d-flex justify-content-between position-relative">
            <RouterLink to="/login" v-show="!token" class="btn btn-lg text-white btn-outline-info">
                <LogInIcon /> Log in
            </RouterLink>
            <div v-show="token">
                <button class="btn btn-lg text-white btn-outline-danger mx-2">
                    <NotiIcon /> Notification
                </button>

                <img
                    width="40px"
                    class="cursor-pointer rounded-circle"
                    @click="() => (isDropdown = !isDropdown)"
                    src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1722211200&semt=ais_hybrid"
                />

                <drop-down
                    v-show="isDropdown"
                    class="text-black bg-white dropdown position-absolute rounded p-3"
                >
                    <a class="text-decoration-none" href="/#"
                        ><p class="fs-4 text-black text-center"><ProfileIcon /> Profile</p></a
                    >
                    <hr />
                    <a class="text-decoration-none" href="/#"
                        ><p class="fs-4 text-black text-center"><GearIcon /> Setting</p></a
                    >
                    <hr />
                    <p class="cursor-pointer fs-4 text text-cente" @click="setToken(undefined)">
                        <LogOutIcon /> Log Out
                    </p>
                </drop-down>
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
.dropdown {
    top: 50px;
    right: 10px;
    z-index: 100;
    border: 1px double;
}
</style>
