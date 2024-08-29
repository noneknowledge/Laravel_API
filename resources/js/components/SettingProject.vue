<script setup>
import ConfirmDialog from './ConfirmDialog.vue'
import { ref, inject } from 'vue'
import axios from 'axios'
import { headerConfig } from '../stores/'
import { useRouter } from 'vue-router'

const props = defineProps({
    project: undefined,
    userid: Number
})
const clicked = ref(false)

const URL = inject('url')

const router = useRouter()

const deleteBtn = () => {
    clicked.value = !clicked.value
    axios
        .delete(`${URL}/project/${props.project.id}`, headerConfig)
        .then((res) => {
            router.push('/workspace')
        })
        .catch((err) => {
            if (err.message.includes('401')) {
                alert('Login session expired')
                router.push('/login')
            }
        })
}
const editBtn = () => {
    alert("Haven't done this feature yet")
}
</script>
<template>
    <ConfirmDialog
        @confirmClicked="deleteBtn"
        :click="clicked"
        :title="project.title"
        msg="This action will destroy all information of this project and cannot reverse this action"
    />
    <div class="p-5 font-lg">
        <div class="pb-3">
            <i>Project name:</i> {{ project.title }} <br />
            <i>Leader:</i> {{ project.leader.fullname }}
            <button v-if="userid === project.leader.id" class="btn disabled btn-success mx-3">
                You
            </button>
            <br />
            <i>Description:</i> We do not have a field for project description yet
        </div>
        <hr class="p-2" />
        <div class="p-4 border rounded border-danger" style="min-height: 50vh">
            <h4 class="text-center text-danger">Danger area</h4>
            Delete project:
            <button
                @click="
                    () => {
                        clicked = !clicked
                    }
                "
                class="btn btn-danger form-control font-lg"
            >
                Delete
            </button>
            Edit project:
            <button @click="editBtn" class="btn btn-info form-control font-lg">Edit</button>
        </div>
    </div>
</template>
<style scoped></style>
