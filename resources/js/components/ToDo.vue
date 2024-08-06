<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import QuestionIcon from '../icons/QuestionIcon.vue'
import CloseIcon from '../icons/CloseIcon.vue'
import EditIcon from '../icons/EditIcon.vue'
import GearIcon from '../icons/GearIcon.vue'
import { useToken } from '../stores/'
import axios from 'axios'

const props = defineProps({
    isClick: Boolean
})

const router = useRouter()

const [token, setToken] = useToken()

const allTask = [
    { id: 1, priority: 1, status: 'completed', task: 'Task 1' },
    { id: 2, priority: 3, status: 'incomplete', task: 'Task 2' },
    { id: 3, priority: 2, status: 'incomplete', task: 'Task 3' },
    { id: 4, priority: 4, status: 'completed', task: 'Task 4' }
].sort((a, b) => {
    if (a.status === 'completed' && b.status === 'incomplete') {
        return 1
    } else if (b.status === 'completed' && a.status === 'incomplete') {
        return -1
    }

    if (a.priority < b.priority) {
        return -1
    } else if (a.priority > b.priority) {
        return 1
    } else {
        return 0
    }
})

const tasks = ref(allTask)
const item = ref()
const input = ref()
const editIndex = ref()
const editInput = ref()
const dragCont = ref()
const drake = ref()
const priorityIndex = ref()

const URL = import.meta.env.VITE_API_URL

const saveChange = (index) => {
    console.log('save')
    tasks.value[index].task = editInput.value

    editIndex.value = undefined
    editInput.value = undefined
}

const addTask = () => {
    if (input.value) {
        var newTask = { task: input.value }
        tasks.value.push(newTask)
        axios
            .post(`${URL}/todo`, newTask, {
                headers: { Authorization: `Bearer ${token.value}` }
            })
            .then((res) => replace(res.data.data))
            .catch((err) => {
                if (err.response.status === 401) {
                    router.push('/login')
                } else {
                    console.warn(err)
                }
            })

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

const changeColor = (index, priority) => {
    tasks.value[index].priority = priority
    priorityIndex.value = undefined
}

const fetchData = () => {}

watch(
    () => props.isClick,
    () => {
        item.value.click()
        editIndex.value = undefined
        editInput.value = undefined
    }
)

const saveToDb = () => {
    console.log(dragCont.value)
}

const replace = (newTask) => {
    console.log('before')
    console.log(tasks.value)
    tasks.value.map((each, index) => {
        if (!each.id) {
            tasks.value[index] = newTask
            return
        }
    })
    console.log('after')
    console.log(tasks.value)
}

onMounted(() => {
    drake.value = dragula([dragCont.value], { removeOnSpill: false })
})
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

        <div class="collapse" style="width: 60vh; float: right" id="collapseExample">
            <div class="bg-white rounded p-3 notebook">
                <section class="pb-2 d-flex justify-content-between">
                    <QuestionIcon />
                    <button @click="saveToDb" class="btn btn-success">Save</button>
                    <CloseIcon @closeToDo="item.click()" />
                </section>
                <div ref="dragCont">
                    <div class="rounded" v-for="(task, index) in tasks" :key="index">
                        <div v-if="task.id">
                            <div
                                :class="[priorityIndex !== index ? '' : 'd-none']"
                                :title="task.task"
                                class="task-class rounded p-3 d-flex justify-content-between align-items-center gap-3"
                            >
                                <input
                                    type="checkbox"
                                    :checked="task.status === 'completed'"
                                    @click="handleCheckbox(task)"
                                    style="zoom: 1.5"
                                />
                                <s v-if="task.status === 'completed'"
                                    ><span
                                        :class="[editIndex === index ? 'd-none' : '']"
                                        class="d-block text-truncate"
                                        style="zoom: 1.2; max-width: 25vh"
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
                                    <span
                                        :class="[editIndex === index ? 'd-none' : '']"
                                        class="d-block text-truncate"
                                        style="max-width: 20vh"
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
                                        <EditIcon
                                            @click="
                                                () => {
                                                    editIndex = index
                                                    editInput = task.task
                                                }
                                            "
                                            class="hide"
                                        />
                                        &nbsp;
                                        <GearIcon @click="priorityIndex = index" class="hide" />
                                    </span>
                                </div>
                            </div>
                            <div
                                :class="[priorityIndex === index ? '' : 'd-none']"
                                class="task-class rounded p-2 d-flex justify-content-between align-items-center gap-3"
                            >
                                <section class="d-flex gap-3">
                                    <span
                                        @click="changeColor(index, 1)"
                                        class="color-picker bg-danger text-center"
                                        >1</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="changeColor(index, 2)"
                                        class="color-picker bg-warning text-center"
                                        >2</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="changeColor(index, 3)"
                                        class="color-picker bg-success text-center"
                                        >3</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="changeColor(index, 4)"
                                        class="color-picker bg-secondary text-center"
                                        >4</span
                                    >
                                </section>
                                <button class="btn btn-sm btn-danger">Cancel</button>
                            </div>
                        </div>
                        <div v-if="!task.id" class="h2 text-center">{{ task.task }}</div>

                        <hr />
                    </div>
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
<style scoped>
.notebook {
    background: url(../../images/notebook2.jpg) no-repeat right bottom;
}

.hide {
    visibility: hidden;
}

.task-class:hover {
    border: 1px solid #9560e8;
}

.task-class:hover .hide {
    visibility: visible;
}

.color-picker {
    width: 5vh;
    color: white;
}

.gu-hide {
    display: none !important;
}

.gu-unselectable {
    -webkit-user-select: none !important;
    -moz-user-select: none !important;
    -ms-user-select: none !important;
    user-select: none !important;
}

.gu-transit {
    opacity: 0.2;
    -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=20)';
    filter: alpha(opacity=20);
}
.gu-mirror {
    position: fixed !important;
    margin: 0 !important;
    z-index: 9999 !important;
    opacity: 0.8;
    -ms-filter: 'progid:DXImageTransform.Microsoft.Alpha(Opacity=80)';
    filter: alpha(opacity=80);
}
</style>
