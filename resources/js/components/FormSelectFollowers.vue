<template>
<div>
    <b-form @submit.prevent="onSubmit">
        <b-select v-model="selected" :options="userlist" value-field="id" text-field="name"></b-select>
        <b-button v-b-tooltip.hover size="sm" type="submit" class="btn btn-success m-2" name="save" title="Lägg till andra användare så de får uppdateringar om ärendet">
            Lägg till följare
            <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
        </b-button>
    </b-form>
</div>
</template>

<script>
export default {
    props: [
        'issueId',
        'users',
    ],

    data() {
        return {
            selected: null,
            userlist: [],
            // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },

    mounted() {
        // store users object in an array [{id: 1, name:'foo'},{id: 2, name:'bar'}]
        // let userlist = []
        for (const [key, value] of Object.entries(this.users)) {
            this.userlist.push({
                id: key,
                ...value
            })
        }
    },

    methods: {
        onSubmit() {
            let formData = new FormData();
            formData.append('user', this.selected);
            formData.append('issueId', this.issueId);
            // evt.preventDefault()
            axios.post('/issues/addfollower', formData)
                .then((response) => {
                    console.log(response);
                    window.location.href = '/issues/' + this.issueId;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    },
}
</script>
