<template>
<b-container fluid>

                <table class="table table-sm table-borderless">
                    <tr>
                        <th>Artikel</th>
                        <th>E-nummer</th>
                        <th>Benämning</th>
                        <th>Listpris</th>
                    </tr>
                    <tbody v-for="item in items" :key="item.id">
                    <tr>
                        <td>
                            <a :href="'products/' + item.ID">{{ item.Artikel }}</a> 
                            <b-badge v-if="item.Ersättningar.length>0" pill variant="info" >Ersättningar {{ item.Ersättningar.length }}</b-badge>
                            <b-badge v-if="item.Antal_i_demo>0" pill variant="warning" >Demo {{ item.Antal_i_demo }}</b-badge>
                            </td>
                        <td>{{ item.E_nummer }}</td>
                        <td>{{ item.Benämning}}</td>
                        <td>{{ item.Uppdaterad }}: {{ item.Listpris }}</td>

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
