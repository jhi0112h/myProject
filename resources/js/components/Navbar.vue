<template>
    <div>

        <v-navigation-drawer
                mini-variant
                fixed
                dark
                floating
                v-model="drawer"
                app>

            <v-list dense>
                <v-list-tile
                        v-for="menu in menus"
                        v-if="menus.length"
                        :to="{name: menu.routeName}"
                        :exact="false"
                        avatar>
                    <v-tooltip right>
                        <v-list-tile-avatar
                                @mouseover.stop="ListItemMouseOver"
                                @mouseout.stop="ListItemMouseOut"
                                size="50"
                                color="#2f3136"
                                slot="activator">
                            <v-icon
                                    size="30">
                                menu.icon
                            </v-icon>
                        </v-list-tile-avatar>
                        <span>menu.label</span>
                    </v-tooltip>

                </v-list-tile>

                <v-divider v-else></v-divider>
            </v-list>
        </v-navigation-drawer>

        <v-toolbar app fixed color="#fff">
            <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
            <v-toolbar-title>
                <div @click="$router.push({name:'signs.list'})" class="d-flex">
                    <img height="35" src="/img/logo.png">
                </div>
            </v-toolbar-title>
            <v-flex xs12 sm4>
                <search></search>
            </v-flex>

            <v-spacer></v-spacer>

            <v-menu bottom left offset-y>
                <v-btn
                        slot="activator"
                        icon
                >
                    <v-badge left overlap>
                        <span slot="badge">6</span>
                        <v-icon>notification_important</v-icon>
                    </v-badge>
                </v-btn>

                <v-list>
                    <v-list-tile
                            @click=""
                    >
                        <v-list-tile-title>테스트</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>

            <v-menu bottom left offset-y>
                <v-btn
                        slot="activator"
                        icon
                >
                    <v-icon>more_vert</v-icon>
                </v-btn>

                <v-list>
                    <v-list-tile
                            @click=""
                    >
                        <v-list-tile-title @click="$router.push({name:'settings.profile'})">
                            <fa icon="sign-out-alt" fixed-width/>
                            {{ $t('settings') }}
                        </v-list-tile-title>
                    </v-list-tile>

                    <v-list-tile
                            @click=""
                    >
                        <v-list-tile-title @click.prevent="logout">
                            <fa icon="sign-out-alt" fixed-width/>
                            {{ $t('logout') }}
                        </v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>

        </v-toolbar>


        <!--nav class="navbar navbar-expand-lg navbar-light bg-white">
          <div class="container">
            <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
              {{ appName }}
            </router-link>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
              <span class="navbar-toggler-icon"/>
            </button>

            <div id="navbarToggler" class="collapse navbar-collapse">
              <ul class="navbar-nav">
                <locale-dropdown/>
              </ul>

            </div>
          </div>
        </nav-->
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import LocaleDropdown from './LocaleDropdown'
    import Search from './search/Search'

    export default {
        components: {
            LocaleDropdown, Search
        },

        data: () => ({
            appName: window.config.appName,
            drawer: true,
            navigatorAnimation: {},
            menus: '',
        }),

        mounted() {

        },

        computed: {
            ...mapGetters({
                user: 'auth/user',
            }),
        },

        methods: {
            async logout() {
                // Log out the user.
                await this.$store.dispatch('auth/logout')

                // Redirect to login.
                this.$router.push({name: 'login'})
            },
        }
    }

</script>

<style scoped>
    .profile-photo {
        width: 2rem;
        height: 2rem;
        margin: -.375rem 0;
    }
</style>
