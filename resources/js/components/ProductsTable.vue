<template>
<b-container fluid>

    <b-table id="products-table" :primary-key="'ID'" :items="items" :fields="fields" :per-page="perPage" :current-page="currentPage" small borderless sticky-header="800px" sort-icon-left>
        <template #row-details="row">
            <div v-show="row.item.Ersättningar" class="card-body">
                <h5>Ersättningsprodukter</h5>
                <table>
                    <tr>
                        <th>Artikel</th>
                        <th>E-nummer</th>
                        <th>Benämning</th>
                        <th>Listpris</th>
                        <th>Uppdaterad</th>
                    </tr>
                    <div  v-for="replacement in row.item.Ersättningar" :key="replacement.replacement_product_id">
                    <tr>
                        <td>{{ replacement.item }}</td>
                        <td>{{ replacement.enummer }}</td>
                        <td>{{ replacement.item_description_swe }}</td>
                        <td>{{ replacement.listprice }}</td>
                        <td>{{ replacement.updated_at }}</td>
                    </tr>
                    <tr>
                        <td colspan="5">{{ replacement.pivot.comment }}</td>
                    </tr>
                    </div>
                </table>
            </div>
        </template>
    </b-table>
    <b-row v-show="totalRows>perPage" class="mb-2">

        <b-col>
            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" aria-controls="products-table"></b-pagination>
        </b-col>

    </b-row>
</b-container>
</template>

<script>
export default {
    props: {
        items: Array,
        fields: Array,
    },

    data() {
        return {
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            filterTable: '',
            age: null,
            formfields: {
                comment: '',
                status: 0,
                toLocation: 0,
                fromLocation: 0,
                itemId: 0,
                box: '',
                doc: '',
                tested: '',
                serial: '',
                version: '',
                reason: '',
                invoiceDate: '',
                user: 0,

            },
            sortedLocations: [],
            oldRow: -1,
            oldAge: null,
        };
    },

    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length
    },

    methods: {

    },

};
</script>
