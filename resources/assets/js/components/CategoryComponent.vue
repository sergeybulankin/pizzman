<template>
    <div class="navbar-nav ">
        <ul class="navbar-nav md-auto" v-for="(category, index) in ALL_CATEGORIES" :key="index">
            <li class="nav-item">
                <a class="nav-link" href="#menu_link"
                   @click="selectProducts(category.id)">
                    <img :src="'/images/' + category.icon">
                    <span>{{ category.name }}</span>
                </a>
            </li>
        </ul>

    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            this.SELECTED_ALL_CATEGORIES()
        },
        computed: mapGetters(['ALL_CATEGORIES']),
        methods: {
            ...mapActions([
                'SELECTED_ALL_CATEGORIES',
                'SELECTION_BY_CATEGORY'
            ]),

            selectProducts(id) {
                this.SELECTION_BY_CATEGORY(id);
            }
        }
    }
</script>