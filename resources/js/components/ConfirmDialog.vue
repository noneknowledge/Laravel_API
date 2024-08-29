<script setup>
import { ref, watch } from 'vue'
const props = defineProps({
    click: undefined,
    title: String,
    msg: String
})
const emit = defineEmits(['confirmClicked'])
const confirmEmit = () => {
    emit('confirmClicked')
}
const openBtn = ref()
watch(
    () => props.click,
    () => {
        openBtn.value.click()
    }
)
</script>

<template>
    <button
        ref="openBtn"
        type="button"
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#delete-project"
        hidden
    >
        Launch demo modal
    </button>
    <div class="modal" id="delete-project" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i>Title:</i> {{ title }}</h5>
                </div>
                <div class="modal-body">
                    <p>
                        {{ msg }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button @click="confirmEmit" type="button" class="btn btn-danger">
                        Confirm
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
