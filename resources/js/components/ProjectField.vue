<script setup>
import { ref, onMounted } from 'vue'
import TaskCard from './TaskCard.vue'

const props = defineProps({
    Column: String,
    drake: undefined,
    tasks: undefined
})

const dragCont = ref()
onMounted(() => {
    props.drake.containers.push(dragCont.value)
})
</script>

<template>
    <div class="border rounded p-2 bg-secondary" style="min-width: 40vh">
        <h5 class="text-center p-2 border border-primary rounded bg-dark text-white">
            {{ Column }}
        </h5>
        <div ref="dragCont" style="height: 70vh" class="overflow-auto">
            <h6
                v-for="task in tasks"
                class="border bg-success d-flex text-white p-2 text-center justify-content-center align-items-center"
            >
                <TaskCard :task="task" />
            </h6>
        </div>
    </div>
</template>
