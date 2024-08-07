<script setup>
import { ref, onMounted } from 'vue'
import TaskCard from './TaskCard.vue'

const props = defineProps({
    Column: String,
    drake: undefined,
    dragRef: undefined
})
// const drakeable = ref(dragula({ removeOnSpill: false }))

const works = ['Post', 'Get', 'Update', 'Delete', 'Get', 'Update', 'Delete']
const tasks = ref(works)
const dragCont = ref()
onMounted(() => {
    props.drake.containers.push(dragCont.value)
    // drakeable.value.containers.push(dragCont.value)
    // console.log(drakeable.value.containers)
})
</script>

<template>
    <div class="col border rounded" style="min-height: 30vh; min-width: 40vh">
        <h5 class="text-center p-2 border border-primary rounded bg-dark text-white">
            {{ Column }}
        </h5>
        <div ref="dragCont">
            <h6
                v-for="task in tasks"
                class="border bg-success d-flex text-white p-2 text-center justify-content-center align-items-center"
            >
                <TaskCard />
            </h6>
        </div>
    </div>
</template>
