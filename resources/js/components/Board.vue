<template>
    <div>
        <div class="flex justify-center">
            <div class="text-6xl m-3">
                /{{ board.href }}/ - {{ board.name }}
            </div>
        </div>
        <div class="container mx-auto">
            <Entry v-for="entry in entries" v-bind:key="entry.id" :entry_id="entry.id"/>
        </div>
    </div>
</template>

<script>
    import Entry from './elements/Entry.vue'

    export default {
        props: ['board_href'],
        components: {Entry},
        data: function() {
            return {
                'board': {},
                'entries': []
            }
        },
        mounted() {
            var that = this; 

            this.axios.get('/api/board/' + this.board_href).then((response) => {
                that.board = response.data
            });

            this.axios.get('/api/entries/' + this.board_href).then((response) => {
                that.entries = response.data
            });
        }
    }
</script>
