<template>
    <div class="alert alert-danger" role="alert">
        {{ errorMessage }}
        <ul v-if="errors.length > 0">
            <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'FormErrors',
        props: {
            errorMessage: {
                type: String,
                required: true
            },
            errors: {
                type: Array,
                required: true
            }
        }
    };
</script>
