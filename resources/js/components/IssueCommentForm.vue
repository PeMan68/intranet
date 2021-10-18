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

    <b-form-group v-b-popover.hover.right="'Saknar du en kontakt? Lägg till via menyn Hantera kontakter'" class="form-style my-1" v-show="fields.direction != 0" :label="fields.direction == 1 ? 'Till' : 'Från'" label-for="selected-contact">
        <b-form-select id="selected-contact" v-model="fields.selected" :options="contacts">
        </b-form-select>
    </b-form-group>
    <div v-show="outgoingMail" class="form-style mail-header my-1">--- Skapa Mail ---

    </div>
    <b-form-group v-show="outgoingMail" class="form-style my-1" label-cols="auto" label="Till:">
        <b-form-input id="subject" disabled v-model="fields.selected.email"></b-form-input>
    </b-form-group>
    
    <b-form-group v-show="outgoingMail" class="form-style" label-cols="auto" label="Ämnesrad:">
        <b-form-input id="subject" v-model="fields.subject"></b-form-input>
    </b-form-group>
    
    <b-form-textarea class="form-style my-1" id="textarea" v-model="fields.message" placeholder="Meddelande" rows="3" max-rows="30"></b-form-textarea>
    <div v-show="outgoingMail" class="form-style mail-header my-1">---</div>

    <b-button 
        v-show="outgoingMail" 
        size="sm" 
        v-b-tooltip.hover title="Skapa mail av ovanstående från din egen e-post. OBS! Spara anteckningen separat efteråt!"
        :href="'mailto:' + fields.selected.email + '?subject=' + fields.subject + '&body=' + encodeURIComponent(fields.message)">1. Kopiera till e-post
        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
        </b-button>
    <span v-show="outgoingMail" class="mail-header"> + </span>
    <b-button 
        size="sm" 
        variant="success" 
        @click="submit"
        v-b-tooltip.hover title="Spara som ny anteckning och ladda om sidan">{{ outgoingMail ? '2. ':''}} Spara anteckning
        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
        </b-button>
    <span v-show="outgoingMail" class="mail-header"> ...eller... </span>
    <b-button 
        v-show="outgoingMail" 
        size="sm" 
        variant="success" 
        @click="submitAndSend"
        v-b-tooltip.hover :title="'Spara anteckningen och anteckningen skickas automatiskt från ' + from"
        > Spara och skicka mail
        <i class="material-icons white md-18 ml-1" style="vertical-align: middle;">help</i>
        </b-button>

</div>
</template>

<style>
.form-style {
    max-width: 50rem;
}
.mail-header {
    text-align: center;
    color: darkslategray;
    font-size: 1.5rem;
}
</style>

<script>
export default {
    props: {
        contacts: Array,
        comment: Object,
        follow: Number,
        auth_user: Number,
        ticket: String,
        header: String,
        from: String,

    },

    data() {
        return {
            fields: {
                direction: 0,
                type: 0,
                message: '',
                selected: 0,
                subject: '',
                send: false,
            },
            errors: {},
            loaded: true,
            success: false,
            showType: false,
        }
    },

    mounted() {
        this.fields.id = this.comment.id // include comments id with form-post
        this.fields.follow = this.follow
        this.fields.user_id = this.auth_user // include user id with post
        this.fields.subject = this.ticket + ': ' + this.header
        // this.fields.header = this.header
    },
    computed: {
        outgoingMail : function() {

            if (this.fields.direction == 1 && this.fields.type == 2) {
                return true
            } else {
                return false
            }
        }
    },

    methods: {
        submitAndSend() {
            this.fields.send = true;
            this.submit();
        },
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
                        this.fields.send = false;
                        window.location.href = '/issues/' + this.comment.issue_id;
                    }
                ).catch(error => {
                    console.log(error)
                    this.loaded = true;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },

        changeType() {
            this.$nextTick(() => {
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
