<template>
<div class="container-fluid">
    <b-form-radio-group class="my-1" id="radio" v-model="direction">
        <b-form-radio value='internal'>Intern kommentar</b-form-radio>
        <b-form-radio value='in'>Inkommande meddelande</b-form-radio>
        <b-form-radio value='out'>Utgående meddelande</b-form-radio>
    </b-form-radio-group>

    <b-form-textarea class="my-1" id="textarea" v-model="message" placeholder="Meddelande" rows="3" max-rows="30"></b-form-textarea>

    <b-form-group class="my-1" v-show="direction != 'internal'" :label="direction == 'out' ? 'Till' : 'Från'" label-for="selected-contact">
        <b-form-select id="selected-contact" v-model="selected" :options="testcontacts">
            <template #first>
                <b-form-select-option value="0">Kundkontakt</b-form-select-option>
            </template>
        </b-form-select>
    </b-form-group>
    <b-form @submit.prevent="submit">
        <b-form-group class="my-2" label="Skapa ny kontakt">
            <b-form-input name="name" v-model="newcontactfields.name" placeholder="Namn"></b-form-input>
            <b-form-input name="email" v-model="newcontactfields.email" placeholder="E-postadress"></b-form-input>
            <b-form-input name="telephone" v-model="newcontactfields.telephone" placeholder="Telefonnummer"></b-form-input>
            <b-form-input name="company" v-model="newcontactfields.company" placeholder="Företag"></b-form-input>
        </b-form-group>

        <b-button type="submit">Spara</b-button>
    </b-form>
</div>
</template>

<script>
export default {
    props: [
        'contacts',

    ],

    data() {
        return {
            direction: 'internal',
            message: '',
            selected: 0,
            name: '',
            newcontactfields: {},
            errors: {},
            loaded: true,
            success: false,
            testcontacts: {},
        }
    },

    mounted() {
        axios.get('/getContacts')
            .then(({
                data
            }) => {
                this.testcontacts = data.data;
            });
    },

    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                axios.post('/contacts', this.newcontactfields).then(response => {
                    this.fields = {}; //Clear input fields.
                    this.loaded = true;
                    this.success = true;
                }).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },

    },
};
</script>
