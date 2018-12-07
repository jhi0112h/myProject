<template>
    <v-navigation-drawer :width="270" clipped permanent>
        <div class="pt-3">
            <v-btn @click="$router.push({name:'signs.create'})" class="blue lighten-1" dark>
                새 계약등록
                <v-icon right dark>add</v-icon>
            </v-btn>
        </div>
        <v-list subheader>
            <v-list-tile
                    v-for="item in routes"
                    :key="item.title"
                    :to="{name:item.name}"
                    avatar
                    ripple
                    @click=""
            >
                <v-list-tile-avatar :size="20">
                    <v-icon :size="20">{{ item.icon }}</v-icon>
                </v-list-tile-avatar>

                <v-list-tile-content>
                    <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile-content>

                <v-list-tile-action>
                    <v-btn icon ripple>
                        <v-icon color="grey lighten-1">info</v-icon>
                    </v-btn>
                </v-list-tile-action>

            </v-list-tile>

        </v-list>
    </v-navigation-drawer>
</template>
<script>
    export default {
        name: 'SignsNavigationDrawer',
        props: {
            routes: {},
        }
    }
</script>

<style scoped>

</style>