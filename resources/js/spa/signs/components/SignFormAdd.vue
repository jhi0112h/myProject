<template>
    <div class="component-wrap">
        <v-card>
            <v-card-title>
                <v-icon>person</v-icon> 계약등록
            </v-card-title>
            <v-divider></v-divider>
            <v-form v-model="valid" ref="signFormAdd" lazy-validation>
                <v-container grid-list-md>
                    <v-layout row wrap>
                    <v-flex xs12 sm6>
                        <v-text-field box label="업체명" v-model="company" :rules="companyRules"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="계약금" v-model="pay"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="계약일" v-model="day"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="계약기간" v-model="period"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="키워드" v-model="keyword"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="서비스내역" v-model="service"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="대표 연락처" v-model="phone"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6>
                        <v-text-field box label="대표 이메일" v-model="email" :rules="emailRules"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field box label="기타 전달사항" v-model="comment"></v-text-field>
                    </v-flex>

                    <v-flex xs12>
                        <v-btn @click="save()" :disabled="!valid" color="primary" dark>Save</v-btn>
                    </v-flex>
                </v-layout>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
    export default {
        data() {

            const self = this;

            return {
                valid: false,
                company: '',
                companyRules: [
                    (v) => !!v || 'Name is required',
                ],
                pay: '',
                day: '',
                period: '',
                keyword: '',
                service: '',
                phone: '',
                email: '',
                emailRules: [
                    (v) => !!v || 'E-mail is required',
                    (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid'
                ],
                comment: '',
            }
        },
        mounted() {
            const self = this;
        },
        methods: {
            save() {

                const self = this;

                let payload = {
                    company: self.company,
                    pay: self.pay,
                    day: self.day,
                    period: self.period,
                    keyword: self.keyword,
                    service: self.service,
                    phone: self.phone,
                    email: self.email,
                    comment: self.comment,
                };

                self.$store.commit('showLoader');

                axios.post('/sign/signs',payload).then(function(response) {

                    self.$store.commit('showSnackbar',{
                       message: response.data.message,
                       color: 'success',
                       duration: 3000
                    });

                    self.$eventBus.$emit('SIGN_ADDED');
                    self.$store.commit('hideLoader');

                    // reset
                    self.$refs.signFormAdd.reset();

                    $router.push({name:'signs.create'})

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
        }
    }
</script>