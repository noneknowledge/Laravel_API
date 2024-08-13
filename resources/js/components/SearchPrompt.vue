<script setup>
const props = defineProps({
    users: undefined
})
</script>
<template>
    <div class="position-absolute rounded bg-white border p-2" style="z-index: 100">
        <div v-for="user in users">
            <hr />
            <div class="cursor-pointer hover-effect p-2">
                <p class="font-size">Full name:{{ user.fullname }}</p>
                <p class="font-size text-secondary">Email: {{ user.email }}</p>
            </div>
        </div>
        <hr />
    </div>
</template>
<style scoped>
.font-size {
    font-size: 20px;
}
.hover-effect:hover {
    border-radius: 10px;
    background-color: #4c3bcf;
    color: white;
}
</style>
