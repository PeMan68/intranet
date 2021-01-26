<template>
<div class="my-3">
    <b-form-radio-group v-on:change="changeType" class="my-1" id="direction" v-model="fields.direction">
        <b-form-radio value=0>Anteckning</b-form-radio>
        <b-form-radio value=2>Inkommande meddelande</b-form-radio>
        <b-form-radio value=1>Utgående meddelande</b-form-radio>
    </b-form-radio-group>

    <b-form-radio-group v-show="showType" class="my-1" id="type" v-model="fields.type">

        <b-form-radio v-show=false value=0>Intern</b-form-radio>
        <b-form-radio value=2>E-post</b-form-radio>
        <b-form-radio value=1>Telefon</b-form-radio>
    </b-form-radio-group>

    <b-form-group class="form-style my-1" v-show="fields.direction != 0" :label="fields.direction == 1 ? 'Till' : 'Från'" label-for="selected-contact">
        <b-form-select id="selected-contact" v-model="fields.selected" :options="contacts">
            <template #first>
                <b-form-select-option value="0">Kundkontakt</b-form-select-option>
            </template>
        </b-form-select>
    </b-form-group>

    <b-form-textarea class="form-style my-1" id="textarea" v-model="fields.message" placeholder="Meddelande" rows="3" max-rows="30"></b-form-textarea>

    <b-button @click="submit">Spara</b-button>

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
        'comment',
        'follow',

    ],

    data() {
        return {
            fields: {
                direction: 0,
                type: 0,
                message: '',
                selected: 0,

            },
            errors: {},
            loaded: true,
            success: false,
            showType: false,
        }
    },

    mounted() {
        this.fields.id = this.comment.id; // include comments id with form-post
        this.fields.follow = this.follow;
    },

    methods: {
        submit() {
            if (this.loaded) {
                this.loaded = false;
                this.success = false;
                this.errors = {};
                axios.post('/api/comment', this.fields).then(
                    response => {
                        // Clear input fields.
                        this.fields.direction = 0;
                        this.fields.type = 0;
                        this.fields.message = '';
                        this.fields.selected = 0;
                        this.loaded = true;
                        this.success = true;
                    }
                ).catch(error => {
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
                window.location.href = '/issues/' + this.comment.issue_id;
            }
        },

        changeType() {
            this.$nextTick(() => {
                console.log(this.fields.direction);
                if (this.fields.direction == '0') {
                    this.fields.type = 0;
                    this.fields.selected = 0;
                    this.showType = false;
                } else {
                    this.showType = true;
                }
            });
        },
    },

    };
</script>
