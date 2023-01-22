<template>
    <a class="nav-link" href="#" @click="logout">ログアウト</a>
</template>
<script>
    export default {
        name: "LogoutComponent",
        props: {
            target: {
                type: String,
                required: true,
            },
        },
        data: function() {
            return {
                responseMessage: null,
            }
        },
        methods: {
            logout: function() {
                axios.get('/api/logout/'+this.target)
                    .then((res) => {
                        location.reload();
                    })
                    .catch(error =>{
                    this.responseMessage = error.response.data.message;
                });
            },
        },
    }
</script>