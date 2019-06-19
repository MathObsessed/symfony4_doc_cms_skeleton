<template>
    <b-container>
        <b-row>
            <b-col></b-col>
            <b-col cols="5">
                <b-card class="mt-5" :header=title header-bg-variant="dark" header-text-variant="white" title="Registration">
                    <form-errors v-if="hasError" v-bind:error-message="errorMessage" v-bind:errors="errors"/>

                    <b-form @submit="register">
                        <b-form-group label="Email:" label-for="email">
                            <b-form-input v-model="email" type="email" required></b-form-input>
                        </b-form-group>

                        <b-form-group label="Password:" label-for="password">
                            <b-form-input v-model="password" type="password" required></b-form-input>
                        </b-form-group>

                        <p>
                            <router-link :to="{ name: 'app_homepage' }">Go back</router-link>
                        </p>

                        <div class="text-center">
                            <b-button type="submit" variant="dark">Register</b-button>
                        </div>
                    </b-form>
                </b-card>
            </b-col>
            <b-col></b-col>
        </b-row>
    </b-container>
</template>

<script>
    import FormErrors from '../ui/FormErrors';

    export default {
        name: 'RegisterPage',
        components: { FormErrors },
        data () {
            return {
                title: this.$store.getters.title,
                email: '',
                password: ''
            }
        },
        created () {
            if (this.$store.getters.isAuthenticated) {
                this.$router.push({ name: 'app_homepage' });
            }
        },
        computed: {
            hasError () {
                return this.$store.getters.hasError;
            },
            errorMessage () {
                return this.$store.getters.errorMessage;
            },
            errors () {
                return this.$store.getters.errors;
            }
        },
        methods: {
            register (event) {
                event.preventDefault();

                this.$store.dispatch('register', { login: this.email, password: this.password })
                    .then(() => !this.hasError && this.$router.push({ name: 'app_login' }));
            }
        }
    };
</script>
