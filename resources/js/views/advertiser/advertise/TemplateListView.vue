<template>
    <div class="container">
        <PageTitleComponent title="広告テンプレート一覧"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <RightTopLinkComponent linkUrl="/advertiser/template/create" linkStr="テンプレート作成"></RightTopLinkComponent>
        <div class="row">
            <div class="col d-flex mb-xxl-4" v-for="(value,key) in templates">
                <AdvertiseDesignComponent :value="value"></AdvertiseDesignComponent>
                <div class="btn-group-vertical ms-xxl-4">
                    <button type="button" class="btn btn-primary" v-on:click="create(key)">広告作成</button>
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
import AdvertiseDesignComponent from "../../../components/common/AdvertiseDesignComponent.vue";
import RightTopLinkComponent from "../../../components/common/RightTopLinkComponent.vue";

export default {
    name: "AdvertiserTemplateList",
    components: {
        PageTitleComponent,
        AlertComponent,
        AdvertiseDesignComponent,
        RightTopLinkComponent,
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
            axios.get('/api/advertiser-template-list')
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
        del: function(templateId) {
            axios.delete('/api/advertiser-template/' + templateId)
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