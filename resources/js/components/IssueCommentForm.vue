<template>
<div class="container-fluid">
    <b-form-radio-group class="my-1" id="radio" v-model="direction">
        <b-form-radio value='internal'>Intern kommentar</b-form-radio>
        <b-form-radio value='in'>Inkommande meddelande</b-form-radio>
        <b-form-radio value='out'>Utgående meddelande</b-form-radio>
    </b-form-radio-group>

    <b-form-textarea class="form-style my-1" id="textarea" v-model="message" placeholder="Meddelande" rows="3" max-rows="30"></b-form-textarea>

    <b-form-group class="form-style my-1" v-show="direction != 'internal'" :label="direction == 'out' ? 'Till' : 'Från'" label-for="selected-contact">
        <b-form-select id="selected-contact" v-model="selected" :options="contacts">
            <template #first>
                <b-form-select-option value="0">Kundkontakt</b-form-select-option>
            </template>
        </b-form-select>
    </b-form-group>

    <b-form-radio-group v-show="direction != 'internal'" class="my-1" id="type" v-model="type">
        <b-form-radio value='mail'>E-post</b-form-radio>
        <b-form-radio value='phone'>Telefon</b-form-radio>
    </b-form-radio-group>

</div>
</template>

<style>
    .form-style {
        max-width: 50rem;
    }
</style>

<script>
export default {
    props: [
        'contacts',

    ],

    data() {
        return {
            direction: 'internal',
            type: 'mail',
            message: '',
            selected: 0,
            name: '',
            errors: {},
            loaded: true,
            success: false,
        }
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
