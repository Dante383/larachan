<template>
	<div>
    <input type="text" v-model="editKey" v-on:change="wrongKey = false" :class="'border-2 focus:ring-indigo-500 focus:border-indigo-500 block w-45 pl-7 sm:text-sm rounded-md float-left h-100 ' + (wrongKey ? 'border-red-500' : 'border-grey-light')" placeholder="Edit key">
    <button class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 rounded sm:text-sm ml-1 h-100" @click="handleDelete">Delete</button>
  </div>
</template>

<script>
	export default {
    props: ['entry_id'],
    components: {},
    data: function() {
      return {
        'editKey': '',
        'wrongKey': false
      }
    },
    methods: {
      handleDelete () {
        var that = this;

        this.axios.delete('/api/entry/' + this.entry_id, {data: {'edit_key': this.editKey}}).then((response) => {
          this.$emit('entry-deleted');
        }).catch(function (error){
          that.wrongKey = true;
          that.editKey = '';
        });
      }
    },
    mounted() {
    }
  }
</script>