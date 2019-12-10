<template>
    <div class="modal-dialog" role="document">
        <div class="modal-content pb-5">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="search-block pb-3">
                        <p>Что Вы желаете найти?</p>
                        <input type="text" name="search-product" placeholder="Введите блюдо..."
                               v-model="filter">
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div v-for="(product, index) in searchByName" :key="product.id">
                            <div class="one-food">
                                <div id="recommend">рекомендуем</div>
                                <div class="c-product">
                                    <img :src="product.image"  class="img-fluid">
                                    <div class="search-heart">
                                        <button class="success right"><i class="fa fa-heart"></i></button>
                                    </div>
                                </div>
                                <div class="c-product-info">
                                    <a class="product_title">{{ product.name }}</a>
                                    <div class="c-markers">
                                  <span>
                                      <img data-toggle="tooltip" data-placement="top" title="Вегетарианская" src="images/demo1-1944807851-1.svg" alt="Vegetarian">
                                  </span>
                                        <span class="fa fa-info" data-toggle="popover" title="Пищевая ценность" data-content="Масса:340г<br>Калорийность: 1000<br>Белки:130<br>Углеводы:120"></span>
                                    </div>

                                    <h5><small>{{ product.structure }}</small></h5>
                                </div>

                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-secondary" v-for="(additive, additive_index) in product.additives"
                                           :class="{ 'active': additive.id === 0 }"
                                           :key="additive_index"
                                           @click="changeAdditive(additive.id, product.id)">
                                        <input type="radio" name="options"
                                               :id="'option-' + additive.id"
                                               autocomplete="off"> {{ additive.name }}
                                    </label>
                                </div>

                                <input type="hidden"
                                       :id="'additive-' + product.id"
                                       :class="'additive-' + product.id"
                                       :value="0">

                                <a class="product_title">{{ product.price }}</a>

                                <div :class="'add-product-id-' + product.id">
                                    <button class="btn btn-block btn-success btn-add_to-cart"
                                            @click="changeProduct(product.id)">
                                            <i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;&nbsp;Добавить в корзину</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--container-->
            </div><!--modal-body-->

        </div><!--modal-content-->
    </div><!--modal-dialog-->
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        data() {
            return {
                filter: '',
                checkedAdditive: []
            }
        },
        created() {
            this.CATALOG_PRODUCTS();
        },
        computed: {
            ...mapGetters(['CATALOG']),

            searchByName: function() {
                var filter = this.filter.trim().toLowerCase();
                if (filter === '') return this.CATALOG;

                return this.CATALOG.filter(function(s) {
                    return s.name.toLowerCase().indexOf(filter) > -1;
                });
            }
        },
        methods: {
            ...mapActions([
                'CATALOG_PRODUCTS',
                'ADD_TO_DATABASE_FROM_LOCAL_STORAGE'
            ]),

            changeProduct(id) {
                // перебираем v-model с добавками
                // если массив пустой, то тогда добавляем id со стандартным типом
                // если массив не пустой, то добавляем к нему id со стандартным типом
                // для того чтобы знать какое блюдо с какой добавкой нужно готовить
                let additiveFood = [];
                if (this.checkedAdditive.length == 0) {
                    additiveFood.push(1)
                }else {
                    additiveFood.push(1)
                    this.checkedAdditive.forEach((key, value) => {
                        if(key.product == id) {
                        additiveFood.push(parseInt(key.additive))
                    }
                });
                }

                // перебираем массив из localStorage
                // добавляем в массив additiveInCart все добавки, которые соответствуют блюду
                // по которому был совершен клик
                let additiveInCart = [];
                this.cart.forEach((key, value) => {
                    if(key.id == id) {
                    key.additive_id.additiveFood.forEach((k, v) => {
                        additiveInCart.push(k)
                })
                }
            });

                // выясняем какая есть разница между массивами
                var diff = _.difference(additiveFood, additiveInCart, _.isEqual);

                // создаем уникальный идентификатор для блюда с (или без) добавок
                // записываем в объект нужные для нас данные:
                // u_id - уникальный ключ
                // id - ключ блюда
                // additive_id - объект с ключами добавок
                // count- количество блюд с такими добавками
                var u_id = Math.floor(Math.random() * (10000 - 50));
                var changedProduct = {u_id: u_id, id: id, additive_id: { additiveFood }, count: 1};

                // сравниваем переменную сравнения массивов
                // если переменная оказалась пустой, то получается это блюдо с добавкой уже в корзине
                // и мы увеличиваем только количество этого блюда, найдя его по id
                // если же разница есть, то записывем в localStorage новое блюдо с добавкой (или без)
                if (_.isEmpty(diff) == true) {
                    _.map(this.cart, function (cart) {
                        if (cart.id == id) {
                            cart.count++
                        }
                    })
                } else {
                    this.cart.push(changedProduct);
                }

                // если localStorage пустой, то сразу записываем туда блюдо
                if (this.cart.length == 0) {
                    this.cart.push(changedProduct);
                }

                // если пользователь авторизовован
                // то кидаем весь localStorage в БД
                if (this.checkUser == 1) {
                    var food = {food: id, additive: additiveFood, u_id: u_id};
                    this.ADD_TO_DATABASE_FROM_LOCAL_STORAGE(food)
                }
            },

            // передаем из цикла добавок id
            // чтобы было что добавлять в корзину и заказы
            changeAdditive(id, product_id) {
                $('#additive-' + product_id).val(id);
            },
        }
    }
</script>