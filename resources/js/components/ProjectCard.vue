<script setup>
import { useRouter } from 'vue-router'
const props = defineProps({
    project: undefined
})
const router = useRouter()

const goToProject = () => {
    router.push(`/project/${props.project.id}`)
}
</script>

<template>
    <div class="card px-0" style="width: 40vh">
        <img
            @click="goToProject"
            class="card-img-top cursor-pointer"
            src="https://t4.ftcdn.net/jpg/04/83/93/81/360_F_483938185_LeH5ySfRClEUKNbbSDVO4196v8H8ZRoS.jpg"
            style="width: 20vh, height:20vh"
            alt="Card image cap"
        />
        <div class="card-body">
            <h5 class="card-title">{{ project.title }}</h5>
            <p class="card-text">
                <i class="text-secondary">Leader: {{ project.leader.fullname }}</i>
                <br />Total member: {{ project.total }}
            </p>
        </div>
    </div>
</template>
