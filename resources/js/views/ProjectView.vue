<script setup>
import ProjectField from '../components/ProjectField.vue'
import { ref } from 'vue'
import PopModal from '../components/PopUpModal.vue'

const drake = ref(
    dragula({
        moves: function (el, source, handle, sibling) {
            return !!handle.closest('.drag-handle')
        },
        removeOnSpill: false
    })
)

const dragCont = ref()
const defaultColumn = ref([
    {
        col: 'Product Backlog',
        tasks: [
            { task: 'task 1', tag: 'tag 1' },
            { task: 'task 2', tag: 'tag 2' }
        ]
    },
    {
        col: 'Doing',
        tasks: [
            { task: 'task 3', tag: 'tag 3' },
            { task: 'task 4', tag: 'tag 4' }
        ]
    }
])

const handleAddTask = (newTask) => {
    console.log('child value: ')
    console.log(newTask)
}
const addColumn = () => {
    var newCol = 'new column'
    defaultColumn.value.push(newCol)
}
</script>

<template>
    <button @click="addColumn">Add column</button>
    <div class="bg-img">
        <div class="d-flex justify-content-center align-items-center gap-3">
            <h1 class="text-white text-shadow shadow text-center p-3">Project</h1>
            <PopModal @addTask="handleAddTask" />
        </div>

        <div class="container overflow-auto" style="transform: rotateX(180deg)">
            <div class="d-flex gap-4" ref="dragCont" style="transform: rotateX(180deg)">
                <ProjectField
                    v-for="each in defaultColumn"
                    :tasks="each.tasks"
                    :drake="drake"
                    :Column="each.col"
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
