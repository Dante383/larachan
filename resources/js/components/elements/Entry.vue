<template>
	<div>
		<div class="w-full lg:flex">
	  		<a target="_blank" :href="entry.image.fullres" v-if="entry.image"><img class="h-64 lg:max-w-64 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden" 
	  		:src="entry.image.thumbnail"/></a>
	  	
	  		<div class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
	    		<div class="mb-8">
	      			<p class="text-sm text-grey-dark flex items-center">
				    	<span class="text-green-700 font-semibold">Anonymous</span>
				        <span class="ml-1">{{ new Date(entry.created_at).toDateString() }}</span>
				        <span class="ml-1">No.{{ entry.id }}</span>
				    </p>
				    <span class="block mt-1 mb-2" v-if="entry.image">File: <a target="_blank" :href="entry.image.fullres">{{ entry.image.fullres }}</a></span>
	      			<div class="text-black font-bold text-xl mb-2" v-if="entry.title">{{ entry.title }}</div>
	      			<p class="text-grey-darker text-base">{{ entry.body }}</p>
	    		</div>
	    		<div class="flex items-center">
	      			<div class="text-sm">
	        			<p class="text-black leading-none" v-if="((this.entry.comments.length-2 > 0) && !commentsExpanded)">{{ this.entry.comments.length-2 }} replies omitted.</p>
	        		</div>
	        		<div class="text-sm ml-2">
	        			<a @click="deleteBoxVisible = true" class="text-blue-500 cursor-pointer">Delete</a>
	      			</div>
	        		<div class="text-sm ml-2">
	        			<a @click="toggleComments" class="text-blue-500 cursor-pointer">{{ commentsExpanded ? 'Hide' : 'Expand' }}</a>
	      			</div>
	      			<div class="text-sm ml-2">
	        			<a @click="replyBoxVisible = true" class="text-blue-500 cursor-pointer">Reply</a>
	      			</div>
	    		</div>
	  		</div>
		</div>
		<div class="ml-16">
			<transition-group 
			tag="div"
			enter-active-class="transition-all transition-fastest ease-out-quad"
			leave-active-class="transition-all transition-faster ease-in-quad"
			enter-class="opacity-0 scale-70"
			enter-to-class="opacity-100 scale-100"
			leave-class="opacity-100 scale-100"
			leave-to-class="opacity-0 scale-70"
			>
  				<Comment v-for="comment in comments" v-bind:key="comment.id" :comment_id="comment.id"/>
  			</transition-group>
  			<ReplyBox v-if="replyBoxVisible" :entry_id="this.entry_id" v-on:reply-posted="replyPosted"/>
  		</div>
	</div>
</template>

<script>
	import Comment from './Comment.vue'
	import ReplyBox from './ReplyBox.vue'
	
	export default {
		name: 'Entry',
		components: {Comment, ReplyBox},
		props: ['entry_id'],
		data: function() {
			return {
				'entry': {
					'id': '',
					'created_at': '',
					'title': '',
					'body': '',
					'image': {
						"thumbnail": '',
						"fullres": ''
					},
					'comments': []
				},
				'comments': [],
				'commentsExpanded': false,
				'replyBoxVisible': false,
				'deleteBoxVisible': false
			}
		},
		methods: {
			toggleComments () {
				if (this.commentsExpanded) {
					this.comments = this.entry.comments.slice(this.entry.comments.length-2, this.entry.comments.length);
				}
				else
				{
					this.comments = this.entry.comments;
				}
				this.commentsExpanded = !this.commentsExpanded;
			},
			replyPosted (reply) {
				this.comments.push(reply);
			}
		},
		mounted() {
			var that = this; 

            this.axios.get('/api/entry/' + this.entry_id).then((response) => {
                that.entry = response.data;
                that.comments = that.entry.comments.slice(that.entry.comments.length-2, that.entry.comments.length);
            });
		}
	}
</script>