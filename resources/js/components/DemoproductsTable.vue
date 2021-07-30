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
    <b-table id="demoproducts-table" :primary-key="'ID'" :items="items" :fields="fields" :per-page="perPage" :current-page="currentPage" :filter="filter" @filtered="onFiltered" small sticky-header="800px" sort-icon-left>
        <template #cell(info)="row">
            <b-badge href="#" @click="toggleRow(row)">
                <i v-if="row.detailsShowing" class="material-icons">expand_less</i>
                <i v-else class="material-icons">expand_more</i>
            </b-badge>
        </template>

        <template #row-details="row">
            <div class="card bg-light mb-3">
                <div class="card-header">
                    <h4>Detaljer</h4>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Produkt</dt>
                        <dd class="col-sm-9">
                            <p class="font-weight-bolder">{{ row.item.Artikel }}</p>
                            <p>{{ row.item.Beskrivning }}</br>
                                {{ row.item.E_nummer }}</p>
                        </dd>
                        <dt class="col-sm-3">Plats</dt>
                        <dd class="col-sm-9 font-italic">{{ row.item.Plats }}</dd>
                        <dt class="col-sm-3">Status</dt>
                        <dd class="col-sm-9">{{ row.item.Status }}</dd>
                        <dt class="col-sm-3">Testad</dt>
                        <dd class="col-sm-9">{{ row.item.Testad ? "OK" : "Nej" }}</dd>
                        <dt class="col-sm-3">Orginalkartong</dt>
                        <dd class="col-sm-9">{{ row.item.Orginal_kartong ? "Ja" : "Ej verifierat" }}</dd>
                        <dt class="col-sm-3">Orginaldokument</dt>
                        <dd class="col-sm-9">{{ row.item.Orginal_dokument ? "Ja" : "Ej verifierat" }}</dd>
                        <dt class="col-sm-3" v-show="row.item.Serienummer">Serienummer</dt>
                        <dd class="col-sm-9" v-show="row.item.Serienummer">{{ row.item.Serienummer }}</dd>
                        <dt class="col-sm-3" v-show="row.item.Version">Version</dt>
                        <dd class="col-sm-9" v-show="row.item.Version">{{ row.item.Version }}</dd>
                        <dt class="col-sm-3" v-show="row.item.Inköpsdatum">Inköpsdatum</dt>
                        <dd class="col-sm-9" v-show="row.item.Inköpsdatum" v-if="row.item.Inköpsdatum">{{ new Date(row.item.Inköpsdatum) | dateFormat('MMMM YYYY') }}</dd>
                        <dt class="col-sm-3">Information uppdaterad</dt>
                        <dd class="col-sm-9">{{ new Date(row.item.Uppdaterad) | dateFormat('YYYY-MM-DD HH:mm') }}</dd>
                    </dl>

                    <b-button>Plocka ut från demolager</b-button>
                    <h5>
                        Flytta denna produkt från
                        <span class="font-italic">{{ row.item.Plats }}</span> till:
                    </h5>

                    <!-- TEstar standard select funkar ej så bra -->
                    <!-- <div class="form-group">
                <label for="to-location">Välj produkt</label>
                <select class="form-control" id="to-location" name="to-location">
                    <div  v-for="location in locations" :key="location.name">
                    <option :value="location.id">{{ location.name }}</option>
                    </div>
                </select>
            </div> -->

                    <b-form-select id="to-location" v-model="formfields.toLocation" :options="sortedLocations" value-field="id" text-field="name">

                        <b-form-select-option id="to-location" value="demo">till kunddemo</b-form-select-option>
                        <template #first>
                            <b-form-select-option :value="null" disabled>-- Please select an option --</b-form-select-option>
                        </template>
                    </b-form-select>

                    <div class="mt-3">Selected: <strong>{{ formfields.toLocation }}</strong></div>

                    <b-form-text id="comment" v-model="formfields.comment"> </b-form-text>

                    <b-button @click="submit">Flytta</b-button>
                </div>
            </div>
        </template>
    </b-table>
</b-container>
</template>

<script>
export default {
    props: {
        items: Array,
        fields: Array,
        locations: Object,
    },

    data() {
        return {
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            filter: null,
            formfields: {
                comment: "",
                toLocation: 0,
                fromLocation: 0,
                itemId: 0,
            },
            sortedLocations: [],
            oldRow: -1,
        };
    },

    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length;

        let strippedArray = []
        for (const [key, value] of Object.entries(this.locations)) {
            strippedArray.push({
                id: key,
                ...value
            })
        }
        // Sort strings with this algorithm
        this.sortedLocations = strippedArray.sort(function (a, b) {
            let x = a.name.toLowerCase()
            let y = b.name.toLowerCase()
            if (x < y) {
                return -1
            }
            if (x > y) {
                return 1
            }
            return 0
        })
    },

    methods: {
        submit() {
            axios.post("/api/movedemoproduct", this.formfields);
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            this.totalRows = filteredItems.length;
            this.currentPage = 1;
        },
        toggleRow(row) {
            // close previous details if open
            if (row.detailsShowing) {
                this.oldRow = -1
            } else {
                if (this.oldRow !== -1) {
                    this.oldRow.toggleDetails()
                }
                this.oldRow = row
            }
            row.toggleDetails()

            // Load form-data for opened row
            if (row.detailsShowing) {
                this.formfields.toLocation = 'laddad från script'
            }
        }

    },
};
</script>
