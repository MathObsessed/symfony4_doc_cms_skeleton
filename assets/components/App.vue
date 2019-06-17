<template>
    <div>
        <router-view></router-view>
        <Loader/>
    </div>
</template>

<script>
    import Loader from './Loader';

    export default {
        name: 'App',
        components: { Loader },
        created () {
            let attributes = this.$parent.$el.attributes;

            this.$store.dispatch('init', {
                title: attributes['data-title'].value,
                login: ((typeof attributes['data-login'] !== 'undefined') ? attributes['data-login'].value : null)
            });
        }
    };
</script>
