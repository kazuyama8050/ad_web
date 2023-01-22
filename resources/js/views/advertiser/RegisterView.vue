<template>
    <div class="container dummy-header">
        <PageTitleComponent title="アフィリエイト申し込み"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <form v-on:submit.prevent="submit">
            <div class="mb-3">
                <label for="storeAccount" class="form-label">ストア名（半角英字のみ）<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="storeAccount" v-model="form.storeAccount" maxlength="10" required>
            </div>
            <div class="mb-3">
                <label for="companyName" class="form-label">会社名<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="companyName" v-model="form.companyName" required>
            </div>
            <div class="mb-3">
                <label for="companyZipcode" class="form-label">会社郵便番号（[3桁]-[4桁]）<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="companyZipcode" pattern="\d{3}-\d{4}" v-model="form.companyZipcode" required>
            </div>
            <div class="mb-3">
                <label for="companyAddress" class="form-label">会社住所<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="companyAddress" v-model="form.companyAddress" required>
            </div>
            <div class="mb-3">
                <label for="companySiteUrl" class="form-label">会社サイトURL<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="companySiteUrl" v-model="form.companySiteUrl" required>
            </div>
            <div class="mb-3">
                <label for="managerLastName" class="form-label">担当者苗字<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="managerLastName" v-model="form.managerLastName" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="managerFirstName" class="form-label">担当者名前<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="managerFirstName" v-model="form.managerFirstName" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="managerPhone" class="form-label">担当者電話番号（半角）<span class="hissu">必須</span></label>
                <input type="tel" class="form-control" id="managerPhone" v-model="form.managerPhone" required>
            </div>
            <div class="mb-3">
                <label for="managerEmail" class="form-label">担当者Mail（半角）<span class="hissu">必須</span></label>
                <input type="managerEmail" class="form-control" id="managerEmail" v-model="form.managerEmail" required>
            </div>
            <p v-if="responseMessage" class="alert alert-primary" role="alert">{{ responseMessage }}</p>
            <div class="d-grid gap-2 col-6 mx-auto pt-xl-5">
                <button class="btn btn-primary" type="submit">登録</button>
            </div>
        </form>
    </div>
</template>
<script>
import Vue from "vue";
import AlertComponent from "../../components/common/AlertComponent.vue";
import PageTitleComponent from "../../components/common/PageTitleComponent.vue";

export default {
    name: "UserRegister",
    components: {
        PageTitleComponent,
        AlertComponent,
    },
    data: function() {
        return {
            form: [],
            responseMessage: null,
        }
    },
    methods: {
        submit: function() {
            axios.post('/api/register-advertiser-form', {
                storeAccount: this.form.storeAccount,
                companyName: this.form.companyName,
                companyZipcode: this.form.companyZipcode,
                companyAddress: this.form.companyAddress,
                companySiteUrl: this.form.companySiteUrl,
                managerLastName: this.form.managerLastName,
                managerFirstName: this.form.managerFirstName,
                managerPhone: this.form.managerPhone,
                managerEmail: this.form.managerEmail,
            })
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '広告主登録が完了しました。';
                    router.push('advertiser.login')
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
