<template>

    <b-container fluid>
        <b-row>
            <b-col sm="6">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="my-table"
                ></b-pagination>
            </b-col>
            <b-col sm="6">
                <b-form-group
                label="Filter"
                label-cols-sm="3"
                label-align-sm="right"
                label-size="sm"
                label-for="filterInput"
                class="mb-0"
                >
                <b-input-group size="sm">
                    <b-form-input
                    v-model="filter"
                    type="search"
                    id="filterInput"
                    placeholder="Sök i alla kolumner"
                    ></b-form-input>
                    <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''">Rensa</b-button>
                    </b-input-group-append>
                </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
        <b-table 
            id="my-table"
            :items="items"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            :filter="filter"
            @filtered="onFiltered"
            small
            sticky-header="400px"
            sort-icon-left
        ></b-table>
    </b-container>
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
                filter: null,
                totalRows: 1,
            }
        },

        mounted() {
            // Set the initial number of items
            this.totalRows = this.items.length
        },
        methods: {

            onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
            }
        },
    
    }
</script>