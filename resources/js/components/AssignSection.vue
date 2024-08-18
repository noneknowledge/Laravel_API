<script setup>
import { ref, watch } from 'vue'
import { customDebounce } from '../helper/'

const props = defineProps({ change: Boolean, members: undefined })
const emits = defineEmits(['clickCheckbox'])

const assign = ref([])
const isShow = ref(false)
const keyWord = ref()
const formRef = ref()
let interval

const users = ['nam', 'minh', 'lan', 'phat']

const handleCheckBox = (value) => {
    emits('clickCheckbox', value)
}

const handleSearch = (value) => {
    interval = customDebounce(
        interval,
        (cbVar) => {
            console.log('Prompt search: ' + cbVar)
        },
        value
    )
}

watch(
    () => props.change,
    () => {
        assign.value = []
        formRef.value.reset()
    }
)
</script>

<template>
    <section>
        <button
            id="dropdownSearchButton"
            data-toggle="collapse"
            data-target="#assign-member"
            className="text-center btn btn-info text-white"
            type="button"
            style="width: 30vh"
        >
            Choose member
        </button>

        <div
            class="bg-secondary collapse overflow-scroll"
            id="assign-member"
            style="max-height: 40vh"
        >
            <input
                class="form-control"
                @input="(event) => handleSearch(event.target.value)"
                placeholder="search"
            />
            <form ref="formRef">
                <ul class="p-2">
                    <li
                        v-for="(user, index) in members"
                        :key="index"
                        class="py-2 rounded option text-white d-flex gap-3"
                    >
                        <input
                            type="checkbox"
                            @click="handleCheckBox(user)"
                            :id="index"
                            style="zoom: 1.5"
                        />
                        <label :for="index" class="cursor-pointer">
                            <img
                                class="rounded-circle"
                                style="width: 30px; height: 30px"
                                src="https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg?size=338&ext=jpg&ga=GA1.1.2008272138.1722211200&semt=ais_hybrid"
                            /><span class="px-3 text-capitalize">{{ user.fullname }}</span></label
                        >
                    </li>
                </ul>
            </form>
        </div>
    </section>
</template>
<style scoped>
.option {
    list-style: none;
}
</style>
