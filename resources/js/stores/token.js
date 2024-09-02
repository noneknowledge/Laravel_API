import { ref, watch } from 'vue'

const key = import.meta.env.VITE_LOCALSTORAGE_KEY
var localToken = localStorage.getItem(key)
if (!localToken) {
    localToken = undefined
} else {
    localToken = JSON.parse(localToken)
}

const token = ref(localToken)

watch(
    () => token.value,
    (currValue) => {
        if (currValue === undefined) {
            localStorage.removeItem(key)
        } else {
            localStorage.setItem(key, JSON.stringify(token.value))
        }
    }
)
export function useToken() {
    const setLogin = (newToken) => {
        token.value = newToken
    }

    return [token, setLogin]
}
