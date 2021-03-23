<template>
	<div class="w-50 lg:flex display-none mt-2">
  		<div class="h-64 lg:w-48 flex-none bg-cover rounded-t lg:rounded-t-none lg:rounded-l text-center overflow-hidden bg-white">
        <div id="dropzone" class="flex w-100 h-100 inline-block border border-blue-400 border-r-0 cursor-pointer hover:bg-blue-400 hover:text-white">
          <label class="w-64 flex flex-col items-center px-4 py-6 text-blue rounded-lg tracking-wide uppercase    mb-auto mt-auto">
              <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
              </svg>
              <span class="mt-2 text-base leading-normal">Select a file</span>
              <input type='file' class="hidden" />
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
    props: ['board_id'],
    components: { quillEditor },
    data: function() {
      return {
        content: '',
        editorOptions: {
          placeholder: 'Enter your comment here',
          formats: ['italic', 'bold']
        }
      }
    },
    methods: {
      sendReply () {
        let data = {
          'body': this.content,
          'entry_id': this.entry_id
        }

        this.axios.post('/api/comment', data=data).then((response) => {
          console.log(response);
        });
      }
    },
    mounted() {
      Dropzone.autoDiscover = false;

      let uploadDropzone = new Dropzone("#dropzone", {
        url: '/action',
        previewTemplate: `
        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
        </svg>`
      });
    }
  }
</script>

<style>
.quill-editor {
  height: 65%;
}
</style>