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
        computed: {
            ...mapGetters(['COUNT']),

            counts() {
                this.COUNT_FAVORITE();
                return this.COUNT
            }
        },
        methods: mapActions(['COUNT_FAVORITE'])
    }
</script>