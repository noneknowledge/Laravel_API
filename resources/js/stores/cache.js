import { ref, watch } from 'vue'
const cache = new Map()
const cacheReact = ref(cache)
export const clearKey = ref()

watch(
    () => clearKey.value,
    () => {
        console.log('change' + clearKey.value)
        // if (clearKey.value !== undefined) {
        //     cacheReact.value.delete(clearKey.value)
        //     clearKey.value = undefined
        // }
    }
)

const setCacheValue = (key, value) => {
    cacheReact.value.set(key, value)
}

const clearData = (key) => {
    cacheReact.value.delete(key)
}

export async function customCache(key, fetcher) {
    if (cacheReact.value.get(key)) {
        return cacheReact.value.get(key)
    } else {
        const value = await fetcher()
        console.log(value)
        setCacheValue(key, value)
        console.log(cacheReact.value)
        return value
    }
}
