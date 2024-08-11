import { ref, watch } from 'vue'

const cache = ref(new Map())
// const myTimeOut = ref(new Map())
export const clearKey = ref()

watch(
    () => clearKey.value,
    () => {
        if (clearKey.value !== undefined) {
            cache.value.delete(clearKey.value)
            // let timer = myTimeOut.value.get(clearKey.value)
            // if (timer) {
            //     clearTimeout(timer)
            // }
            clearKey.value = undefined
        }
    }
)

const setCacheValue = (key, value, timeout) => {
    let timer = setTimeout(() => {
        // myTimeOut.value.delete(key)
        clearKey.value = key
    }, timeout)
    cache.value.set(key, value)
    // myTimeOut.value.set(key, timer)
}

//revalidate data after 30s
export async function customCache(key, fetcher, revalidate = 30000) {
    if (cache.value.get(key)) {
        return cache.value.get(key)
    } else {
        const value = await fetcher()

        setCacheValue(key, value, revalidate)
        return value
    }
}
