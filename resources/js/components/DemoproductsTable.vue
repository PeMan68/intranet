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
                <b-form>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">Produkt</dt>
                            <dd class="col-sm-9">
                                <p class="font-weight-bolder">{{ row.item.Artikel }}</p>
                                <p>{{ row.item.Beskrivning }}</br>
                                    {{ row.item.E_nummer }}</p>
                            </dd>
                            <dt class="col-sm-3">Plats</dt>
                            <dd class="col-sm-9">
                                <b-form-select id="to-location" v-model="formfields.toLocation" :options="sortedLocations" value-field="id" text-field="name"></b-form-select>
                            </dd>
                            <dt class="col-sm-3">Anledning till flytt</dt>
                            <dd class="col-sm-9">
                                <b-form-input v-model="formfields.reason" placeholder="Obligatoriskt"></b-form-input>
                            </dd>
                            <dt class="col-sm-3">Status</dt>
                            <dd class="col-sm-9">
                                <b-form-select id="status" v-model="formfields.status" :options="statuses" value-field="id" text-field="description">
                                </b-form-select>
                            </dd>
                            <dt class="col-sm-3">Testad</dt>
                            <dd class="col-sm-9">
                                <b-form-checkbox id="tested" v-model="formfields.tested" value="Yes" unchecked-value="No"></b-form-checkbox>
                            </dd>
                            <dt class="col-sm-3">Orginalkartong</dt>
                            <dd class="col-sm-9">
                                <b-form-checkbox id="box" v-model="formfields.box" value="Yes" unchecked-value="No"></b-form-checkbox>
                            </dd>
                            <dt class="col-sm-3">Orginaldokument</dt>
                            <dd class="col-sm-9">
                                <b-form-checkbox id="doc" v-model="formfields.doc" value="Yes" unchecked-value="No"></b-form-checkbox>
                            </dd>
                            <dt class="col-sm-3">Serienummer</dt>
                            <dd class="col-sm-9">
                                <b-form-input v-model="formfields.serial" placeholder="Ev seriennummer"></b-form-input>
                            </dd>
                            <dt class="col-sm-3">Version</dt>
                            <dd class="col-sm-9">
                                <b-form-input v-model="formfields.version" placeholder="Ev version"></b-form-input>
                            </dd>
                            <dt class="col-sm-3">Kommentar</dt>
                            <dd class="col-sm-9">
                                <b-form-input v-model="formfields.comment" placeholder="Ev kommentar"></b-form-input>
                            </dd>
                            <dt class="col-sm-3" v-show="row.item.Inköpsdatum">Inköpsdatum</dt>
                            <dd class="col-sm-9" v-show="row.item.Inköpsdatum" v-if="row.item.Inköpsdatum">{{ new Date(row.item.Inköpsdatum) | dateFormat('MMMM YYYY') }}</dd>
                            <dt class="col-sm-3">Information uppdaterad</dt>
                            <dd class="col-sm-9">{{ new Date(row.item.Uppdaterad) | dateFormat('YYYY-MM-DD HH:mm') }}</dd>
                        </dl>

                        <b-button @click="submit" variant="success">Ändra</b-button>
                        <b-button @click="resetForm(row)">Återställ</b-button>
                    </div>
                </b-form>
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
        statuses: Array,
        user: Number,
    },

    data() {
        return {
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            filter: null,
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
                user: 0,

            },
            sortedLocations: [],
            oldRow: -1,
        };
    },

    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length
        this.formfields.user = this.user

        // store locations object in an array [{id: 1, name:'foo'},{id: 2, name:'bar'}]
        let strippedArray = []
        for (const [key, value] of Object.entries(this.locations)) {
            strippedArray.push({
                id: key,
                ...value
            })
        }
        // Sort strings by name with this algorithm
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
            // Inverterad därför att status är inte uppdaterad...next tic-nånting löser?
            if (!row.detailsShowing) {
                this.resetForm(row)
                }
        },
        resetForm(row) {
            this.formfields.itemId = row.item.Produkt_id
            this.formfields.toLocation = row.item.Plats_id
            this.formfields.fromLocation = row.item.Plats_id
            this.formfields.status = row.item.Status_id
            this.formfields.tested = row.item.Testad ? "Yes" : "No"
            this.formfields.box = row.item.Orginal_kartong ? "Yes" : "No"
            this.formfields.doc = row.item.Orginal_dokument ? "Yes" : "No"
            this.formfields.serial = row.item.Serienummer
            this.formfields.version = row.item.Version
            this.formfields.comment = row.item.Kommentar
            this.formfields.reason = ''
        },

    },

};
</script>
