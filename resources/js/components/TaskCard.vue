<script setup>
import MoveIcon from '../icons/MoveIcon.vue'
const props = defineProps({})
</script>

<template>
    <div class="card" style="width: 18rem">
        <div class="card-body position-relative">
            <h5 class="card-title cursor-pointer">Card title</h5>
            <h6 class="card-subtitle mb-2 text-muted cursor-pointer">Assign member</h6>
            <button class="btn btn-secondary drag-handle text-white"><MoveIcon /></button>
        </div>
    </div>
</template>

<style scoped>
.drag-handle {
    position: absolute;
    top: 0;
    right: 0;
}
</style>
