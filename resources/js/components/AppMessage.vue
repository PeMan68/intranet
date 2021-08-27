<template>
<b-alert class="position-absolute" style="z-index: 2000; margin-top: -2rem;
    opacity: 0.85;" v-model="showTop" fade variant="success" dismissible>
    <slot></slot>
</b-alert>
</template>

<script>
export default {
    data() {
        return {
            showTop: true
        }
    },

    created() {
        setTimeout(() => this.showTop = false, 20000)
    }
}
</script>

