<template>
    <div class="wrapper">
        Logged in as: {{ userEmail }} <a :href=logoutPath>Logout</a>
    </div>
</template>

<script>
    export default {
        name: 'App',
        components: {},
        data() {
            return {
                userEmail: this.$config.userEmail,
                logoutPath: this.$config.logoutPath
            }
        }
    }
</script>
