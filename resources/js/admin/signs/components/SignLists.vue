<template>
    <div class="component-wrap">

        <!-- search -->
        <v-card class="py-3">
            <v-layout row wrap>
                <v-flex xs12 sm4 class="px-2">
                    <v-btn @click="$router.push({name:'signs.create'})" class="blue lighten-1" dark>
                        새 계약등록
                        <v-icon right dark>add</v-icon>
                    </v-btn>
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

        <!-- data table -->
        <v-data-table
                v-bind:headers="headers"
                v-bind:pagination.sync="getPagination"
                :items="items"
                :total-items="totalItems"
                class="elevation-1">
            <template slot="headerCell" slot-scope="props">
                <span v-if="props.header.value=='company'">
                    <v-icon>store</v-icon> {{ props.header.text }}
                </span>
                <span v-else-if="props.header.value=='mb_name'">
                    <v-icon>person</v-icon> {{ props.header.text }}
                </span>
                <span v-else-if="props.header.value=='day'">
                    <v-icon>av_timer</v-icon> {{ props.header.text }}
                </span>
                <span v-else-if="props.header.value=='created_at'">
                    <v-icon>av_timer</v-icon> {{ props.header.text }}
                </span>
                <span v-else-if="props.header.value=='last_login'">
                    <v-icon>av_timer</v-icon> {{ props.header.text }}
                </span>
                <span v-else-if="props.header.value=='progress'">
                    <v-icon>timeline</v-icon> {{ props.header.text }}
                </span>
                <span v-else>{{ props.header.text }}</span>
            </template>
            <template slot="items" slot-scope="props">
                <td>
                    <v-menu>
                        <v-btn icon slot="activator">
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                        <v-list>
                            <v-list-tile @click="$router.push({name:'signs.edit',params:{id: props.item.id}})">
                                <v-list-tile-title>Edit</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="trash(props.item)">
                                <v-list-tile-title>Delete</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                </td>
                <td>{{ props.item.company }}</td>
                <td>{{ props.item.user ? props.item.user.name : ''}}</td>
                <td>{{ props.item.day }}</td>
                <td>{{ props.item.created_at.substr(0,10) }}</td>
                <td class="text-xs-center">
                    <v-btn small @click="showDialog('sign_progress',props.item.progress)" outline round color="grey" dark>Show</v-btn>
                </td>
            </template>
        </v-data-table>

        <!-- dialog for show permissions -->
        <v-dialog v-model="dialogs.showProgress.show" lazy absolute max-width="300px">
            <v-card>
                <v-card-title>
                    <div class="headline"><v-icon>vpn_key</v-icon> 제작 진행상황</div>
                </v-card-title>
                <v-card-text>
                    <v-chip v-for="(permission,key) in dialogs.showProgress.items" :key="key" class="white--text" :class="{'green':(permission.value==1),'red':(permission.value==-1),'blue':(permission.value==0)}">
                        <v-avatar v-if="permission.value==-1" class="red darken-4" title="Deny">
                            <v-icon>block</v-icon>
                        </v-avatar>
                        <v-avatar v-if="permission.value==1" class="green darken-4" title="Allow">
                            <v-icon>check_circle</v-icon>
                        </v-avatar>
                        <v-avatar v-if="permission.value==0" class="blue darken-4" title="Inherit">
                            <v-icon>swap_horiz</v-icon>
                        </v-avatar>
                        {{permission.title}}
                    </v-chip>
                    <p v-if="dialogs.showProgress.items.length==0">No permissions</p>
                </v-card-text>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        data () {
            return {
                headers: [
                    { text: 'Action', value: false, align: 'left', sortable: false },
                    { text: '업체명', value: 'company', align: 'left', sortable: false },
                    { text: '계약자', value: 'mb_name', align: 'left', sortable: false },
                    { text: '계약일', value: 'day', align: 'left', sortable: false },
                    { text: '등록일', value: 'created_at', align: 'left', sortable: false },
                    { text: '진행상태', value: 'progress', align: 'center', sortable: false },
                ],
                items: [],
                totalItems: 0,
                filters: {
                    titleSearch: '',
                    company: '',
                    mb_name: '',
                    email: '',
                    groupId: [],
                    serviceOptions: ['홈페이지','블로그']
                },
                dialogs: {
                    showProgress: {
                        items: [],
                        show: false
                    }
                }
            }
        },
        mounted() {
            const self = this;

            self.loadSigns(()=>{});

            self.$eventBus.$on(['USER_ADDED','USER_UPDATED','USER_DELETED','GROUP_ADDED'],()=>{
                self.loadSigns(()=>{});
            });
        },
        watch: {
            'getPagination.page':function(){
                this.loadSigns(()=>{});
                this.$store.commit('setPagination', this.getPagination)
            },
            'getPagination.rowsPerPage':function(){
                this.loadSigns(()=>{});
                this.$store.commit('setPagination', this.getPagination)
            },
            'filters.titleSearch':_.debounce(function(){
                const self = this;
                self.loadSigns(()=>{});
            },700),

            'filters.company':_.debounce(function(){
                const self = this;
                self.loadSigns(()=>{});
            },700),
            'filters.mb_name':_.debounce(function(){
                const self = this;
                self.loadSigns(()=>{});
            },700),
            'filters.email':_.debounce(function(){
                const self = this;
                self.loadSigns(()=>{});
            },700),
            'filters.groupId':_.debounce(function(){
                const self = this;
                self.loadSigns(()=>{});
            },700)
        },
        methods: {
            trash(sign) {
                const self = this;

                self.$store.commit('showDialog',{
                    type: "confirm",
                    icon: 'warning',
                    title: "Confirm Deletion",
                    message: "정말로 계약업체를 삭제하시겠습니까?",
                    okCb: ()=>{

                        axios.delete('/sign/signs/' + sign.id).then(function(response) {

                            self.$store.commit('showSnackbar',{
                                message: response.data.message,
                                color: 'success',
                                duration: 3000
                            });

                            self.$eventBus.$emit('USER_DELETED');

                        }).catch(function (error) {

                            self.$store.commit('hideLoader');

                            if (error.response) {
                                self.$store.commit('showSnackbar',{
                                    message: error.response.data.message,
                                    color: 'error',
                                    duration: 3000
                                });
                            } else if (error.request) {
                                console.log(error.request);
                            } else {
                                console.log('Error', error.message);
                            }
                        });
                    },
                    cancelCb: ()=>{
                        console.log("CANCEL");
                    }
                });
            },
            showDialog(dialog, data) {

                const self = this;

                switch (dialog){
                    case 'sign_progress':
                        self.dialogs.showProgress.items = data;
                        self.dialogs.showProgress.show = true;
                    break;
                }
            },
            loadSigns(cb) {

                const self = this;

                let params = {
                    titlesearch: self.filters.titleSearch,
                    company: self.filters.company,
                    mb_name: self.filters.mb_name,
                    email: self.filters.email,
                    page: self.getPagination.page,
                    per_page: self.getPagination.rowsPerPage
                };

                axios.get('/sign/signs',{params: params}).then(function(response) {
                    self.items = response.data.data.data;
                    self.totalItems = response.data.data.total;
                    self.getPagination.totalItems = response.data.data.total;

                    (cb || Function)();
                });
            },
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
            }
        }
    }
</script>