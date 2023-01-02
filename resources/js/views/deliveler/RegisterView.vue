<template>
    <div class="container dummy-header">
        <div class="page-title">会員登録フォーム</div>
        <form v-on:submit.prevent="submit" v-if="done == false">
            <div class="mb-3">
                <label for="lastName" class="form-label">苗字<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="lastName" v-model="form.lastName" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">名前<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="firstName" v-model="form.firstName" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">電話番号（半角）<span class="hissu">必須</span></label>
                <input type="tel" class="form-control" id="phone" v-model="form.phone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Mail（半角）<span class="hissu">必須</span></label>
                <input type="email" class="form-control" id="email" v-model="form.email" required>
            </div>
            <div class="mb-3">
                <label for="siteDomein" class="form-label">サイトドメイン<span class="hissu">必須</span></label>
                <input type="text" class="form-control" id="siteDomein" v-model="form.siteDomein" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">ジャンルカテゴリ<span class="hissu">必須</span></label><br>
                <select class="form-select" v-model="form.category" required>
                    <option selected>Open this select menu</option>
                    <option v-for="(message) in categories" :value="message.name">{{ message.name }}</option>
                </select>
            </div>
            <!-- <FormButtonComponent inputValue="確認" /> -->
            <p>{{ responseMessage }}</p>
            <div class="d-grid gap-2 col-6 mx-auto pt-xl-5">
                <button class="btn btn-primary" type="submit">確認</button>
            </div>
        </form>
        <p v-if="done == true">{{ responseMessage }}</p>
    </div>
</template>
<script>
import Vue from "vue";
import FormTextComponent from "../../components/form/FormTextComponent.vue";
import FormSelectBoxComponent from "../../components/form/FormSelectBoxComponent.vue";
import FormRadioBoxComponent from "../../components/form/FormRadioBoxComponent.vue";
import FormButtonComponent from "../../components/form/FormButtonComponent.vue";

export default {
    name: "DelivelerRegister",
    components: {
        FormTextComponent,
        FormSelectBoxComponent,
        FormRadioBoxComponent,
        FormButtonComponent,
    },
    data: function() {
        return {
            categories: [],
            form: [],
            responseMessage: null,
            done: false,
        }
    },
    methods: {
        getAllCategories() {
            axios.get('/api/first-level-categories')
                .then((res) => {
                    this.categories = res.data;
                });
        },
        submit: function() {
            axios.post('/api/register-deliveler-form', {
                lastName: this.form.lastName,
                firstName: this.form.firstName,
                phone: this.form.phone,
                email: this.form.email,
                siteDomein: this.form.siteDomein,
                category: this.form.category,
            })
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '仮登録が完了しました。';
                    this.done = true;
                } else {
                    this.responseMessage = '予期せぬエラーが発生しました。'
                }
            })
            .catch(error =>{
                this.responseMessage = error.response.data.message;
            });
        },
    },
    mounted() {
        this.getAllCategories();
    }
}
</script>
