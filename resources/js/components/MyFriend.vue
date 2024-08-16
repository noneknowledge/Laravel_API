<script setup>
const props = defineProps({ friends: undefined })
</script>
<template>
    <section class="row p-3">
        <h3 class="text-center">Friends</h3>
        <div v-for="friend in friends" class="col-sm-4 col-3 d-flex flex-column">
            <img
                class="rounded-circle border mx-auto d-block"
                width="80"
                src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
            />
            <span class="text-center">{{ friend.fullname }}</span>
        </div>
    </section>
    <!-- <div class="card-body p-0">
        <ul class="list-group list-group-flush rounded-3">
            <li class="list-group-item p-3">
                <p class="mb-0">Friend 1</p>
            </li>
            <li class="list-group-item p-2 d-flex gap-5 align-items-center">
                <img
                    class="rounded-circle border"
                    width="40"
                    src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                />
                <p class="mb-0">Friend 2</p>
            </li>
            <li class="list-group-item p-3">
                <p class="mb-0">Friend 3</p>
            </li>
        </ul>
    </div> -->
</template>
