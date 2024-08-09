<script setup>
import { ref, onMounted } from 'vue'
import TaskCard from './TaskCard.vue'

const props = defineProps({
    index: Number,
    drake: undefined,
    Column: undefined,
    id: Number
})
const emits = defineEmits(['editName'])

const input = ref(props.Column.col)
const editCol = ref()
const dragCont = ref()

const editName = (e) => {
    var newName = e.target.value
    if (newName) {
        var editV = { id: editCol.value, newName }
        editCol.value = undefined
        emits('editName', editV)
    } else {
        alert('please enter new column name')
    }
}

onMounted(() => {
    props.drake.containers.push(dragCont.value)
})
</script>

<template>
    <div class="border rounded p-2" style="min-width: 40vh; background-color: #17153b">
        <h5 style="background-color: #2e236c" class="text-center p-2 border border-white rounded">
            <input
                v-if="editCol === Column.id"
                type="text"
                v-model="input"
                @keyup.enter="editName"
                class="form-control px-4"
                placeholder="Edit column name"
            />
            <span v-else class="cursor-pointer" @click="editCol = Column.id" style="color: #c8acd6">
                {{ Column.col }}</span
            >
        </h5>

        <div ref="dragCont" style="height: 70vh" class="overflow-auto" :data-value="index">
            <h6
                v-for="task in Column.tasks"
                :data-value="JSON.stringify(task)"
                class="border bg-success d-flex text-white p-2 text-center justify-content-center align-items-center"
            >
                <TaskCard :task="task" />
            </h6>
        </div>
    </div>
</template>
