<template>
    <div>
        <div class="col-lg-12">
            <label>Номер телефона*</label>
            <the-mask :mask="['+7 (###)-##-##-###']" v-model="phone" style="width: 330px" />

            <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" @click="register(phone)">зарегистрироваться</button>
        </div>

        <div id="password_form" v-show="checkSmsCode">
            <h5><small>На указанный номер телефона был отправлен пароль, введите его в поле ниже.</small></h5>
            <div class="form-group">
                <label>Пароль (код из смс)</label>
                <input type="text" name="code" class="form-control" v-model="code">
            </div>

            <button class="btn btn-default pull-right p-2 pl-3 pr-3 mt-3" type="button" @click="checkCode(phone, code)">подтвердить</button>
        </div>

        <div v-show="errorNumberPhone" class="col-lg-12" style="margin: 65px 0 0 0;">
            <div class="alert alert-primary" role="alert">
                Номер телефона некоректен. Введите нормально номер телефона и повторите попытку
            </div>
        </div>

        <div style="margin: 80px 0 0 0">
            <div id="registered" class="alert alert-success" role="alert" v-if="ANSWER == 200">
                Поздравляем! Регистрация прошла успешно! Вы авторизованы
            </div>
            <div id="repeatSms" class="repeat-code" v-else-if="ANSWER == 500">
                <div class="alert alert-primary" role="alert">
                    Ошибка смс-кода. неправильно введен
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    import { mask } from 'vue-the-mask';

    export default {
        data() {
            return {
                phone: '',
                code: '',
                errorNumberPhone: false,
                checkSmsCode: false
            }
        },
        computed: mapGetters([
            'SMS',
            'ANSWER'
        ]),
        methods: {
            ...mapActions([
                'SEND_SMS',
                'CHECK_CODE_SMS'
            ]),

            register(phone) {
                if (phone.length < 9) {
                    this.errorNumberPhone = true
                }else {
                    this.errorNumberPhone = false;
                    this.SEND_SMS();
                    this.checkSmsCode = true;
                }
            },

            checkCode(phone, code) {
                var data = {phone, code};

                this.CHECK_CODE_SMS(data);

                this.redirectAccount();
            },

            redirectAccount() {
                window.location.href = "/account";
            }
        },
        directives: { mask }
    }
</script>