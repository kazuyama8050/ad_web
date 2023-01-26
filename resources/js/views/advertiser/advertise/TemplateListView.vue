<template>
    <div class="container">
        <PageTitleComponent title="広告テンプレート一覧"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <div class="row">
            <div class="col d-flex mb-xxl-4" v-for="(value,key) in templates">
                <a class="adlink-container text-decoration-none text-reset" :href="value.url">
                    <div class="adlink-element">
                        <img class="" :src="'http://localhost:8080/'+value.imagePath" alt="">
                    </div>
                    <div class="adlink-element">
                        <p class="">{{ value.bannerText }}</p>
                    </div>
                </a>
                <div class="btn-group-vertical ms-xxl-4">
                    <button type="button" class="btn btn-primary" v-on:click="create(key)">広告作成</button>
                    <button type="button" class="btn btn-primary" v-on:click="edit(key)">編集</button>
                    <button type="button" class="btn btn-primary" v-on:click="del(key)">削除</button>
                </div>
            </div>
        </div>
        
    </div>
</template>
<script>
import Vue from "vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";
import AlertComponent from "../../../components/common/AlertComponent.vue";

export default {
    name: "AdvertiserTemplateList",
    components: {
        PageTitleComponent,
        AlertComponent,
    },

    data: function() {
        return {
            form: [],
            responseMessage: null,
            templateId: null,
            templates: [],
        }
    },
    methods: {
        getTemplateList() {
            axios.get('/api/advertise-template-list')
                .then((res) => {
                    this.templates = res.data;
                })
                .catch(error =>{
                    this.responseMessage = error.response.data.message;
                });
                
        },
        create: function(templateId) {
            window.location.href = "/advertiser/advertise/create/"+templateId;
        },
        edit: function(templateId) {
            window.location.href = "/advertiser/advertise/edit/"+templateId;
        },
        del: function(templateId) {
            axios.delete('/api/advertise-template/' + templateId)
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = 'テンプレートを削除しました。';
                    this.getTemplateList();
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
        this.getTemplateList();
    },
}
</script>