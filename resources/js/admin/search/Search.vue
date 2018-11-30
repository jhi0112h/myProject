<template>
    <div class="component-wrap">
        <ais-index
                app-id="MLSD6D8PTP"
                api-key="8650199c9bcd974cc22fe0077fadcdd7"
                index-name="signs"
        >
            <vuetify-input @query="getQuery">
            </vuetify-input>

            <vuetify-results v-if="searchResultShow" :results-per-page="6"></vuetify-results>
        </ais-index>
    </div>
</template>

<script>
    import VuetifyInput from './components/VuetifyInput.vue';
    import VuetifyResults from './components/VuetifyResults.vue';

    export default {
        name: "Search",
        components: { VuetifyResults, VuetifyInput },
        data: () => ({
            searchText: '',
            searchResultShow: false,
        }),
        watch: {
            'searchText':_.debounce(function () {
                    if(this.searchText) {
                        this.searchResultShow = true
                    } else {
                        this.searchResultShow = false
                    }
                },100
            )
        },
        methods: {
            'getQuery': function (value) {
                this.searchText = value;
            }
        }
    }
</script>

<style scoped>
    .component-wrap {
        position: relative;
    }

</style>