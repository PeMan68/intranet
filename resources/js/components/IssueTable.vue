<template>

    <b-container fluid>
        <b-row class="mb-2">
            <b-col sm="2">
                <b-button size="sm" href="issues/create">Nytt ärende</b-button>
            </b-col>
            <b-col sm="5">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="issue-table"
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
            id="issue-table"
            :items="items"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            :filter="filter"
            @filtered="onFiltered"
            small
            sticky-header="400px"
            sort-icon-left
            responsive
            >

            <template #head()="data">
                <span class="text-nowrap">{{ data.label }}</span>
            </template>
            <template #cell()="data">
                <span class="text-nowrap">{{ data.value }}</span>
            </template>
            <template #cell(.)="data">
                <span class="text-nowrap">
                <i v-if="data.item.finish" class="material-icons">done_all</i>
                <i v-if="data.item.prio == 2 && !data.item.finish" class="material-icons">grade</i>
                <i v-if="data.item.vip && !data.item.finish" class="material-icons">favorite</i>
                <i v-if="data.item.wait && !data.item.finish" class="material-icons">snooze</i>
                <i v-if="data.item.pause && !data.item.finish" class="material-icons">pause_circle_filled</i>
                <i v-if="data.item.contacted && !data.item.finish" class="material-icons">how_to_reg</i>
                </span>
                <span class="text-nowrap">{{ data.value }}</span>
            </template>
            <template #cell(visa_detaljer)="row">
                <b-button size="sm" @click="row.toggleDetails" class="mr-2 text-nowrap">
                    {{ row.detailsShowing ? 'Dölj' : 'Visa'}} Detaljer
                </b-button>
            </template>

            <template #row-details="row">
                <b-card>
                    <i>Registrerat {{ row.item.Registrerat }} av {{ row.item.Skapad_av }}</i>
                <b-row class="mb-2">
                    <b-col sm="3" class="text-sm text-nowrap">
                        <template v-if="row.item.vip">
                            <i class="material-icons">favorite</i> = VIP-kund<br>
                        </template>
                        <template v-if="row.item.prio == 2">
                            <i class="material-icons">grade</i> = Hög prio<br>
                        </template>
                        <template v-if="row.item.contacted">
                            <i class="material-icons">how_to_reg</i> = Första kontakt klar<br>
                        </template>
                        <template v-if="row.item.wait">
                            <i class="material-icons">snooze</i> = Framflyttad<br>
                        </template>
                        <template v-if="row.item.pause">
                            <i class="material-icons">pause_circle_filled</i> = Pausad<br>
                        </template>
                    </b-col>
                    <b-col sm="2" class="text-sm">
                        <b>Kund:</b> {{ row.item.Kund }}<br>
                        <b>E-post:</b> {{ row.item.E_post }}<br>

                    </b-col>
                    <b-col></b-col>
                </b-row>

                <b-button size="sm" @click="row.toggleDetails">Hide Details</b-button>
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
                perPage: 10,
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