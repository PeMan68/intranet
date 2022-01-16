<template>
<b-container fluid>

                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Artikel</th>
                        <th>E-nummer</th>
                        <th>Benämning</th>
                        <th>Listpris</th>
                        <th>Uppdaterad</th>
                        <th>Kommentar</th>
                    </tr>
                    <tbody v-for="item in items" :key="item.id">
                    <tr>
                        <td>{{ item.Artikel }} {{item.Antal_i_demo>0?'Finns':''}}</td>
                        <td>{{ item.Enummer }}</td>
                        <td>{{ item.Benämning}}</td>
                        <td class="justify-right">{{ item.Listpris }}</td>
                        <td>{{ item.Uppdaterad }}</td>

                    </tr>
                        <tr class="bg-light" v-for="replacement in item.Ersättningar" :key="replacement.item.id">
                            <td><i class="material-icons">subdirectory_arrow_right</i> 
                            <a :href="'products?filter=' + replacement.item">{{ replacement.item }}</a> </td>
                            <td> {{ replacement.enummer }}</td>
                            <td> {{ replacement.item_description_swe }}</td>
                            <td class="justify-right"> {{ replacement.listprice }}</td>
                            <td> {{ replacement.updated_at }}</td>
                            <td> {{ replacement.pivot.comment }}</td>
                        </tr>
                    </tbody>
                </table>
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

        };
    },


    methods: {

    },

};
</script>
