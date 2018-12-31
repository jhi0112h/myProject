<template>
    <div class="content">
        <canvas class="snow" id="snow"></canvas>

        <v-container fluid fill-height>
            <v-layout align-center justify-center :style="{ 'z-index' : 21 }">
                <v-flex xs12 sm8 md4 :style="{ 'position' : 'relative' }">

                    <!-- loader -->
                    <div v-if="formLoader" class="form-loader">
                        <dot-loader color="#faa61a" size="80px"></dot-loader>
                    </div>

                    <keep-alive>
                        <component :is="formState">
                            <!-- 비활성화 된 컴포넌트는 캐시 됩니다! -->
                        </component>
                    </keep-alive>
                    <v-form ref="form" v-model="valid" lazy-validation @keyup.native.enter="submit">
                        <v-card class="elevation-12">
                            <v-toolbar dark color="primary">
                                <v-toolbar-title>Login form</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-text-field
                                        v-model="form.email"
                                        :rules="form.emailRules"
                                        prepend-icon="person"
                                        name="email"
                                        label="Login"
                                        type="text"
                                        :error-messages="form.errorMessages.email"
                                ></v-text-field>
                                <v-text-field
                                        v-model="form.password"
                                        :rules="form.passwordRules"
                                        id="password"
                                        prepend-icon="lock"
                                        name="password"
                                        label="Password"
                                        type="password"
                                        :error-messages="form.errorMessages.password"
                                ></v-text-field>
                            </v-card-text>
                            <v-card-actions>
                                <v-checkbox
                                        v-model="remember"
                                        :label="$t('remember_me')"
                                        name="remember"
                                ></v-checkbox>
                                <router-link :to="{ name: 'password.request' }" class="small ml-auto my-auto">
                                    {{ $t('forgot_password') }}
                                </router-link>
                                <v-spacer></v-spacer>
                                <!-- Submit Button -->
                                <v-btn @click="$router.push({name:'register'})" flat color="primary">{{ $t('register') }}</v-btn>
                                <v-btn @click="submit" color="primary">{{ $t('login') }}</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </v-flex>
            </v-layout>
        </v-container>

        <div class="ground">
            <div :class="{ loading: showLoading }" class="mound">
                <div class="mound_text">KSP</div>
                <div class="mound_spade"></div>
            </div>
        </div>

    </div>
</template>

