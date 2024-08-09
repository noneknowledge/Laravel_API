<script setup>
import { ref } from 'vue'

const emits = defineEmits(['addProject'])
const closeButton = ref()
const resetBtn = ref()

const handleSubmit = (event) => {
    const formData = new FormData(event.currentTarget)

    closeButton.value.click()
    const newProject = {
        title: formData.get('title'),
        thumbnail: formData.get('thumbnail')
    }
    console.log(newProject)

    emits('addProject', newProject)
}

const handleChildEvent = (value) => {
    selectMember.value.push(value)
}
</script>

<template>
    <div class="m-3">
        <button
            type="button"
            class="btn btn-lg btn-primary text-glow"
            data-toggle="modal"
            data-target="#createProjectModal"
        >
            New project +
        </button>

        <div
            class="modal fade"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
            id="createProjectModal"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add new project</h5>
                    </div>
                    <form @submit.prevent="handleSubmit">
                        <div class="modal-body">
                            <label for="title">Title:</label>
                            <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="Project title"
                                name="title"
                                id="title"
                            />
                            <br />
                            <label for="thumbnail">Thumbnail:</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Thumbnail"
                                name="thumbnail"
                                id="thumbnail"
                            />
                            <br />
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                            <button type="reset" ref="resetBtn" class="btn btn-danger">
                                Reset
                            </button>
                            <button
                                type="button"
                                ref="closeButton"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                @click="resetBtn.click()"
                            >
                                Close
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
