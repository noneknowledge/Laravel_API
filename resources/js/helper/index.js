export function customSort(array, equalP, greaterP) {
    array.sort((a, b) => {
        if (a[equalP] === 1 && b[equalP] === 0) {
            return 1
        } else if (b[equalP] === 1 && a[equalP] === 0) {
            return -1
        }

        if (a[greaterP] < b[greaterP]) {
            return -1
        } else if (a[greaterP] > b[greaterP]) {
            return 1
        } else {
            return 0
        }
    })
}

export const customDebounce = (interval, cb, value, ms = 500) => {
    console.log('ms: ' + ms)
    clearTimeout(interval)
    if (value) {
        interval = setTimeout(() => {
            cb(value)
        }, ms)
        return interval
    }
}
