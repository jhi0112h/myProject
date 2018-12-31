<template>
    <div class="main-layout">
        <v-app id="inspire">
            <navbar/>

            <child/>
        </v-app>
    </div>
</template>

<script>
    import Navbar from '~/components/Navbar'

    export default {
        name: 'MainLayout',

        components: {
            Navbar
        }
    }
</script>
