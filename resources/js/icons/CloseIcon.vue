<script setup></script>

<template>
    <div title="close to do list">
        <svg
            @click="$emit('closeToDo')"
            xmlns="http://www.w3.org/2000/svg"
            width="26"
            height="26"
            fill="currentColor"
            class="bi bi-x-circle-fill text-danger rounded-circle"
            viewBox="0 0 16 16"
            style="border: 2px solid black"
        >
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"
            />
        </svg>
    </div>
</template>
