<template>
    <b-navbar type="dark" variant="dark">
        <b-navbar-brand :to="{ name: 'app_homepage' }">{{ title }}</b-navbar-brand>

        <b-navbar-nav>
            <b-nav-text>Login: {{ login }}</b-nav-text>
        </b-navbar-nav>

        <b-navbar-nav class="ml-3">
            <b-nav-text>Document: </b-nav-text>
            <b-nav-item-dropdown text="select" right>
                <b-dropdown-item v-for="name in documents" :key="name">{{ name }}</b-dropdown-item>
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
                .then(() => this.documents = this.$store.getters.documents);
        },
        data() {
            return {
                title: this.$store.getters.title,
                login: this.$store.getters.login,
                documents: this.$store.getters.documents
            }
        },
        methods: {
            logout () {
                this.$store.dispatch('logout')
                    .then(() => this.$router.push({ name: 'app_login' }));
            }
        }
    };
</script>
