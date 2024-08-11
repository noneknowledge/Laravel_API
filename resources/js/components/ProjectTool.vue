<script setup>
import QuestionIcon from '../icons/QuestionIcon.vue'
import CloseIcon from '../icons/CloseIcon.vue'
import EditIcon from '../icons/EditIcon.vue'
import GearIcon from '../icons/GearIcon.vue'
</script>
<template>
    <div class="collapse position-absolute" style="z-index: 100" id="toolBar">
        <div class="bg-white rounded p-3 notebook">
            <section class="d-flex justify-content-between">
                <QuestionIcon />

                <CloseIcon @close="$emit('close')" />
            </section>
            <div class="text-center d-flex justify-content-around">
                <slot name="taskBtn"></slot>
                <slot name="saveBtn"></slot>
                <slot name="colBtn"></slot>
            </div>
        </div>
    </div>
</template>
