<script setup>
const props = defineProps({
    project: undefined,
    userid: Number
})
const deleteBtn = () => {
    alert("Haven't done this feature yet")
}
const editBtn = () => {
    alert("Haven't done this feature yet")
}
</script>
<template>
    <div class="p-5 font-lg">
        <div class="pb-3">
            <i>Project name:</i> {{ project.title }} <br />
            <i>Leader:</i> {{ project.leader.fullname }}
            <button v-if="userid === project.leader.id" class="btn disabled btn-success mx-3">
                You
            </button>
            <br />
            <i>Description:</i> We do not have a field for project description yet
        </div>
        <hr class="p-2" />
        <div class="p-4 border rounded border-danger" style="min-height: 50vh">
            <h4 class="text-center text-danger">Danger area</h4>
            Delete project:
            <button @click="deleteBtn" class="btn btn-danger form-control font-lg">Delete</button>
            Edit project:
            <button @click="editBtn" class="btn btn-info form-control font-lg">Edit</button>
        </div>
    </div>
</template>
<style scoped></style>
