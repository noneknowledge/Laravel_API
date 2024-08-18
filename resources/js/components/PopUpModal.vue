<script setup>
import { ref } from 'vue'
import AssignSection from './AssignSection.vue'

const props = defineProps({ members: undefined })
const emits = defineEmits(['addTask'])
const closeButton = ref()
const selectMember = ref([])
const priority = ref(4)
const resetBtn = ref()
const change = ref(false)
console.log(props.members)

const addNewTask = (event) => {
    const formData = new FormData(event.currentTarget)
    formData.append('priority', priority.value)
    formData.append('members', selectMember.value)

    //call api here

    closeButton.value.click()
    priority.value = undefined
    selectMember.value = []

    emits('addTask', formData)
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
            data-target="#myModal"
            @click="change = !change"
        >
            Add new task
        </button>

        <div
            class="modal fade"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
            id="myModal"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Add new task
                            <i class="text-secondary">
                                - After add it will be in the Product Backlog column</i
                            >
                        </h5>
                    </div>
                    <form @submit.prevent="addNewTask">
                        <div class="modal-body">
                            <label for="task">Task:</label>
                            <input
                                required
                                type="text"
                                class="form-control"
                                placeholder="task"
                                name="task"
                                id="task"
                            />
                            <br />
                            <label for="tag">Tag:</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Tag"
                                name="tag"
                                id="tag"
                            />
                            <br />
                            <label for="description">Description:</label>
                            <textarea
                                class="form-control"
                                placeholder="description"
                                name="description"
                                id="description"
                            ></textarea>
                            <br />
                            <div class="d-flex gap-4">
                                <p>Priority:</p>
                                <section class="m-2 d-flex gap-2">
                                    <span
                                        @click="priority = 1"
                                        class="color-picker cursor-pointer bg-danger text-center"
                                        :class="[priority === 1 ? 'choose' : '']"
                                        >1</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="priority = 2"
                                        class="color-picker cursor-pointer bg-warning text-center"
                                        :class="[priority === 2 ? 'choose' : '']"
                                        >2</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="priority = 3"
                                        class="color-picker cursor-pointer bg-success text-center"
                                        :class="[priority === 3 ? 'choose' : '']"
                                        >3</span
                                    >
                                    <span class="vr"></span>
                                    <span
                                        @click="priority = 4"
                                        class="color-picker cursor-pointer bg-secondary text-center"
                                        :class="[priority === 4 ? 'choose' : '']"
                                        >4</span
                                    >
                                </section>
                            </div>
                            <div class="d-flex gap-4">
                                <p>Assign to:</p>
                                <AssignSection
                                    :members="members"
                                    :change="change"
                                    @clickCheckbox="handleChildEvent"
                                />
                            </div>
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

<style scoped>
.text-glow {
    text-shadow:
        1px 1px 2px black,
        0 0 25px blue,
        0 0 5px darkblue;
}
.color-picker {
    width: 5vh;
    color: white;
}
.choose {
    border: 4px solid #a5d7e8;
    border-radius: 10px;
}
</style>
