<template>
<b-container fluid>
    <b-row class="mb-2">
        <b-col class="my-1" cols="12" lg="3">
            <b-button variant="primary" size="sm" href="/contacts/create"><i class="material-icons">add_circle</i> Lägg till ny kontakt</b-button>
        </b-col>

        <b-col class="my-1" cols="12" lg="5" order-lg="3">
            <b-input-group size="sm">
                <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Sök" align="center" debounce="500"></b-form-input>
                <b-input-group-append>
                </b-input-group-append>
            </b-input-group>
        </b-col>

        <b-col class="my-1" cols="12" lg="4" order-lg="2">
            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" aria-controls="issue-contacs" align="center"></b-pagination>
        </b-col>
    </b-row>
    <b-table 
        id="contacts-table" 
        ref="table" 
        :items="contacts" 
        :per-page="perPage" 
        :current-page="currentPage" 
        :filter="filter"
        :fields="fields" 
        @filtered="onFiltered" 
        small 
        sticky-header="1000px" 
        sort-icon-left 
        responsive
        hover

        >
    <template #cell(intern)="data">
        <template v-if="data.item.Intern">Ja</template>
        <template v-else></template>
    </template>
    <template #cell(ändra)="data">
        <a :href="'/contacts/' + data.item.Id + '/edit'"><i class="material-icons">edit</i></a>
    </template>
    </b-table>
</b-container>
</template>

<script>
export default {
    props: [
        'contacts',
        'fields',
    ],

    data() {
        return {
            perPage: 20,
            currentPage: 1,
            totalRows: 1,
            filter: null,
            items: [],
        }
    },

    mounted() {
        // Set the initial number of items
        // this.items = this.contacts
        this.totalRows = this.contacts.length
    },

    methods: {
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length
            this.currentPage = 1
        },
    },
}
</script>
