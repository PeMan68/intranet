<template>

    <b-container fluid>
        <b-row class="mb-2">
            <b-col class="my-1" cols="12" sm="5" lg="3">
                <b-button variant="primary" size="sm" href="/issues/create"><i class="material-icons">add_circle</i> Nytt ärende</b-button>
            </b-col>

            <b-col class="my-1" cols="12" sm="7">
                <b-form-radio-group
                    v-model="scope"
                    :options="options"
                    name="radio-options"
                ></b-form-radio-group>
            </b-col>
        </b-row>
        <b-row class="mb-2">
            <b-col class="my-1" cols="12" sm="6" order-lg="3">
                <b-input-group size="sm">
                    <b-form-input
                    v-model="filter.text"
                    type="search"
                    id="filterInput"
                    placeholder="Sök i alla kolumner"
                    align="center"
                    ></b-form-input>
                    <b-input-group-append>
                    <b-button :disabled="!filter" @click="filter = ''">Rensa</b-button>
                    </b-input-group-append>
                </b-input-group>
                </b-form-group>
            </b-col>

            <b-col class="my-1" cols="12" sm="6" order-lg="2">
                <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    aria-controls="issue-table"
                    align="center"
                ></b-pagination>
            </b-col>        
        </b-row>

        <b-table 
            id="issue-table"
            ref="table"
            :items="items"
            :fields="fields"
            :per-page="perPage"
            :current-page="currentPage"
            :filter="filter.text"
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
            <template #cell(info)="row">
                <div class="small">
                    <b-badge :variant="row.item._rowVariant" href="#" @click="row.toggleDetails">
                        <i v-if="row.detailsShowing" class="material-icons">expand_less</i>
                        <i v-else class="material-icons">expand_more</i>
                    </b-badge>
                </div>
            </template>

            <template #row-details="row">
                <b-card >
                    <template v-if="row.item._rowVariant== 'danger'">
                        <div class="alert alert-danger">
                            <h4 class="font-weight-bolder text-center">Kunden har ännu inte fått en första feedback! Kontakta kunden snarast!</h4>
                        </div>
                    </template>
                    <template v-if="row.item._rowVariant== 'primary'">
                        <div class="alert alert-primary">
                            <h5 class="font-weight-bolder text-center">Ärendet tillhör till primära ansvarsområde</h5>
                        </div>
                    </template>
                    <template v-if="row.item._rowVariant== 'secondary'">
                        <div class="alert alert-secondary">
                            <h6 class="font-weight-bolder text-center">Ärendet tillhör till sekundära ansvarsområde</h6>
                        </div>
                    </template>
                    <b-row class="my-2 mx-0">
                        <b-col sm="3" class="text-sm text-nowrap">
                            <template v-if="row.item.vip">
                                <i class="material-icons">favorite</i> = VIP-kund<br>
                            </template>
                            <template v-if="row.item.prio == 2">
                                <i class="material-icons">grade</i> = Hög prio<br>
                            </template>
                            <template v-if="row.item.contacted">
                                <i class="material-icons">how_to_reg</i> = Första kontakt gjord<br>
                            </template>
                            <template v-if="row.item.wait">
                                <i class="material-icons">snooze</i> = Väntar på svar<br>
                            </template>
                            <template v-if="row.item.pause">
                                <i class="material-icons">pause_circle_filled</i> = Pausad<br>
                            </template>
                        </b-col>
                        <b-col sm="3">
                            <table class="table-sm">
                                <tr>
                                    <td><b>Kontakt:</b></td><td>{{ row.item.Kontakt }}</td>
                                </tr>
                                <tr>
                                    <td><b>E-post:</b></td><td>{{ row.item.E_post }}</td>
                                </tr>
                                <tr>
                                    <td><b>Telefon:</b></td><td>{{ row.item.Telefon }}</td>
                                </tr>
                            </table>
                        </b-col>
                        <b-col>
                            <template v-if="row.item.Senaste_kommentar != null">
                                <b>Senaste kommentar: </b>{{ row.item.Senaste }}<br>
                                {{ row.item.Senaste_kommentar }}<br>
                            </template>
                            <template v-else>
                                <b>Ärendebeskrivning:</b><br>
                                {{ row.item.Ärende_beskrivning }}
                            </template>                
                        </b-col>
                    </b-row>

                    <b-button size="sm" :href="'/issues/' + row.item.Id ">Öppna ärendet</b-button>
                </b-card>
            </template>
        </b-table>
    </b-container>
</template>

<script>
    
    // ? Arbetsidé
    // Skicka alla issues till table
    // skapa computed property: ta bort alla issues som har timeClosed>30 dagar
    // Denna ska laddas som default data till tabellen
    // om man börjar skriva i filter, växla till Alla data
    
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
                filter: {
                    text: null,
                },
                    scope: 'Month',
                        options: [
                            { text: 'Alla', value: 'All' },
                            { text: '1 År', value: 'Year'},
                            { text: '1 Månad', value: 'Month'},
                    ]
                
            }
        },

       
        mounted() {
            // Set the initial number of items
            this.totalRows = this.items.length
        },
        watch: {
            scope: {
                handler: function(value) {
                    if (value=='All') {
                        // this.items = itemsAll
                        console.log('Alla')
                    }
                    if (value=='Year') {
                        // this.items = itemsYear
                        console.log('År')
                    }
                    if (value=='Month') {
                        // this.items = itemsMonth
                        console.log('Månad')
                    }
                    this.$refs.table.refresh()
                },
            }
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