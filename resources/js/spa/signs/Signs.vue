<template>
        <v-layout align-space-between row fill-height>
            <SignsNavigationDrawer :routes="routes"></SignsNavigationDrawer>
            <v-flex>
                <!-- search -->
                <v-card ref="listController" class="py-3">
                    <v-layout row wrap>
                        <v-flex xs12 sm4 class="px-2">
                            <v-icon @>
                                refresh
                            </v-icon>
                        </v-flex>
                        <v-flex xs12 sm4 offset-sm4 class="px-2 text-xs-right">
                            <v-pagination
                                    v-model="getPagination.page"
                                    :length="paginationLength"
                                    :total-visible="5"
                            ></v-pagination>
                        </v-flex>
                    </v-layout>
                </v-card>
                <!-- /search -->
                <transition name="fade">
                    <keep-alive>
                        <router-view v-scrollWrap="listMinusHeight"></router-view>
                    </keep-alive>
                </transition>
            </v-flex>

        </v-layout>
</template>

<script>
    import scrollWrap from '../../common/directives/scrollWrap.js'
    import SignsNavigationDrawer from "./SignsNavigationDrawer";

    export default {
        directives: { scrollWrap },
        components: {SignsNavigationDrawer},
        data () {
            return {
                active: '',
                routes: [
                    {
                        'icon': 'markunread_mailbox',
                        'name': 'signs.list',
                        'title': '전체계약건'
                    },
                    {
                        'icon': 'markunread_mailbox',
                        'name': 'signs.list2',
                        'title': '자료 미도착 계약건'
                    },
                ],
                listMinusHeight: []
            }
        },
        mounted() {
            // 리스트컨트롤과 뷰앱탑바의 높이를 listMinusHeight 변수에 추가
            this.listMinusHeight.push( this.getListControlle().clientHeight, this.$vuetify.application.top );

        },
        methods: {
            getListControlle() {
                return this.$refs.listController.$el;
            }
        },
        computed: {
            // pagination
            getPagination: {
                get: function () {
                    return this.$store.getters.getPagination
                },
                set: function (newValue) {
                    this.$store.commit('setPagination', newValue)
                }
            },
            paginationLength() {
                return Math.ceil(this.$store.getters.getPagination.totalItems/this.$store.getters.getPagination.rowsPerPage)
            },
        }
    }
</script>