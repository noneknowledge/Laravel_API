<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import ErrorNoti from '../components/ErrorNoti.vue'
import { useRouter, RouterLink } from 'vue-router'
import { useToken } from '../stores/'

const [token, setToken] = useToken()
const router = useRouter()

setToken(undefined)

const error = ref()

const postLogin = (event) => {
    const formData = new FormData(event.currentTarget)
    axios
        .post('http://localhost:8000/api/login', formData)
        .then((res) => {
            const { data } = res
            setToken(data)
            router.push('/')
        })
        .catch((err) => {
            error.value = err.response.data.message
            console.log('fail')
        })
}
watch(
    () => error.value,
    () => {
        setTimeout(() => {
            error.value = undefined
        }, 10000)
    }
)
</script>
<template>
    <span v-if="error"><ErrorNoti :msg="error"></ErrorNoti></span>
    <span v-if="token">{{ token }}</span>
    <section class="vh-100" style="background-color: #9a616d">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img
                                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img1.webp"
                                    alt="login form"
                                    class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem"
                                />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form @submit.prevent="postLogin">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <i
                                                class="fas fa-cubes fa-2x me-3"
                                                style="color: #ff6219"
                                            ></i>
                                            <span class="h1 fw-bold mb-0">Logo</span>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px">
                                            Sign into your account
                                        </h5>

                                        <div class="form-outline mb-4">
                                            <input
                                                required
                                                name="username"
                                                type="text"
                                                id="username"
                                                class="form-control form-control-lg"
                                            />
                                            <label class="form-label" for="username"
                                                >Email address</label
                                            >
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input
                                                required
                                                name="password"
                                                type="password"
                                                id="password"
                                                class="form-control form-control-lg"
                                            />
                                            <label class="form-label" for="password"
                                                >Password</label
                                            >
                                        </div>

                                        <div class="pt-1 mb-4">
                                            <button
                                                class="btn btn-dark btn-lg btn-block"
                                                type="submit"
                                            >
                                                Login
                                            </button>
                                        </div>

                                        <p class="mb-5 pb-lg-2" style="color: #393f81">
                                            Don't have an account?
                                            <RouterLink to="/register" style="color: #393f81"
                                                >Register here</RouterLink
                                            >
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
