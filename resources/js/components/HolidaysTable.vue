<template>
<b-container fluid>
    <b-row class="mb-2">
        <b-col sm="3">
            <b-button variant="primary" size="sm" :href="link"><i class="material-icons">add_circle</i>
                <slot></slot>
            </b-button>
        </b-col>
    </b-row>
    <b-table 
        id="table" 
        :items="items" 
        :fields="fields" 
        :per-page="perPage" 
        :current-page="currentPage" 
        small 
        sticky-header="1000px" 
        responsive>
        <template #head()="data">
            <span class="text-nowrap">{{ data.label }}</span>
        </template>
        <template #cell(Ändra)="data">
            <b-button variant="primary" size="sm" :href="'/holidays/edit/' + data.item.Ändra">
                <i class="material-icons">edit</i>
               
            </b-button>
        </template>
        <template #cell(Halvdag)="data">
            <span class="text-nowrap">{{ data.value==1?'Halv dag':'Hel dag' }}</span>
        </template>
        <template #cell()="data">
            <span class="text-nowrap">{{ data.value }}</span>
        </template>
    </b-table>
    <b-row>
        <b-col>
            <hr>
            <b-pagination v-show="paginate" v-model="currentPage" :total-rows="totalRows" :per-page="perPage" aria-controls="table"></b-pagination>
        </b-col>
    </b-row>
</b-container>
</template>

<script>
export default {
    props: ["items", "fields", "link"],

    data() {
        return {
            perPage: 10,
            currentPage: 1,
            totalRows: 1,
            paginate: true,
        };
    },

    mounted() {
        // Set the initial number of items
        this.totalRows = this.items.length;
        if (this.totalRows / this.perPage > 1) {
            this.paginate = true;
        } else {
            this.paginate = false;
        }
    },
};
</script>
