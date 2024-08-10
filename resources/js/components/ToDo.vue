<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import QuestionIcon from '../icons/QuestionIcon.vue'
import CloseIcon from '../icons/CloseIcon.vue'
import EditIcon from '../icons/EditIcon.vue'
import GearIcon from '../icons/GearIcon.vue'
import { useToken } from '../stores/'
import axios from 'axios'
import { customSort } from '../helper/'

const props = defineProps({
    isClick: Boolean
})

const router = useRouter()

const [token, setToken] = useToken()

const tasks = ref()
const item = ref()
const input = ref()
const editIndex = ref()
const editInput = ref()
const dragCont = ref()
const drake = ref()
const priorityIndex = ref()
const isLoading = ref()
const dot = ref('.')
let loading

const URL = import.meta.env.VITE_API_URL

const saveChange = (index) => {
    if (tasks.value[index].task === editInput.value.trim()) {
    } else {
        tasks.value[index].task = editInput.value.trim()
        tasks.value[index].action = 'update'
    }

    editIndex.value = undefined
    editInput.value = undefined
}

const addTask = () => {
    if (input.value) {
        var newTask = { task: input.value.trim() }
        tasks.value.push(newTask)
        axios
            .post(`${URL}/todo`, newTask, {
                headers: { Authorization: `Bearer ${token.value}` }
            })
            .then((res) => replace(res.data.data))
            .catch((err) => {
                if (err.message.status === 401) {
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
    if (task.status === 0) {
        task.action = 'update'
        task.status = 1
    } else {
        task.status = 0
        task.action = 'update'
    }
}

const changeColor = (index, priority) => {
    tasks.value[index].priority = priority
    tasks.value[index].action = 'update'
    priorityIndex.value = undefined
}

const fetchData = () => {
    axios
        .get(`${URL}/todo`, { headers: { Authorization: `Bearer ${token.value}` } })
        .then((res) => {
            let rawdata = res.data.data
            customSort(rawdata, 'status', 'priority')
            let data = rawdata.map((x) => ({ ...x, action: '' }))
            tasks.value = data
            isLoading.value = false
        })
        .catch((err) => {
            console.warn(err)
            if (err.message.includes('401')) {
                alert('User session expired')
                setToken(undefined)
            }
        })
}

watch(
    () => isLoading.value,
    () => {
        clearInterval(loading)
        loading = setInterval(() => {
            if (dot.value.length === 3) {
                dot.value = ''
            } else {
                dot.value = dot.value + '.'
            }
        }, 1000)
        if (!isLoading.value) {
            clearInterval(loading)
        }
    }
)

watch(
    () => props.isClick,
    () => {
        item.value.click()
        editIndex.value = undefined
        editInput.value = undefined
        if (props.isClick) {
            isLoading.value = true
            fetchData()
        }
    }
)

const saveToDb = () => {
    let preventCall = true
    console.log(tasks.value)
    tasks.value.map((task) => {
        if (task.action) {
            preventCall = false
        }
    })

    if (preventCall) {
        console.log('no call api')
        return
    }
    tasks.value.map((item, index) => {
        if (item.action === 'update') {
            setTimeout(() => {
                tasks.value[index].action = ''
            }, 1000)
        }
        if (item.action === 'delete') {
            console.log('delete here ' + index)
            setTimeout(() => {
                tasks.value.splice(index, 1)
            }, 1000)
        }
    })
    axios
        .put(`${URL}/todo`, tasks.value, {
            headers: { Authorization: `Bearer ${token.value}` }
        })
        .then((res) => {
            console.log(res)
        })
        .catch((err) => {
            console.log(err)
            if (err.message.includes('401')) {
                alert('User session expired')
                setToken(undefined)
            }
        })
}

const replace = (newTask) => {
    tasks.value.map((each, index) => {
        if (!each.id) {
            tasks.value[index] = newTask
            return
        }
    })
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
            data-toggle="collapse"
            data-target="#collapseExample"
        >
            Button with data-bs-target
        </button>

        <div class="collapse" style="width: 60vh; float: right" id="collapseExample">
            <div class="bg-white rounded p-3 notebook">
                <section class="pb-2 d-flex justify-content-between">
                    <QuestionIcon />
                    <button v-if="isLoading" class="btn btn-primary text-white">
                        Loading {{ dot }}
                    </button>
                    <button v-else @click="saveToDb" class="btn btn-success">Save</button>
                    <CloseIcon @closeToDo="item.click()" />
                </section>
                <div ref="dragCont">
                    <div class="rounded" v-for="(task, index) in tasks" :key="index">
                        <div v-if="task.action !== 'delete'">
                            <div v-if="task.id">
                                <div
                                    :class="[priorityIndex !== index ? '' : 'd-none']"
                                    :title="task.task"
                                    class="task-class rounded p-3 d-flex justify-content-between align-items-center gap-3"
                                >
                                    <input
                                        type="checkbox"
                                        :checked="task.status === 1"
                                        @click="handleCheckbox(task)"
                                        style="zoom: 1.5"
                                    />
                                    <s v-if="task.status === 1"
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
                                    <section class="d-flex gap-2">
                                        <span
                                            @click="changeColor(index, 1)"
                                            class="color-picker cursor-pointer bg-danger text-center"
                                            >1</span
                                        >
                                        <span class="vr"></span>
                                        <span
                                            @click="changeColor(index, 2)"
                                            class="color-picker cursor-pointer bg-warning text-center"
                                            >2</span
                                        >
                                        <span class="vr"></span>
                                        <span
                                            @click="changeColor(index, 3)"
                                            class="color-picker cursor-pointer bg-success text-center"
                                            >3</span
                                        >
                                        <span class="vr"></span>
                                        <span
                                            @click="changeColor(index, 4)"
                                            class="color-picker cursor-pointer bg-secondary text-center"
                                            >4</span
                                        >
                                    </section>
                                    <span class="vr"></span>
                                    <button
                                        @click="
                                            () => {
                                                tasks[index].action = 'delete'
                                                priorityIndex = undefined
                                            }
                                        "
                                        class="btn btn-sm btn-secondary"
                                    >
                                        Delete
                                    </button>
                                    <button
                                        @click="priorityIndex = undefined"
                                        class="btn btn-sm btn-danger"
                                    >
                                        Cancel
                                    </button>
                                </div>
                            </div>
                            <div v-if="!task.id" class="h2 text-center">{{ task.task }}</div>
                            <hr />
                        </div>
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
</style>
