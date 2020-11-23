<template>
  <div>
    <b-form-input list="my-list-id" id="product_name" name="product_id" :formatter="formatter" ></b-form-input>
    <datalist id="my-list-id">
      <option v-for="item in items" :data-value="item.id">{{ item.item }}</option>
    </datalist>
  </div>
    <!-- <input type="hidden" name="product_id" v-model="id"> -->
</template>

<script>
  export default {
      props: {
          items: {
            type: Array
          }
      },

    data() {
      return {
        id: 0,
        sizes: ['Small', 'Medium', 'Large', 'Extra Large']
      }
    },

    methods: {
      formatter(value){
        return value.toUpperCase()
      }
    },
  }
</script>