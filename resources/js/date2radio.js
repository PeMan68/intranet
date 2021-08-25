export function invoicedateToValue(date) {
    const today = new Date()
    const last1Month = today.setMonth(today.getMonth() - 1)
    const last6Month = today.setMonth(today.getMonth() - 5) // -1-5
    const last24Month = today.setMonth(today.getMonth() - 18) // -1-5-18
    if (date === null) {
        return null
    }
    date = new Date(date)
    date = Date.parse(date)
    if (date < last24Month) {
        return 3
    } else if (date < last6Month) {
        return 2
    } else if (date < last1Month) {
        return 1
    } else {
        return 0;
    }
}
export function agevalueToDate(age) {
    const today = new Date()
    const yesterday = today.setDate(today.getDate() - 1)
    age = Number(age)
    switch (age) {
        case 0:
            return new Date(today).toISOString()
            break
        case 1:
            return new Date(today.setMonth(today.getMonth() - 1)).toISOString()
            break
        case 2:
            return new Date(today.setMonth(today.getMonth() - 6)).toISOString()
            break
        case 3:
            return new Date(today.setMonth(today.getMonth() - 24)).toISOString()
            break

        default:
            return null
            break
    }
}