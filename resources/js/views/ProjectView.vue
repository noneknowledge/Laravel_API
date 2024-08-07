<script setup>
import ProjectField from '../components/ProjectField.vue'
import { ref } from 'vue'

const drake = ref(
    dragula({
        moves: function (el, source, handle, sibling) {
            return !!handle.closest('.drag-handle')
        },
        removeOnSpill: false
    })
)
const columnRefs = ref([])
const dragCont = ref()
const defaultColumn = ref(['Product Backlog', 'Doing', 'Error', 'Review', 'Review', 'Done'])
</script>

<template>
    <h1 class="text-center p-3">Project</h1>

    <div class="row gap-4" ref="dragCont">
        <ProjectField ref="columnRefs" v-for="col in defaultColumn" :drake="drake" :Column="col" />
    </div>
</template>
