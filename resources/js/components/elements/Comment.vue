<template>
	<div class="w-full lg:flex display-none mt-2">
  		<a target="_blank" :href="comment.image_fullres" v-if="comment.image_fullres"><img class="h-64 lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" 
        :src="comment.image_thumbnail"/></a>
  		<div class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
    		<div class="mb-8">
      			<p class="text-sm text-grey-dark flex items-center">
			    	  <span class="text-green-700 font-semibold">Anonymous</span>
			        <span class="ml-1 block">{{ new Date(comment.created_at).toDateString() }}</span>
			        <span class="ml-1 block">No.{{ comment.id }}</span>
			       </p>
             <span class="block mt-1 mb-2" v-if="comment.image_fullres">File: <a target="_blank" :href="comment.image_fullres">{{ comment.image_fullres.split('\\').pop().split('/').pop() }}</a></span>
      			<p class="text-grey-darker text-base">
            {{ comment.body }}
            </p>
    		</div>
  		</div>
	</div>
</template>

<script>
	export default {
    props: ['comment_id'],
    data: function() {
      return {
        "comment": {
          "id": "",
          "created_at": "",
          "body": "",
          "image_thumbnail": "",
          "image_fullres": "",
          "entry_id": ""
        }
      }
    },
    mounted() {
      var that = this; 

      this.axios.get('/api/comment/' + this.comment_id).then((response) => {
        that.comment = response.data;
      });
    }
  }
</script>