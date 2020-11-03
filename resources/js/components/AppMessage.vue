<template>
    <div v-show="elementVisible" class="alert alert-success">
    <slot></slot>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                elementVisible: true
            }
        },

        created() {
            setTimeout(() => this.elementVisible = false, 10000)
        }
    }
</script>
