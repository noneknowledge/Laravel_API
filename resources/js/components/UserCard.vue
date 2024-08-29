<script setup>
import axios from 'axios'
import { inject } from 'vue'
const props = defineProps({
    user: undefined
})
const [token, setToken] = inject('token')
const URL = inject('url')
const addFriend = (uid) => {
    axios
        .post(
            URL + '/user',
            { userid: uid },
            {
                headers: {
                    Authorization: `Bearer ${token.value.access_token}`
                }
            }
        )
        .then((res) => {
            alert(res.data.msg)
        })
        .catch((err) => {
            if (err.message.includes('401')) {
                alert('Token expired, please log in')
                setToken(undefined)
            } else {
                alert(err.response.data.msg)
            }
        })
}
const chat = () => {
    console.log('chat')
}
</script>
<template>
    <section class="w-100 px-4 py-5 rounded" style="background-color: #9de2ff">
        <div class="row d-flex justify-content-center">
            <div class="col col-md-9 col-lg-7 col-xl-6">
                <div class="card" style="border-radius: 15px">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0">
                                <img
                                    src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1722211200&semt=ais_hybrid"
                                    alt="Generic placeholder image"
                                    class="img-fluid cursor-pointer"
                                    style="width: 180px; border-radius: 10px"
                                />
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">{{ user.fullname }}</h5>
                                <p class="mb-2 pb-1">{{ user.email }}</p>
                                <div
                                    class="d-flex justify-content-start rounded-3 p-2 mb-2 bg-body-tertiary"
                                >
                                    <div>
                                        <p class="small text-muted mb-1">Project</p>
                                        <p class="mb-0">41</p>
                                    </div>
                                    <div class="px-3">
                                        <p class="small text-muted mb-1">Friend</p>
                                        <p class="mb-0">976</p>
                                    </div>
                                </div>
                                <div class="d-flex pt-1">
                                    <button
                                        type="button"
                                        @click="chat"
                                        class="btn btn-outline-primary me-1 flex-grow-1"
                                    >
                                        Chat
                                    </button>
                                    <button
                                        type="button"
                                        @click="addFriend(user.id)"
                                        class="btn btn-primary flex-grow-1"
                                    >
                                        Add friend
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
