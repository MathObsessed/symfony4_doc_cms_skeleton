<template>
    <div>
        <router-view></router-view>
        <app-loader/>
    </div>
</template>

<script>
    import AppLoader from './ui/AppLoader';

    export default {
        name: 'App',
        components: { AppLoader },
        created () {
            let attributes = this.$parent.$el.attributes;

            this.$store.dispatch('init', {
                title: attributes['data-title'].value,
                login: ((typeof attributes['data-login'] !== 'undefined') ? attributes['data-login'].value : null)
            });
        }
    };
</script>
