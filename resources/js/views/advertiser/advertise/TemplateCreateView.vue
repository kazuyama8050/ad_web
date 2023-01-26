<template>
    <div class="container">
        <PageTitleComponent title="広告テンプレート作成"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <form v-on:submit.prevent="submit">
            <div class="mb-3">
                <label for="url" class="form-label">遷移先URL<span class="hissu">必須</span></label>
                <input type="url" class="form-control" id="url" v-model="form.url" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">バナー画像<span class="hissu">必須</span></label>
                <div class="input-group">
                    <input type="file" class="form-control" id="image" aria-label="Upload" @change="onCheckUploaded" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="text" class="form-label">バナーテキスト<span class="hissu">必須</span></label>
                <div class="input-group">
                    <span class="input-group-text">テキスト</span>
                    <textarea class="form-control" aria-label="With textarea" id="text" v-model="form.bannerText" required></textarea>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto pt-xl-5">
                <button class="btn btn-primary" type="submit">登録</button>
            </div>
        </form>
    </div>
</template>
<script>
import Vue from "vue";
import FormTextComponent from "../../../components/form/FormTextComponent.vue";
import FormSelectBoxComponent from "../../../components/form/FormSelectBoxComponent.vue";
import FormRadioBoxComponent from "../../../components/form/FormRadioBoxComponent.vue";
import FormButtonComponent from "../../../components/form/FormButtonComponent.vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";
import AlertComponent from "../../../components/common/AlertComponent.vue";

export default {
    name: "AdvertiserTemplateCreate",
    components: {
        FormTextComponent,
        FormSelectBoxComponent,
        FormRadioBoxComponent,
        FormButtonComponent,
        PageTitleComponent,
        AlertComponent,
    },
    data: function() {
        return {
            form: [],
            responseMessage: null,
            image: '',
        }
    },
    methods: {
        onCheckUploaded(e) {
            // event(=e)から画像データを取得する
            this.image = e.target.files[0];
            let size = this.image.size,
            type = this.image.type;

            // 2MBまで
            if (size > 2000000) {
                this.responseMessage = '画像サイズは2MBまでです。';
                this.validateFileError();
            }

            if (type != 'image/jpg' && type != 'image/png') {
                this.responseMessage = '画像タイプはjpg、pngのみです。';
                this.validateFileError();
            }
        },
        validateFileError() {
            var fileObj = document.getElementById("image");
            fileObj.value = "";
            this.image = '';
        },
        submit: function() {
            if (this.image == '') {
                return;
            }
            const config = {
                headers: {
                'content-type': 'multipart/form-data'
                }
            };
            const formData = new FormData()
            formData.append('bannerImage', this.image);
            formData.append('bannerText', this.form.bannerText);
            formData.append('url', this.form.url);
            axios.post('/api/advertise-template', formData, config)
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '広告テンプレートを登録しました。';
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
}
</script>