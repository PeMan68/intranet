<template>
<b-overlay :show="showspinner">
    <b-form @submit.prevent="onSubmit">
        <!-- <input type="hidden" name="_token" :value="csrf"> -->
        <b-form-file
            name="attachment"
            v-model="file"
            browse-text="Bläddra"
            size="lg"
            placeholder="Välj en fil eller släpp den här..."
            drop-placeholder="Släpp fil här..."
            >
        </b-form-file>
            <div>
        				<button :disabled="file == null" type="submit" class="btn btn-primary m-2" name="save">
					Spara fil
				</button>
        <b-button @click="file = null">Rensa</b-button>
            </div>
    </b-form>
</b-overlay>
</template>

<script>
  export default {
      props: [
          'id'
      ],
      
    data() {
      return {
        file: null,
        showspinner: false,
        
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    },

    methods: {
        onSubmit() {
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('id', this.id);
            this.showspinner = true;
            // evt.preventDefault()
            axios.post('/issues/attach', formData)
            .then((response) => {
                console.log(response);
                this.file = null;
                this.showspinner = false;
                window.location.href = '/issues/' + this.id;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
  }
</script>
