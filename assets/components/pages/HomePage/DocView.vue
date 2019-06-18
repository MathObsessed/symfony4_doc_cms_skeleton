<template>
    <b-container fluid>{{ selectedDocument }}</b-container>
</template>

<script>
    export default {
        name: 'DocView',
        computed: {
            selectedDocument () {
                return this.$store.getters.selectedDocument || 'Select a document to show';
            }
        }
    };
</script>
