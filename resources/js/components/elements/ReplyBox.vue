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
  		<div class="border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r flex flex-col justify-between leading-normal">
    		<div class="mb-8 h-100">
            <quill-editor
            ref="entryEditor"
            v-model="content"
            :options="editorOptions"
            />
    		</div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" @click="sendReply">Send</button>
  		</div>
	</div>
</template>

<script>
  import Dropzone from "dropzone";

  import 'quill/dist/quill.core.css'
  import 'quill/dist/quill.snow.css'
  import 'quill/dist/quill.bubble.css'

  import { quillEditor } from 'vue-quill-editor'

	export default {
    props: ['entry_id'],
    components: { quillEditor },
    data: function() {
      return {
        content: '',
        editorOptions: {
          placeholder: 'Enter your comment here',
          formats: ['italic', 'bold']
        },
        file: ''
      }
    },
    methods: {
      sendReply () {
        var that = this; 

        let data = {
          'body': this.content,
          'entry_id': this.entry_id
        }

        this.axios.post('/api/comment', data=data).then((response) => {
          console.log(response);
          that.$emit('reply-posted', response.data);
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
    },
    mountedd() {
      Dropzone.autoDiscover = false;

      this.uploadDropzone = new Dropzone("#dropzone", {
        url: '/action',
        previewTemplate: `
        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
        </svg>`,
        maxFiles: 1,
        maxFilesize: 5,
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        success: function (file, response) {

        }
      });
    },
    beforeDestroy() {
      if (this.uploadDropzone) {
        this.uploadDropzone.destroy();
      }
    }
  }
</script>

<style scoped>
.quill-editor {
  height: 65%;
}
</style>