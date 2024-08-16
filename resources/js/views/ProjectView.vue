<script setup>
import ProjectField from '../components/ProjectField.vue'
import { ref, inject } from 'vue'
import PopModal from '../components/PopUpModal.vue'
import { customCache, clearKey } from '../stores/'
import { useRoute } from 'vue-router'
import ProjectTool from '../components/ProjectTool.vue'
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
const URL = inject('url') + '/project/' + route.params.id
var cloneCol
const fetchData = async () => {
    try {
        console.log(URL)
        const res = await axios.get(URL, {
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

customCache(key, fetchData)
    .then((res) => {
        project.value = res.project
        console.log(res)
        columnData.value = res.data
        cloneCol = JSON.parse(JSON.stringify(columnData.value))
    })
    .catch((err) => console.warn(err))

const handleAddTask = (formData) => {
    const newTask = {
        title: formData.get('task'),
        tag: formData.get('tag')
    }
    axios
        .post(`${import.meta.env.VITE_API_URL}/task`, formData, {
            headers: { Authorization: `Bearer ${token.value.access_token}` }
        })
        .then((res) => console.log(res))
        .catch((err) => console.warn(err))
    columnData.value[0].tasks.push(newTask)
    cloneCol[0].tasks.push(newTask)
}

const handleChangeName = (value) => {
    const { id, newName } = value
    columnData.value.map((row, index) => {
        if (row.id === id) {
            row.title = newName
            cloneCol[index].title = newName
        }
    })
}

const addColumn = () => {
    var newCol = { id: 3, title: 'New column', tasks: [{ title: 'nothing' }] }
    columnData.value.push(newCol)
}

const saveOrder = () => {
    if (JSON.stringify(cloneCol) === JSON.stringify(columnData.value)) {
        console.log('True')
        alert('Nothing change')
    } else {
        console.log('ref')
        console.log(JSON.stringify(columnData.value))
        console.log('normal')
        console.log(JSON.stringify(cloneCol))
        console.log(cloneCol)
    }
}
</script>

<template>
    <div class="bg-img">
        <div class="d-flex justify-content-center align-items-center gap-3">
            <h1 title="Go to project setting" class="text-white text-shadow shadow text-center p-3">
                Project: <span v-if="project">{{ project.title }}</span>
            </h1>

            <button class="m-3 btn btn-lg btn-success" @click="saveOrder">Save</button>
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
                <template #taskBtn> <PopModal @addTask="handleAddTask" /> </template>
                <template #settingBtn>
                    <button
                        @click="$router.push(`/setting/${project.id}`)"
                        class="btn btn-outline-secondary my-3"
                        @addTask="handleAddTask"
                    >
                        Project Setting
                    </button>
                </template>
                <template #colBtn>
                    <button class="m-3 btn btn-lg btn-primary" @click="addColumn">
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
.text-shadow {
    text-shadow: 2px 2px 2px #ff0000;
}
</style>
