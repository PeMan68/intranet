<template>

    <b-container fluid>
        <b-row class="mb-2">
            <b-col sm="2">
                <b-button variant="primary" size="sm" :href="link"><i class="material-icons">add_circle</i> <slot></slot></b-button>
            </b-col>
            <b-col sm="5">
                <b-pagination v-show="paginate"
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="table"
                ></b-pagination>
            </b-col>

            <b-col sm="5">
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
            id="table"
            :items="items"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            :filter="filter"
            @filtered="onFiltered"
            small
            sticky-header="1000px"
            sort-icon-left
            responsive
            >
            <template #head()="data">
                <span class="text-nowrap">{{ data.label }}</span>
            </template>
            <template #cell()="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>
            <template #cell(Fil)="data">
                <a :href="'/documents/download/' + data.item.Id">{{ data.value }}</a>
            </template>
            <template #cell(Storlek)="data">
                <div class="text-right">{{ data.value }}</div>
            </template>
        </b-table>
    </b-container>
</template>

<script>
    export default {
        props: [
            'items',
            'fields',
            'link',
            
         ],

        data() {
            return {
                perPage: 20,
                currentPage: 1,
                totalRows: 1,
                filter: null,
                paginate: true,
            }
        },

        mounted() {
            // Set the initial number of items
            this.totalRows = this.items.length
            if ( this.totalRows / this.perPage > 1) {
                this.paginate = true;
            } else {
                this.paginate = false;
            }
        },
        methods: {

            
            onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
                if ( this.totalRows / this.perPage > 1) {
                    this.paginate = true;
                } else {
                    this.paginate = false;
                }
            }
        },
    
    }
</script>