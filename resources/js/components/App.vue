<template>
    <div class="mb-10">
        <Navbar/>
        <main class="container mx-auto">
            <router-view :key="$route.path"></router-view>
        </main>
    </div>
</template>
    
<script>
    import Navbar from './elements/Navbar.vue'

    export default {
        components: {
            Navbar
        }
    }
</script>