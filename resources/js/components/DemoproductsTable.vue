<template>
<b-container fluid>
    <b-row class="mb-2">
        <b-col sm="2">
            <b-button variant="primary" size="sm" href="demoproducts/create"><i class="material-icons">add_circle</i>Lägg in produkt</b-button>
        </b-col>
        <b-col sm="5">
            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" aria-controls="demoproducts-table"></b-pagination>
        </b-col>

        <b-col sm="5">
            <b-form-group label="Filter" label-cols-sm="3" label-align-sm="right" label-size="sm" label-for="filterInput" class="mb-0">
                <b-input-group size="sm">
                    <b-form-input v-model="filter" type="search" id="filterInput" placeholder="Sök"></b-form-input>
                    <b-input-group-append>
                        <b-button :disabled="!filter" @click="filter = ''">Rensa</b-button>
                    </b-input-group-append>
                </b-input-group>
            </b-form-group>
        </b-col>
    </b-row>
    <b-table id="demoproducts-table" :items="items" :fields="fields" :per-page="perPage" :current-page="currentPage" :filter="filter" @filtered="onFiltered" small sticky-header="800px" sort-icon-left>
        <template #cell(info)="row">
            <b-badge href="#" @click="row.toggleDetails">
                <i v-if="row.detailsShowing" class="material-icons">expand_less</i>
                <i v-else class="material-icons">expand_more</i>
            </b-badge>
        </template>

        <template #row-details="row">
                <b-table-simple small striped bordered hover>
                    <b-tr>
                        <b-td>Beskrivning</b-td>
                        <b-td>{{ row.item.Beskrivning }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>E-nummer</b-td>
                        <b-td>{{ row.item.E_nummer }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Status</b-td>
                        <b-td>{{ row.item.Status }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Kommentar</b-td>
                        <b-td>{{ row.item.Kommentar }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Plats</b-td>
                        <b-td>{{ row.item.Plats }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Testad</b-td>
                        <b-td>{{ row.item.Testad ? "OK" : "Nej" }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Orginalkartong</b-td>
                        <b-td>{{ row.item.Orginal_kartong ? "OK" : "Nej" }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Orginaldokument</b-td>
                        <b-td>{{ row.item.Orginal_dokument ? "OK" : "Nej" }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Serienummer</b-td>
                        <b-td>{{ row.item.Serienummer }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Version</b-td>
                        <b-td>{{ row.item.Version }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Inköpsdatum</b-td>
                        <b-td v-if="row.item.Inköpsdatum">{{ new Date(row.item.Inköpsdatum) | dateFormat('MMMM YYYY') }}</b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Senast uppdaterad</b-td>
                        <b-td>{{ new Date(row.item.Uppdaterad) | dateFormat('YYYY-MM-DD HH:mm') }}</b-td>
                    </b-tr>
                </b-table-simple>
        </template>
    </b-table>
</b-container>
</template>

<script>
export default {
    props: ["items", "fields"],

    data() {
        return {
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            filter: null,
        };
    },

    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length;
    },
    methods: {
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
    },
};
</script>
