<script setup>
import ProjectField from '../components/ProjectField.vue'
import { ref, watch } from 'vue'
import PopModal from '../components/PopUpModal.vue'

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
                if (cloneCol[from].tasks[i].task === parseEl.task) {
                    cloneCol[from].tasks.splice(i, 1)
                    break
                }
            }
            for (let i = 0; i < cloneCol[to].tasks.length; i++) {
                if (cloneCol[to].tasks[i].task === parseVal.task) {
                    cloneCol[to].tasks.splice(i, 0, parseEl)
                    break
                }
            }
        } else {
            console.log('no below')
        }
    })
)

const dragCont = ref()
const columnData = ref([
    {
        id: 1,
        col: 'Product Backlog',
        tasks: [
            { task: 'task 1', tag: 'tag 1' },
            { task: 'task 2', tag: 'tag 2' }
        ]
    },
    {
        id: 2,
        col: 'Doing',
        tasks: [
            { task: 'task 3', tag: 'tag 3' },
            { task: 'task 4', tag: 'tag 4' }
        ]
    }
])

const cloneCol = JSON.parse(JSON.stringify(columnData.value))

const handleAddTask = (newTask) => {
    columnData.value[0].tasks.push(newTask)
}

const handleChangeName = (value) => {
    const { id, newName } = value
    columnData.value.map((row) => {
        if (row.id === id) {
            row.col = newName
        }
    })
}

const addColumn = () => {
    var allTasks = document.getElementsByClassName('task')
    console.log(allTasks)
    var newCol = { id: 3, col: 'New column', tasks: [{ task: 'nothing' }] }
    columnData.value.push(newCol)
}

const logTheArrange = () => {
    console.log('Arrangement')
    console.log(cloneCol)
}
</script>

<template>
    <button @click="logTheArrange">Log the arrangement</button>
    <div class="bg-img">
        <div class="d-flex justify-content-center align-items-center gap-3">
            <h1 class="text-white text-shadow shadow text-center p-3">Project</h1>
            <PopModal @addTask="handleAddTask" />
            <button class="btn btn-lg btn-primary" @click="addColumn">Add column</button>
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
