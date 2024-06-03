<template>
    <div class="alert alert-primary" role="alert" v-if="responseMessage !== null">{{ responseMessage }}</div>
</template>
<script>
    export default {
        name: "HomeMenuComponent",
        props: {
            responseMessage: {
                type: String,
                required: false,
                default: null,
            },
        },
    }
</script>