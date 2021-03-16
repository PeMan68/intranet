<template>
<div>
    <a v-bind:href="url">
        <slot></slot>
    </a>
    <a v-bind:href="url" target="_blank">
        <sup><i class="material-icons md-18">open_in_new</i></sup>
    </a>
</div>
</template>

<script>
export default {
    props: [
        'url'
    ]
}
</script>
