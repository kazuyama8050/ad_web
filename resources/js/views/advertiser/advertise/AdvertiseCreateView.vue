<template>
    <div class="container">
        <PageTitleComponent title="広告作成"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <RightTopLinkComponent linkUrl="/advertiser/advertise/list" linkStr="広告一覧"></RightTopLinkComponent>
        <AdvertiseDesignComponent :value="template"></AdvertiseDesignComponent>
        <hr>
        <form v-on:submit.prevent="submit">
            <div class="mb-3">
                <label for="advertiseName" class="form-label">広告名<span class="hissu">必須</span></label>
                <input type="advertiseName" class="form-control" id="advertiseName" v-model="form.advertiseName" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">価格<span class="hissu">必須</span></label>
                <input type="price" class="form-control" id="price" v-model="form.price" required>
            </div>
            <div class="mb-3">
                <label for="category_level" class="form-label">ジャンルカテゴリ階層<span class="hissu">必須</span></label><br>
                <select class="form-select" v-model="form.categoryLevel" v-on:change="categoryLevelChange()" required>
                    <option v-for="(value, key) in categoryLevels" :value="key">{{ value }}</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">ジャンルカテゴリ<span class="hissu">必須</span></label><br>
                <select class="form-select" v-model="form.categoryId" required>
                    <option selected>Open this select menu</option>
                    <option v-for="(category) in categories" :value="category.id">{{ category.name }}</option>
                </select>
            </div>
            <p v-if="responseMessage" class="alert alert-primary" role="alert">{{ responseMessage }}</p>
            <div class="d-grid gap-2 col-6 mx-auto pt-xl-5">
                <button class="btn btn-primary" type="submit">作成</button>
            </div>
        </form>
    </div>
</template>
<script>
import Vue from "vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";
import AlertComponent from "../../../components/common/AlertComponent.vue";
import AdvertiseDesignComponent from "../../../components/common/AdvertiseDesignComponent.vue";
import RightTopLinkComponent from "../../../components/common/RightTopLinkComponent.vue";

const categoryLevels = {
    'level1' : '階層1',
    'level2' : '階層2',
    'level3' : '階層3',
};

export default {
    name: "AdvertiserAdvertiseCreate",
    components: {
        PageTitleComponent,
        AlertComponent,
        AdvertiseDesignComponent,
        RightTopLinkComponent,
    },
    data: function() {
        return {
            categoryLevels,
            allCategories: Object,
            categories: Object,
            template: Object,
            form: [],
            responseMessage: null,
        }
    },
    methods: {
        getTemplate() {
            this.$route.params.templateId
            axios.get('/api/advertiser-template/' + this.$route.params.templateId)
                .then((res) => {
                    this.template = res.data;
                })
                .catch(error =>{
                    this.responseMessage = error.response.data.message;
                });
        },  
        getAllCategories() {
            axios.get('/api/advertiser-category-all')
                .then((res) => {
                    this.allCategories = res.data;
                    const targetLevel = 'level1'
                    this.categories = this.allCategories[targetLevel]
                });
        },
        categoryLevelChange() {
            const targetLevel = this.form.categoryLevel
            this.categories = this.allCategories[targetLevel]
        },
        submit: function() {
            const formData = new FormData()
            formData.append('categoryId', this.form.categoryId);
            formData.append('templateId', this.template.id);
            formData.append('name', this.form.name);
            formData.append('price', this.form.price);
            axios.post('/api/advertiser-advertise', formData)
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '広告を作成しました。';
                    window.location.href = "/advertiser/advertise/list";
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
        this.getTemplate();
    }
}
</script>