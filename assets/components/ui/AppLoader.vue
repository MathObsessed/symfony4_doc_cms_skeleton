<template>
    <div v-if="isLoading" class="modal-mask">
        <div class="modal-wrapper">
            <b-spinner variant="dark" type="grow"></b-spinner>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AppLoader',
        computed: {
            isLoading () {
                return this.$store.getters.isLoading;
            }
        },
    };
</script>

<style>
    .modal-mask {
        background-color: rgba(0, 0, 0, .5);
        display: table;
        height: 100%;
        left: 0;
        position: fixed;
        top: 0;
        transition: opacity .3s ease;
        width: 100%;
        z-index: 9998;
    }

    .modal-wrapper {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }
</style>
