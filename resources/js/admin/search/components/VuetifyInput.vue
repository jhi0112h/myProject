<template>
    <v-text-field
            v-model="query"
            solo
            label="Search"
            clearable
    ></v-text-field>
</template>

<script>
    import { Input } from 'vue-instantsearch';
    export default {
        extends: Input,
        name: "VuetifyInput"
    }
</script>

<style scoped>

</style>