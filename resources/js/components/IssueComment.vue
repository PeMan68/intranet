<template>
<div>
    <small>
        <strong>
            <slot name="date"></slot>
            <slot name="type"></slot>
            <slot name="from"></slot>
            <slot name="to"></slot>
        </strong>
    </small>
    <slot></slot>
</div>
</template>

<script>
export default {
    data() {
        return {
            icon: 'info',
            to: '',
        }
    },
};
</script>
