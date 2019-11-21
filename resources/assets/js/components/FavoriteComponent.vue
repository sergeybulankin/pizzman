<template>
    <div>
        <a href="/favorites">
            <span class="count">{{ counts }}</span><i class="fa fa-heart "></i>
        </a>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';

    export default {
        mounted() {
            this.COUNT_FAVORITE();
        },
        computed: {
            ...mapGetters(['COUNT']),

            counts() {
                return this.$store.getters.COUNT;
            }
        },
        methods: mapActions(['COUNT_FAVORITE'])
    }
</script>