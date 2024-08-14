<script setup>
import MyFriend from '../components/MyFriend.vue'
import MyProject from '../components/MyProject.vue'
import { useRoute } from 'vue-router'
import { ref, watch, inject } from 'vue'
import axios from 'axios'

const [token, setToken] = inject('token')
const route = useRoute()
const data = ref()
const URL = inject('url')
const canEdit = ref(false)

const fetchData = (params) => {
    data.value = undefined
    canEdit.value = false
    var path = URL + '/user/' + params
    axios
        .get(path)
        .then((res) => {
            console.log(res.data)
            if (token.value && res.data.user) {
                if (token.value.userid === res.data.user.id) {
                    canEdit.value = true
                }
            }
            data.value = res.data
        })
        .catch((err) => {
            console.warn(err)
        })
}
fetchData(route.params.uid)
watch(
    () => route.params.uid,
    () => {
        fetchData(route.params.uid)
    }
)
</script>
<template>
    <div v-if="data">
        <section v-if="data.user" style="background-color: #eee">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img
                                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                                    alt="avatar"
                                    class="rounded-circle img-fluid"
                                    style="width: 150px"
                                />
                                <h5 class="my-3">{{ data.user.fullname }}</h5>
                                <p class="text-muted mb-3">{{ data.user.email }}</p>
                                <div v-if="canEdit" class="d-flex justify-content-center mb-2">
                                    <button type="button" class="btn btn-outline-primary ms-1">
                                        Edit
                                    </button>
                                </div>
                                <div v-else class="d-flex justify-content-center mb-2">
                                    <button type="button" class="btn btn-primary">
                                        Add friend
                                    </button>
                                    <button type="button" class="btn btn-outline-primary ms-1">
                                        Message
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 mb-lg-0"><MyFriend /></div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ data.user.fullname }}</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">{{ data.user.email }}</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">(097) 234-5678</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Mobile</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">(098) 765-4321</p>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">Bay Area, San Francisco, CA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4 mb-md-0"><MyProject /></div>
                    </div>
                </div>
            </div>
        </section>
        <div v-else>
            <h1 class="text-center">User not found! &#128531;</h1>
        </div>
    </div>
    <div v-else>Loading...</div>
</template>
