<template>
    <div>
        <a class="/favorite">
            <span class="count">{{ counts }}</span><i class="fa fa-heart "></i>
        </a>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            this.COUNT_PRODUCTS_IN_FAVORITE()
        },
        computed: {
            ...mapGetters(['COUNT', 'ALL_FAVORITE']),

            counts() {
                this.COUNT_PRODUCTS_IN_FAVORITE(this.ALL_FAVORITE);
                return this.COUNT;
            }
        },
        methods: mapActions(['COUNT_PRODUCTS_IN_FAVORITE'])
    }
</script>