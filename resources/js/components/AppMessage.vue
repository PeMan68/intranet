<template>
    <transition name="fade">
        <div v-show="elementVisible" class="alert alert-success">
        <slot></slot>
        </div>
    </transition>
</template>

<script>
    export default {
        data() {
            return {
                elementVisible: true
            }
        },

        created() {
            setTimeout(() => this.elementVisible = false, 2000)
        }
    }
</script>

<style>
    .fade-leave-active {
        transition: opacity 2s ease-out;
    }
    .fade-leave-to {
        opacity: 0;
    }

</style>
