<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '업체관리시스템') }}</title>

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

    <!-- app js values -->
    <script type="application/javascript">
        var LSK_APP = {};
        LSK_APP.APP_URL = '{{env('APP_URL')}}';
    </script>
</head>
<body>
<div id="app-mount">

    <template>
        <v-app id="inspire">
            <v-navigation-drawer
                    mini-variant
                    fixed
                    dark
                    floating
                    v-model="drawer"
                    app>

                <v-list dense>
                    @foreach($nav as $n)
                        @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV)
                            <v-list-tile
                                    :to="{name:'{{$n->routeName}}'}"
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
                                        {{$n->icon}}
                                    </v-icon>
                                </v-list-tile-avatar>
                                    <span>{{$n->label}}</span>
                                </v-tooltip>

                            </v-list-tile>
                        @else
                            <v-divider></v-divider>
                        @endif
                    @endforeach
                </v-list>
            </v-navigation-drawer>

            <v-toolbar app fixed color="#fff">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <v-toolbar-title>
                    <div @click="$router.push({name:'signs.list'})" class="d-flex">
                        <img height="35" src="{{url('img/logo.png')}}">
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
                            <v-list-tile-title @click="clickLogout('{{ route("logout") }}', '{{ url('/') }}')">LOGOUT</v-list-tile-title>
                        </v-list-tile>
                    </v-list>
                </v-menu>
                </v-card-title>
            </v-toolbar>
            <v-content>
                <transition name="fade">
                    <router-view></router-view>
                </transition>
            </v-content>
        </v-app>

        <!-- loader -->
        <div v-if="showLoader" class="wask_loader bg_half_transparent">
            <dot-loader color="#faa61a" size="80px"></dot-loader>
        </div>

        <!-- snackbar -->
        <v-snackbar
                :timeout="snackbarDuration"
                :color="snackbarColor"
                top
                v-model="showSnackbar">
            @{{ snackbarMessage }}
        </v-snackbar>

        <!-- dialog confirm -->
        <v-dialog v-show="showDialog" v-model="showDialog" lazy absolute max-width="450px">
            <v-btn color="primary" slot="activator">Open Dialog</v-btn>
            <v-card>
                <v-card-title>
                    <div class="headline"><v-icon v-if="dialogIcon">@{{dialogIcon}}</v-icon> @{{ dialogTitle }}</div>
                </v-card-title>
                <v-card-text>@{{ dialogMessage }}</v-card-text>
                <v-card-actions v-if="dialogType=='confirm'">
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat="flat" @click.native="dialogCancel">Cancel</v-btn>
                    <v-btn color="green darken-1" flat="flat" @click.native="dialogOk">Ok</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </template>

</div>

<!-- Scripts -->
<script src="{{ asset('js/manifest.js') }}"></script>
<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>