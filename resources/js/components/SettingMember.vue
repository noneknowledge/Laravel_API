<script setup>
import FlagIcon from '../icons/FlagIcon.vue'
import AssignSection from './AssignSection.vue'
import axios from 'axios'
import { ref, inject } from 'vue'

const URL = inject('url')
const props = defineProps({
    myFriends: undefined,
    members: undefined,
    userid: Number,
    ProjectId: undefined
})
const refMember = props.myFriends.filter(
    (friend) => !props.members.some((member) => member.id === friend.id)
)
const canAddMember = ref(refMember)
console.log('Project id: ' + props.ProjectId)
const [token, setToken] = inject('token')
const selectMember = ref([])

const addMember = () => {
    if (selectMember.value.length === 0) {
        alert('No action is needed')
        return
    }
    axios
        .post(
            `${URL}/addMember/${props.ProjectId}`,
            { members: selectMember.value },
            {
                headers: { Authorization: `Bearer ${token.value.access_token}` }
            }
        )
        .then((res) => console.log(res))
        .catch((err) => console.warn(err))
    console.log(URL)
    console.log(selectMember.value)
}

const handleSelectMember = (value) => {
    if (selectMember.value.includes(value.id)) {
        selectMember.value = selectMember.value.filter((member) => member !== value.id)
    } else {
        selectMember.value.push(value.id)
    }
}
</script>
<template>
    <div class="p-5">
        <section class="d-flex">
            <ul class="p-2">
                <li
                    v-for="(user, index) in members"
                    :key="index"
                    class="py-2 cursor-pointer rounded option font-lg d-flex align-items-center gap-3"
                >
                    <FlagIcon v-if="user.role === 'admin'" />
                    <img
                        class="rounded-circle"
                        style="width: 40px; height: 40px"
                        src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1722211200&semt=ais_hybrid"
                    /><span class="px-3 text-capitalize"
                        >{{ user.fullname }}. Role: {{ user.role }}. Id:{{ user.id }}</span
                    ><span class="text-success blink-effect" v-if="user.id === userid"
                        >It's you</span
                    >
                </li>
            </ul>
        </section>
        <hr />
        <section>
            <h2 class="text-center">Add new member</h2>
            <div class="d-flex" :title="selectMember.map((member) => member.fullname)">
                <button @click="addMember" class="m-3 btn btn-outline-success">Confirm</button
                ><br />
                Total new member to add: {{ selectMember.length }}
            </div>

            <AssignSection :members="canAddMember" @clickCheckbox="handleSelectMember" />
        </section>
    </div>
</template>
