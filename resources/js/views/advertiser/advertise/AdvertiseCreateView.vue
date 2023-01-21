<template>
    <div class="container">
        <PageTitleComponent title="広告作成"></PageTitleComponent>
        <form v-on:submit.prevent="submit">
            <div class="mb-3">
                <label for="url" class="form-label">遷移先URL<span class="hissu">必須</span></label>
                <input type="url" class="form-control" id="url" v-model="form.url" required>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">テキスト<span class="hissu">必須</span></label>
                <textarea class="form-control" id="text" v-model="form.text" required></textarea>
            </div>
            <div class="mb-3">
                <label for="category_level" class="form-label">ジャンルカテゴリ階層<span class="hissu">必須</span></label><br>
                <select class="form-select" v-model="form.category_level" required>
                    <option v-for="(message) in category_levels" :value="message.name">{{ message.name }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">ジャンルカテゴリ<span class="hissu">必須</span></label><br>
                <select class="form-select" v-model="form.category" required>
                    <option selected>Open this select menu</option>
                    <option v-for="(message) in categories" :value="message.name">{{ message.name }}</option>
                </select>
            </div>
            <p v-if="responseMessage" class="alert alert-primary" role="alert">{{ responseMessage }}</p>
            <div class="d-grid gap-2 col-6 mx-auto pt-xl-5">
                <button class="btn btn-primary" type="submit">確認</button>
            </div>
        </form>
        <p v-if="done == true">{{ responseMessage }}</p>
    </div>
</template>
<script>
import Vue from "vue";
import FormTextComponent from "../../../components/form/FormTextComponent.vue";
import FormSelectBoxComponent from "../../../components/form/FormSelectBoxComponent.vue";
import FormRadioBoxComponent from "../../../components/form/FormRadioBoxComponent.vue";
import FormButtonComponent from "../../../components/form/FormButtonComponent.vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";

export default {
    name: "UserAdvertiseCreate",
    components: {
        FormTextComponent,
        FormSelectBoxComponent,
        FormRadioBoxComponent,
        FormButtonComponent,
        PageTitleComponent,
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
            axios.get('/api/all-categories')
                .then((res) => {
                    this.categories = res.data;
                });
        },
        submit: function() {
            axios.post('/api/register-user-form', {
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