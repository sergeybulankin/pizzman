<template>
    <div>
        <a href="/favorites">
            <span class="count">{{ totalFavorite }}</span><i class="fa fa-heart "></i>
        </a>
    </div>
</template>

<script>
    export default {
        computed: {
            totalFavorite() {
                return this.favorite.length;
            },
        }
    }
</script>