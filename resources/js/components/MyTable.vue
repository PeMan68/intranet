<template>

    <div>
        <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
        ></b-pagination>

        <b-table 
            id="my-table"
            :items="items"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            small
        ></b-table>
    </div>
</template>

<script>
    export default {
        props: [
            'items',
            'fields',
            ],


        data() {
            return {
                perPage: 10,
                currentPage: 1,
            }
        },

        computed: {
            rows() {
                return this.items.length
            }
        }
    }
</script>