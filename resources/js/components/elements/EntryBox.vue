<template>
	<div class="w-50 lg:flex mt-2">
  		<div class="h-64 lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden bg-white" @click="handleFileContainerClick">
        <div class="flex w-100 h-100 inline-block border border-blue-400 border-r-0 cursor-pointer hover:bg-blue-400 hover:text-white">
          <label class="w-48 flex flex-col items-center px-4 py-6 text-blue rounded-lg tracking-wide uppercase mb-auto mt-auto">
              <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" v-if="!file">
                  <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
              </svg>
              <span :class="'mt-2 leading-normal break-all ' + (file ? 'text-sm' : 'text-base')">{{ file ? file.files[0].name : 'Select a file' }}</span>
              <span v-if="file" class="'mt-2 leading-normal break-word text-base">Click here to remove file</span>
              <input type='file' ref="file" class="hidden" v-on:change="fileChanged" :disabled="file != ''"/>
          </label>
        </div>
       </div>
  		<div class="h-64 border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
        <div class="m-2">
          <div class="float-left">
            <label for="title" class="float-left mr-2">Title</label>
            <input type="text" v-model="title" id="title" class="w-96 border-grey-400 focus:ring-indigo-500 focus:border-indigo-500 block w-45 pl-7 sm:text-sm border border-grey-light rounded-md float-left" placeholder="Title">
          </div>
          <div class="float-left">
            <label for="editkey" class="float-left mr-2">Edit key</label>
            <input type="text" id="editkey" v-model="editKey" class="w-96 focus:ring-indigo-500 focus:border-indigo-500 block w-45 pl-7 sm:text-sm border border-grey-light rounded-md float-left" placeholder="Edit key">
          </div>
        </div>
    		<div class="">
            <quill-editor
            ref="entryEditor"
            v-model="content"
            :options="editorOptions"
            />
    		</div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="sendEntry">Send</button>
  		</div>
	</div>
</template>

<script>
  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'
  import 'quill/dist/quill.bubble.css'

  import { quillEditor } from 'vue-quill-editor'

	export default {
    props: ['board_id'],
    components: { quillEditor },
    data: function() {
      return {
        content: '',
        editorOptions: {
          placeholder: 'Enter your comment here',
          formats: ['italic', 'bold']
        },
        title: '',
        editKey: '',
        file: ''
      }
    },
    methods: {
      sendEntry () {
        var that = this;

        let data = {
          'title': this.title,
          'body': this.content,
          'board_id': this.board_id,
          'edit_key': this.editKey
        }

        this.axios.post('/api/entry', data=data).then((response) => {
          that.$emit('entry-posted', response.data);
          that.title = '';
          that.content = '';
          that.edit_key = '';
        });
      },
      fileChanged (event) {
        this.file = event.target;
      },
      handleFileContainerClick (e) {
        if (this.file) {
          e.preventDefault();
          this.$refs.file.value = null;
          this.file = '';
        }
      }
    }
  }
</script>

<style scoped>
.quill-editor {
  height: 65%;
}
</style>