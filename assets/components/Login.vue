<template>
    <b-container>
        <b-row>
            <b-col></b-col>
            <b-col cols="5">
                <b-card class="mt-5" :header=title header-bg-variant="dark" header-text-variant="white" title="Please login">
                    <div v-if="hasError" class="alert alert-danger" role="alert">
                        {{ error }}
                    </div>

                    <b-form @submit="login">
                        <b-form-group label="Email:" label-for="email">
                            <b-form-input v-model="email" type="email" required></b-form-input>
                        </b-form-group>

                        <b-form-group label="Password:" label-for="password">
                            <b-form-input v-model="password" type="password" required></b-form-input>
                        </b-form-group>

                        <div class="text-center">
                            <b-button type="submit" variant="dark">Login</b-button>
                        </div>
                    </b-form>
                </b-card>
            </b-col>
            <b-col></b-col>
        </b-row>
    </b-container>
</template>

<script>
    export default {
        name: 'Login',
        data () {
            return {
                title: this.$store.getters.title,
                email: '',
                password: ''
            }
        },
        created () {
            if (this.$store.getters.isAuthenticated) {
                this.$router.push('/');
            }
        },
        computed: {
            hasError () {
                return this.$store.getters.hasError;
            },
            error () {
                return this.$store.getters.error;
            }
        },
        methods: {
            login (event) {
                event.preventDefault();

                this.$store.dispatch('login', { login: this.email, password: this.password })
                    .then(() => this.$router.push('/'));
            }
        }
    };
</script>
