<script setup>
const props = defineProps({})
</script>
<template>
    <div class="card-body">
        <p class="mb-4">
            <span class="text-primary font-italic me-1">assigment</span>
            Project Status
        </p>
        <p class="mb-1" style="font-size: 0.77rem">Web Design</p>
        <div class="progress rounded" style="height: 5px">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: 80%"
                aria-valuenow="80"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
        <p class="mt-4 mb-1" style="font-size: 0.77rem">Website Markup</p>
        <div class="progress rounded" style="height: 5px">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: 72%"
                aria-valuenow="72"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
        <p class="mt-4 mb-1" style="font-size: 0.77rem">One Page</p>
        <div class="progress rounded" style="height: 5px">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: 89%"
                aria-valuenow="89"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
        <p class="mt-4 mb-1" style="font-size: 0.77rem">Mobile Template</p>
        <div class="progress rounded" style="height: 5px">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: 55%"
                aria-valuenow="55"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
        <p class="mt-4 mb-1" style="font-size: 0.77rem">Backend API</p>
        <div class="progress rounded mb-2" style="height: 5px">
            <div
                class="progress-bar"
                role="progressbar"
                style="width: 66%"
                aria-valuenow="66"
                aria-valuemin="0"
                aria-valuemax="100"
            ></div>
        </div>
    </div>
</template>
