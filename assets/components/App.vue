<template>
    <div>
        <AppNavBar/>
        <AppDoc/>
    </div>
</template>

<script>
    import AppNavBar from './AppNavBar';
    import AppDoc from './AppDoc';

    export default {
        name: 'App',
        components: {
            AppNavBar,
            AppDoc
        }
    };
</script>
