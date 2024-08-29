<script setup>
import ProjectField from '../components/ProjectField.vue'
import { ref, inject, watch } from 'vue'
import PopModal from '../components/PopUpModal.vue'
import { customCache, clearKey } from '../stores/'
import { useRoute } from 'vue-router'
import ProjectTool from '../components/ProjectTool.vue'
import LoadingSnippet from '../components/LoadingSnippet.vue'
import GearIcon from '../icons/GearIcon.vue'

const route = useRoute()
const drake = ref(
    dragula({
        moves: function (el, source, handle, sibling) {
            return !!handle.closest('.drag-handle')
        },
        removeOnSpill: false
    }).on('drop', (el, target, source, sibling) => {
        var from = source.getAttribute('data-value')
        var to = target.getAttribute('data-value')
        var el = el.getAttribute('data-value')
        var parseEl = JSON.parse(el)

        if (sibling) {
            var below = sibling.getAttribute('data-value')
            var parseVal = JSON.parse(below)
            for (let i = 0; i < cloneCol[from].tasks.length; i++) {
                if (cloneCol[from].tasks[i].title === parseEl.title) {
                    cloneCol[from].tasks.splice(i, 1)
                    break
                }
            }
            for (let i = 0; i < cloneCol[to].tasks.length; i++) {
                if (cloneCol[to].tasks[i].title === parseVal.title) {
                    cloneCol[to].tasks.splice(i, 0, parseEl)
                    break
                }
            }
        } else {
            for (let i = 0; i < cloneCol[from].tasks.length; i++) {
                if (cloneCol[from].tasks[i].title === parseEl.title) {
                    cloneCol[from].tasks.splice(i, 1)
                    break
                }
            }

            cloneCol[to].tasks.push(parseEl)
        }
    })
)
const tool = ref()
const dragCont = ref()
const columnData = ref()
const [token, setToken] = inject('token')
const id = route.params.id
const URL = inject('url')
var cloneCol
const fetchData = async () => {
    try {
        isLoading.value = true
        const res = await axios.get(`${URL}/project/${id}`, {
            headers: { Authorization: `Bearer ${token.value.access_token}` }
        })
        return res.data
    } catch (e) {
        if (e.message.includes('401')) {
            alert('Login session expired')
            setToken(undefined)
        }
        console.warn(e)
        return undefined
    }
}

const key = `project/${route.params.id} `
const project = ref()
const members = ref()
const isLoading = ref(true)
const canSaveChange = ref(false)

customCache(key, fetchData)
    .then((res) => {
        isLoading.value = false
        project.value = res.project
        members.value = res.members
        columnData.value = res.data
        cloneCol = JSON.parse(JSON.stringify(columnData.value))
    })
    .catch((err) => console.warn(err))

const handleAddTask = (formData) => {
    if (columnData.value.length === 0) {
        alert('No container to add')
        return
    }

    isLoading.value = true
    // const newTask = {
    //     title: formData.get('task'),
    //     tag: 'Loading...'
    // }
    // columnData.value[0].tasks.push(newTask)
    // cloneCol[0].tasks.push(newTask)
    formData.append('containerid', cloneCol[0].id)
    axios
        .post(`${URL}/task/${id}`, formData, {
            headers: { Authorization: `Bearer ${token.value.access_token}` }
        })
        .then((res) => {
            columnData.value[0].tasks.push(res.data.newTask)
            cloneCol[0].tasks.push(res.data.newTask)
            isLoading.value = false
            // for (let index = 0; index < cloneCol[0].tasks.length; index++) {
            //     if (!cloneCol[0].tasks[index].id) {
            //         cloneCol[0].tasks[index] = res.data.newTask
            //         break
            //     }
            // }
            // for (let index = 0; index < columnData.value[0].tasks.length; index++) {
            //     if (!columnData.value[0].tasks[index].id) {
            //         columnData.value[0].tasks[index] = res.data.newTask
            //         break
            //     }
            // }
        })
        .catch((err) => console.warn(err))
}

const handleChangeName = (value) => {
    const { id, newName } = value
    columnData.value.map((row, index) => {
        if (row.id === id) {
            if (row.title === newName) {
                alert('Same name')
                return
            } else {
                canSaveChange = true
                row.title = newName
                cloneCol[index].title = newName
                return
            }
        }
    })
}

const addColumn = () => {
    isLoading.value = true
    axios
        .post(`${URL}/column/${id}`, null, {
            headers: { Authorization: `Bearer ${token.value.access_token}` }
        })
        .then((res) => {
            cloneCol.push({ ...res.data.newColumn, task: [] })
            columnData.value.push({ ...res.data.newColumn, tasks: [] })
            console.log(columnData.value)
            isLoading.value = false
        })
        .catch((err) => console.warn(err))
}

const saveOrder = () => {
    if (canSaveChange.value) {
        alert('Can save change')
    } else {
        if (JSON.stringify(cloneCol) === JSON.stringify(columnData.value)) {
            alert('Nothing change')
        } else {
            alert('Change')
        }
    }
}
</script>

<template>
    <div class="bg-img">
        <Transition
            ><section class="position-absolute" style="z-index: 100" v-show="isLoading">
                Loading...<LoadingSnippet /></section
        ></Transition>
        <div class="d-flex justify-content-center align-items-center gap-3">
            <h1 title="Go to project setting" class="text-white text-shadow shadow text-center p-3">
                Project: <span v-if="project">{{ project.title }}</span>
            </h1>
            <PopModal v-if="members" :members="members" @addTask="handleAddTask" />
            <button
                ref="tool"
                class="btn btn-lg btn-info text-white"
                type="button"
                data-toggle="collapse"
                data-target="#toolBar"
            >
                <GearIcon />
            </button>
            <ProjectTool @close="tool.click()">
                <template #saveBtn>
                    <button class="m-3 btn btn-lg btn-success" @click="saveOrder">Save</button>
                </template>
                <template #settingBtn>
                    <button
                        @click="$router.push(`/setting/${project.id}`)"
                        class="btn btn-outline-secondary my-3"
                    >
                        Project Setting
                    </button>
                </template>
                <template #colBtn>
                    <button
                        class="m-3 btn btn-lg btn-primary"
                        @click="
                            () => {
                                addColumn()
                            }
                        "
                    >
                        Add column
                    </button></template
                >
            </ProjectTool>
        </div>

        <div class="container overflow-auto" style="transform: rotateX(180deg)">
            <div class="d-flex gap-4" ref="dragCont" style="transform: rotateX(180deg)">
                <ProjectField
                    @editName="handleChangeName"
                    v-for="(each, index) in columnData"
                    :drake="drake"
                    :Column="each"
                    :key="index"
                    :index="index"
                />
            </div>
        </div>
    </div>
</template>
<style scoped>
.bg-img {
    height: 100vh;
    background-image: url(../../images/bg-project2.webp);
    background-size: cover; /* <------ */
    background-repeat: repeat-y;
    background-position: center center;
}
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
