<template>
    <div>
        <nav-bar/>
        <doc-view/>
    </div>
</template>

<script>
    import NavBar from './NavBar';
    import DocView from './DocView';

    export default {
        name: 'HomePage',
        components: { NavBar, DocView }
    };
</script>
