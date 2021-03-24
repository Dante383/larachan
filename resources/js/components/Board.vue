<template>
    <div>
        <div class="text-center">
            <div class="text-6xl m-3">
                /{{ board.href }}/ - {{ board.name }}
            </div>
            <div class="text-3xl m-3">
                <a href="#" @click="entryBoxVisible = !entryBoxVisible">Click here to post an entry</a>
            </div>
            <div class="flex justify-center m-6">
                <transition name="slide">
                    <EntryBox v-if="entryBoxVisible" :board_id="this.board.id" v-on:entry-posted="entryPosted"/>
                </transition>
            </div>
        </div>
        <div class="container mx-auto">
            <Entry v-for="entry in entries" v-bind:key="entry.id" :entry_id="entry.id"/>
        </div>
    </div>
</template>

<script>
    import Entry from './elements/Entry.vue'
    import EntryBox from './elements/EntryBox.vue'

    export default {
        props: ['board_href'],
        components: {Entry, EntryBox},
        data: function() {
            return {
                'board': {"id": "", "href": ""},
                'entries': [],
                'entryBoxVisible': false
            }
        },
        methods: {
          entryPosted (entry) {
            this.entries.unshift(entry);
            this.entryBoxVisible = false; 
          }
        },
        mounted() {
            var that = this; 

            this.axios.get('/api/board/' + this.board_href).then((response) => {
                that.board = response.data
            });

            this.axios.get('/api/board/' + this.board_href + '/entries').then((response) => {
                that.entries = response.data
            });
        }
    }
</script>

<style>
.slide-enter-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: ease-in;
   -webkit-transition-timing-function: ease-in;
   -o-transition-timing-function: ease-in;
   transition-timing-function: ease-in;
}

.slide-leave-active {
   -moz-transition-duration: 0.3s;
   -webkit-transition-duration: 0.3s;
   -o-transition-duration: 0.3s;
   transition-duration: 0.3s;
   -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
   transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to, .slide-leave {
   max-height: 100px;
   overflow: hidden;
}

.slide-enter, .slide-leave-to {
   overflow: hidden;
   max-height: 0;
}
</style>