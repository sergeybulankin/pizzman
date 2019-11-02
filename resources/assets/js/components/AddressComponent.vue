<template>
    <div>
        <VueSuggestions
                :model.sync="city"
                :coordinates.sync="coordinates"
                :placeholder="'Введите адрес'"
                :options="suggestionOptions"
                class="form-group col-lg-12"
                id="address">
        </VueSuggestions>
    </div>
</template>

<script>
    import VueSuggestions from 'vue-suggestions';

    export default {
        data() {
            return {
                city: '',
                coordinates: {
                    latitude: '',
                    longitude: ''
                },
                suggestionOptions: {
                    token: '7e48cb87bd4db22f24dbee66e2b5add3cb8ab89a',
                    type: "ADDRESS",
                    //scrollOnFocus: false,
                    //triggerSelectOnBlur: false,
                    //triggerSelectOnEnter: false,
                    //addon: 'none',
                    constraints: {
                        label: "",
                        locations: {
                            kladr_id: "0200001400000"
                        }
                    },
                    // в списке подсказок не показываем область и город
                    restrict_value: true,
                    onSelect (suggestion) {

                    }
                },
            }
        },
        mounted() {
            var $address = $('#address'),
                $hidden_address = $('#suggest');

            $address.on('input', function () {
                $hidden_address.val($address.val());
            });
        },
        components: { VueSuggestions }
    }
</script>


<style>
    input {
        background: rgb(241,241,242)!important;
        font-size: 16px;
        line-height: normal;
        padding: 14px 15px 15px 15px !important;
        border-radius: 4px;
        height: auto;
        border: 1px solid rgb(225,226,228);
    }
</style>