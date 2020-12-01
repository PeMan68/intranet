<template>
    <b-form @submit.prevent="onSubmit">
        <!-- <input type="hidden" name="_token" :value="csrf"> -->
        <b-form-file
            name="attachment"
            v-model="file"
            
            placeholder="Välj en fil eller släpp den här..."
            drop-placeholder="Släpp fil här..."
            >
        </b-form-file>
        				<button type="submit" class="btn btn-primary m-2" name="save">
					Spara fil
				</button>
    </b-form>
</template>

<script>
  export default {
      props: [
          'id'
      ],
      
    data() {
      return {
        file: null,
        
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    },

    methods: {
        onSubmit() {
            let formData = new FormData();
            formData.append('file', this.file);
            formData.append('id', this.id);
            // evt.preventDefault()
            axios.post('/issues/attach', formData)
            .then((response) => {
                console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    }
  }
</script>