<script>
    import snow from '~/plugins/snow';
    import DotLoader from 'vue-spinner/src/DotLoader.vue';

    export default {
        middleware: 'guest',
        layout: 'basic',

        metaInfo() {
            return {title: this.$t('login')}
        },

        components: {
            DotLoader: DotLoader
        },

        data: () => ({
            valid: true,
            form: {
                email: '',
                emailRules: [
                    v => !!v || '이메일을 입력해주세요.',
                    v => /.+@.+/.test(v) || '이메일 형식과 맞지 않습니다.'
                ],
                password: '',
                passwordRules: [
                    v => !!v || '비밀번호를 입력해주세요.',
                ],
                errorMessages: []
            },
            remember: false,
            formState: '',
            formLoader: false,
            showLoading: false
        }),

        mounted() {
            snow(5)
        },
        methods: {
            submit() {
                if (this.$refs.form.validate()) {
                    this.errorMessages = '';
                    this.login()
                }
            },
            async login() {

                this.formLoader = true;

                try {
                    // Submit the form.
                    const {data} = await axios.post('/api/login', {
                        email: this.form.email,
                        password: this.form.password
                    });

                    if(data.token) {
                        // Save the token.
                        this.$store.dispatch('auth/saveToken', {
                            token: data.token,
                            remember: this.remember
                        });

                        // Fetch the user.
                        await this.$store.dispatch('auth/fetchUser');

                        await this.loginLoader();

                        // Redirect home.
                        await this.$router.push({name: 'signs.list'});

                    } else {
                        this.form.errorMessages = data
                    }
                } catch (err) {
                    console.log(err)
                }

                this.formLoader = false;
            },
            loginLoader() {
                return new Promise(resolve => {
                    resolve(this.showLoading = true);
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
    $col-sky-top: #bbcfe1;
    $col-sky-bottom: #e8f2f6;
    $col-fg: #5d7399;
    $col-blood: #dd4040;
    $col-ground: #f6f9fa;

    @mixin trees($direction, $size) {
        $shadow: ();

        @for $i from 1 through 16 {
            $space: $size * 1.2;
            $rand: (random(20)/10 - 1) * 50px;
            $shadow: append($shadow, ($direction * $i * $space + $rand) (($direction * -$i * $space) + $rand) 15px lighten($col-fg, random(20) + 10%), comma);
        }

        box-shadow: $shadow;
    }

    .content {
        height: 100%;
        position: relative;

        z-index: 1;
        background-color: mix($col-sky-top, $col-sky-bottom);
        background-image: linear-gradient(to bottom, $col-sky-top 0%, $col-sky-bottom 80%);
        overflow: hidden;
    }

    .snow {
        position: absolute;
        top: 0;
        left: 0;
        pointer-events: none;
        z-index: 20;
    }

    .main-text {
        padding: 20vh 20px 0 20px;

        text-align: center;
        line-height: 2em;
        font-size: 5vh;
    }

    .home-link {
        font-size: 0.6em;
        font-weight: 400;
        color: inherit;
        text-decoration: none;

        opacity: 0.6;
        border-bottom: 1px dashed transparentize($col-fg, 0.5);

        &:hover {
            opacity: 1;
        }
    }

    .ground {
        height: 160px;
        width: 100%;
        position: absolute;
        bottom: 0;
        left: 0;

        background: $col-ground;
        box-shadow: 0 0 10px 10px $col-ground;

        $treeSize: 250px;
        &:before,
        &:after {

            // Trees
            content: '';
            display: block;
            width: $treeSize;
            height: $treeSize;
            position: absolute;
            top: -$treeSize/4;

            z-index: -1;
            background: transparent;
            transform: scaleX(0.2) rotate(45deg);
        }

        &:after {
            left: 50%;
            margin-left: -$treeSize / 1.5;
            @include trees(-1, $treeSize);
        }

        &:before {
            right: 50%;
            margin-right: -$treeSize / 1.5;
            @include trees(1, $treeSize);
        }
    }

    .mound {
        margin-top: -115px;
        font-weight: 800;
        font-size: 180px;
        text-align: center;
        color: $col-blood;
        pointer-events: none;

        $from-top: 50px;

        &.loading {
            &:before {
                -webkit-transition: all 0.3s;
                -moz-transition: all 0.3s;
                -ms-transition: all 0.3s;
                -o-transition: all 0.3s;
                transition: all 0.3s;
                -webkit-transform: scale(10);
                -moz-transform: scale(10);
                -ms-transform: scale(10);
                -o-transform: scale(10);
                transform: scale(10);
            }
        }

        &:before {
            $w: 600px;
            $h: 200px;

            content: '';
            display: block;
            width: $w;
            height: $h;
            position: absolute;
            left: 50%;
            margin-left: -$w/2;
            top: $from-top;
            z-index: 1;

            border-radius: 100%;
            background-color: $col-sky-bottom;
            background-image: linear-gradient(to bottom, lighten($col-sky-top, 10%), $col-ground 60px);
        }

        &:after {
            // Blood
            $w: 28px;
            $h: 6px;
            content: '';
            display: block;
            width: $w;
            height: $h;
            position: absolute;
            left: 50%;
            margin-left: - 150px;
            top: $from-top + 18px;

            z-index: 2;
            background: $col-blood;
            border-radius: 100%;
            transform: rotate(-15deg);
            box-shadow: -($w * 2) ($h * 2) 0 1px $col-blood, -($w * 4.5) ($h) 0 2px $col-blood, -($w * 7) ($h * 4) 0 3px $col-blood,
        }
    }

    .mound_text {
        transform: rotate(6deg);
    }

    .mound_spade {
        $handle-height: 30px;

        display: block;
        width: 35px;
        height: 30px;
        position: absolute;
        right: 50%;
        top: 42%;
        margin-right: -250px;

        z-index: 0;
        transform: rotate(35deg);
        background: $col-blood;

        &:before,
        &:after {
            content: '';
            display: block;
            position: absolute;
        }

        &:before {
            width: 40%;
            height: $handle-height;
            bottom: 98%;
            left: 50%;
            margin-left: -20%;

            background: $col-blood;
        }

        &:after {
            width: 100%;
            height: 30px;
            top: -$handle-height - 25px;
            left: 0%;
            box-sizing: border-box;

            border: 10px solid $col-blood;
            border-radius: 4px 4px 20px 20px;
        }
    }
    .form-loader {
        position: absolute;
        z-index: 501;
        left: 0;
        right: 0;
        top: 0 ;
        bottom: 0;
        background:#fff;
        display:flex;
        flex:1 1 auto;
        align-items: center;
        justify-content: center;
    }
</style>