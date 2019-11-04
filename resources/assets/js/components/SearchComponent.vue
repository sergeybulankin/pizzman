<template>
    <div>
        <h1>search</h1>
        <div>
            {{ ALL_PRODUCTS }}
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        created() {
            this.SELECTED_ALL_PRODUCTS();
        },
        computed: mapGetters(['ALL_PRODUCTS']),
        methods: mapActions(['SELECTED_ALL_PRODUCTS'])

    }
</script>