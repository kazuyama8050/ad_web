<template>
    <div class="login">
        <div class="login-triangle"></div>
        
        <h2 class="login-header">Log in</h2>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>

        <form class="login-container" v-on:submit.prevent="submit">
            <p><input type="text" placeholder="ストアアカウント" v-model="form.storeAccount" required></p>
            <p><input type="password" placeholder="Password" v-model="form.password" required></p>
            <p><button class="" type="submit">Log In</button></p>
        </form>
    </div>
</template>
<script>
import Vue from "vue";
import AlertComponent from "../../components/common/AlertComponent.vue";

export default {
    name: "AdvertiserLogin",
    components: {
        AlertComponent,
    },
    data: function() {
        return {
            form: [],
            responseMessage: null,
            router: null,
        }
    },
    methods: {
        submit: function() {
            axios.post('/api/login-advertiser', {
                email: this.form.storeAccount,
                password: this.form.password,
            })
            .then((res) => {
                if (res.status == 200) {
                    location.reload();
                } else {
                    this.responseMessage = '予期せぬエラーが発生しました。'
                }
            })
            .catch(error =>{
                this.responseMessage = error.response.data.message;
            });
        },
    },
}
</script>
