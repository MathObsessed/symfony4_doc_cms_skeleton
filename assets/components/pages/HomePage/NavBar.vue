<template>
    <b-navbar type="dark" variant="dark">
        <b-navbar-brand :to="{ name: 'app_homepage' }">{{ title }}</b-navbar-brand>

        <b-navbar-nav>
            <b-nav-text>Login: {{ login }}</b-nav-text>
        </b-navbar-nav>

        <b-navbar-nav class="ml-3">
            <b-nav-text>Document: </b-nav-text>
            <b-nav-item-dropdown :text=selectedDocument right>
                <b-dropdown-item v-for="name in documentsList"
                                 :key="name"
                                 @click="selectDocument">{{ name }}</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>

        <b-navbar-nav class="ml-auto">
            <b-nav-item @click="logout">Logout</b-nav-item>
        </b-navbar-nav>
    </b-navbar>
</template>

<script>
    export default {
        name: 'NavBar',
        created () {
            this.$store.dispatch('documents')
                .then(() => this.documentsList = this.$store.getters.documentsList);
        },
        data() {
            return {
                title: this.$store.getters.title,
                login: this.$store.getters.login,
                documentsList: this.$store.getters.documentsList,
                selectedDocument: this.$store.getters.selectedDocument || 'selected'
            }
        },
        methods: {
            selectDocument (event) {
                this.$store.dispatch('selectDocument', event.target.text)
                    .then(() => {
                        this.documentsList = this.$store.getters.documentsList;
                        this.selectedDocument = this.$store.getters.selectedDocument;
                    });
            },
            logout () {
                this.$store.dispatch('logout')
                    .then(() => this.$router.push({ name: 'app_login' }));
            }
        }
    };
</script>
