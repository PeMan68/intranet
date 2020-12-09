<template>

    <b-container fluid>
        <b-row class="mb-2">
            <b-col sm="2">
                <b-button v-show="false" variant="primary" size="sm" href="/issues/create"><i class="material-icons">add_circle</i> Lägg till artikel</b-button>
            </b-col>
            <b-col sm="5">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="posts"
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
                    debounce="500"
                    ></b-form-input>
                    <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''">Rensa</b-button>
                    </b-input-group-append>
                </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>
        <b-table 
            id="posts"
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
            <template #cell(Visa)="row">
                <div class="small">
                    <b-badge href="#" @click="row.toggleDetails">
                        <i v-if="row.detailsShowing" class="material-icons">expand_less</i>
                        <i v-else class="material-icons">expand_more</i>
                    </b-badge>
                </div>
            </template>

            <template #row-details="row">
               
                <b-card
                    :title="row.item.Rubrik"
                    :sub-title="row.item.Grupp"
                    :img-src="row.item.Image"
                    img-bottom
                    bg-variant="primary"
                >
                    <b-card-text class="h5">
                        {{ row.item.Kapitel }}
                    </b-card-text>
                    <b-card-footer :footer-html="row.item.Text">
                    </b-card-footer>
                    
                </b-card>
            </template>
        </b-table>
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
                perPage: 20,
                currentPage: 1,
                totalRows: 1,
                filter: null,
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