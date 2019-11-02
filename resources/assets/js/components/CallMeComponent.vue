<template>
    <div>
        <div class="modal-dialog" role="document" v-show="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-body m-3 pl-4 pr-4">
                    <h3 style="color: rgb(58, 61, 73);" class="text-center text-uppercase">Перезвоните мне</h3>

                    <div class="errors-article" v-if="errors.length">
                        <b>Не выполнены некоторые условия:</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="form-group col-lg-8 col-md-8 offset-lg-2 offset-md-2">
                        <label for="name">Меня зовут</label>
                        <input type="text" class="form-control" name="name" id="name" v-model="user.name">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 offset-lg-2 offset-md-2">
                        <label for="phone">Мой номер телефона</label>
                        <input type="text" class="form-control" id="phone" name="phone" v-model="user.phone">
                    </div>

                    <div class="form-group col-lg-8 col-md-8 offset-lg-2 offset-md-2">
                        <button class="btn btn-default p-2 pl-3 pr-3 mt-3 btn-block" @click.prevent="sendRequest()">отправить</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal-dialog" role="document" v-show="success">
            <div class="modal-content">
                <div class="modal-body modal-body m-3 pl-4 pr-4">
                    <h3 style="color: rgb(58, 61, 73);" class="text-center text-uppercase">Номер телефона отправлен! В скором времени мы вам позвоним</h3>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                user: {
                    'name': '',
                    'phone': null,
                    'noted': false
                },

                errors: [],

                modal: true,
                success: false
            }
        },
        methods: {
            sendRequest() {
                this.errors = [];
                if (!this.user.name) this.errors.push("Имя не введено");
                if (!this.user.phone) this.errors.push("Телефон не введен");

                axios.post('/api/insert-call-me-number', this.user)
                    .then(res => {
                        console.log('Удача')
                        this.modal = !this.modal;
                        this.success = !this.success;
                        })
                    .catch (res => { console.log('Ошибка') })
            }
        }
    }
</script>