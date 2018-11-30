<template>
    <v-list
            two-line
            subheader
            class="algolia-autocomplete-listbox"
    >
        <v-list-tile
                v-for="result in results"
                :key="result.objectID"
                avatar
                @click=""
        >
            <v-list-tile-content>
                <v-list-tile-title>
                    <ais-highlight :result="result" attribute-name="company"></ais-highlight>
                </v-list-tile-title>
                <v-list-tile-sub-title>
                    <ais-highlight :result="result" attribute-name="mb_name"></ais-highlight>
                </v-list-tile-sub-title>
            </v-list-tile-content>

            <v-list-tile-action>
                <v-btn icon ripple>
                    <v-icon color="grey lighten-1">info</v-icon>
                </v-btn>
            </v-list-tile-action>
        </v-list-tile>

        <v-list-tile v-if="results.length === 0">
                <span class="grey--text text-xs-center">
                    <v-icon left size="18">error</v-icon> 검색어에 맞는 최근기록이 없습니다.
                </span>
        </v-list-tile>
    </v-list>
</template>

<script>
    import { Results } from 'vue-instantsearch';

    export default {
        extends: Results,
        name: "VuetifyResults",
    }
</script>

<style>
    .ais-highlight em {
        font-style: normal;
        font-weight: bold;
    }
    .algolia-autocomplete-listbox {
        position: absolute;
        left: 0;
        right: 0;
        box-shadow: 0px 3px 5px -1px rgba(0,0,0,0.2), 0px 6px 10px 0px rgba(0,0,0,0.14), 0px 1px 18px 0px rgba(0,0,0,0.12);
    }
</style>