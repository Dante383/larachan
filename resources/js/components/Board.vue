<template>
    <div>
        <div class="flex justify-center">
            <div class="text-6xl m-3">
                /{{ board.href }}/ - {{ board.name }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['board_href'],
        data: function() {
            return {
                'board': {}
            }
        },
        mounted() {
            var that = this; 

            this.axios.get('/api/board/' + this.board_href).then((response) => {
                that.board = response.data
            });
        }
    }
</script>
