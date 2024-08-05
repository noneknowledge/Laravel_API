<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    isClick: Boolean
})

const allTask = [
    { priority: 1, status: 'completed', task: 'Task 1' },
    { priority: 3, status: 'completed', task: 'Task 2' },
    { priority: 2, status: 'incomplete', task: 'Task 3' },
    { priority: 4, status: 'completed', task: 'Task 4' }
]

const tasks = ref(allTask)
const item = ref()
const input = ref()
const editIndex = ref()
const editInput = ref()

const saveChange = (index) => {
    console.log('save')
    tasks.value[index].task = editInput.value

    editIndex.value = undefined
    editInput.value = undefined
}

const addTask = () => {
    if (input.value) {
        tasks.value.push({ task: input.value, priority: 4 })
        input.value = undefined
    } else {
        alert('type in task')
    }
}

const handleCheckbox = (task) => {
    if (task.status === 'incomplete') {
        task.status = 'completed'
    } else {
        task.status = 'incomplete'
    }
}

watch(
    () => props.isClick,
    () => {
        item.value.click()
        editIndex.value = undefined
        editInput.value = undefined
    }
)
</script>

<template>
    <aside>
        <button
            hidden
            ref="item"
            class="btn btn-primary"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseExample"
        >
            Button with data-bs-target
        </button>
        <div class="collapse" style="width: 300px; float: right" id="collapseExample">
            <div class="bg-white rounded p-3 notebook">
                <color-title>Question mark here</color-title>
                <div class="task-class px-3 rounded" v-for="(task, index) in tasks" :key="index">
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <input
                            type="checkbox"
                            :checked="task.status === 'completed'"
                            @click="handleCheckbox(task)"
                            style="zoom: 1.5"
                        />
                        <s v-if="task.status === 'completed'"
                            ><span
                                :class="[editIndex === index ? 'd-none' : '']"
                                class="align-self-center"
                                style="zoom: 1.2"
                            >
                                {{ task.task }}
                            </span>
                            <input
                                @keyup.enter="saveChange(index)"
                                v-model="editInput"
                                :class="[editIndex === index ? '' : 'd-none']"
                                type="text"
                                class="form-control"
                            />
                        </s>
                        <span
                            :class="[
                                task.priority === 4
                                    ? ''
                                    : task.priority === 3
                                      ? 'text-success'
                                      : task.priority === 2
                                        ? 'text-warning'
                                        : 'text-danger'
                            ]"
                            v-else
                            style="zoom: 1.5"
                        >
                            {{ task.task }}
                        </span>
                        <div>
                            <button
                                v-if="editIndex === index"
                                @click="saveChange(index)"
                                class="btn btn-outline-success"
                            >
                                Save
                            </button>
                            <span v-else>
                                <button
                                    class="btn btn-outline-dark hide"
                                    @click="
                                        () => {
                                            editIndex = index
                                            editInput = task.task
                                        }
                                    "
                                >
                                    Edit
                                </button>
                                <button class="btn btn-outline-dark hide">...</button>
                            </span>
                        </div>
                    </div>
                    <hr />
                </div>
                <form @submit.prevent="addTask" class="d-flex gap-3">
                    <input
                        required
                        type="text"
                        v-model="input"
                        class="form-control"
                        placeholder="Add new task"
                    />
                    <button class="btn btn-outline-dark">Add</button>
                </form>
            </div>
        </div>
    </aside>
</template>
<style scope>
.notebook {
    background: url(../../images/notebook2.jpg) no-repeat right bottom;
}

.hide {
    visibility: hidden;
}
.task-class:hover {
    background-color: gray;
    color: white;
}

.task-class:hover .hide {
    visibility: visible;
}
</style>
