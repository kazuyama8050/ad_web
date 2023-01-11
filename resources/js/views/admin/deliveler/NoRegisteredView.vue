<template>
    <div class="container">
        <PageTitleComponent title="アフィリエイター 審査待ち"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <TabComponent :tabObject="tabObject" :activePage="activePage"></TabComponent>
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">苗字</th>
                        <th scope="col">名前</th>
                        <th scope="col">電話番号</th>
                        <th scope="col">メールアドレス</th>
                        <th scope="col">サイトドメイン</th>
                        <th scope="col">カテゴリ</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, key) in delivelers">
                        <td>{{ value.lastName }}</td>
                        <td>{{ value.firstName }}</td>
                        <td>{{ value.phone }}</td>
                        <td>{{ value.email }}</td>
                        <td>{{ value.siteDomein }}</td>
                        <td>{{ value.category }}</td>
                        <td><button type="button" class="btn btn-success" v-on:click="approve(key)">承認</button></td>
                        <td><button type="button" class="btn btn-danger" v-on:click="disapprove(key)">非承認</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import Vue from "vue";
import TabComponent from "../../../components/common/TabComponent.vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";
import AlertComponent from "../../../components/common/AlertComponent.vue";

const tabObject = {
    '/admin/deliveler':  '登録済み一覧',
    '/admin/deliveler/no-registered': '未審査一覧',
};
const activePage = '/admin/deliveler/no-registered';
export default {
    name: "AdminDelivelerNoRegistered",
    components: {
        TabComponent,
        PageTitleComponent,
        AlertComponent,
    },
    data: function() {
        return {
            tabObject,
            activePage,
            delivelers: [],
            form: [],
            responseMessage: null,
        }
    },
    methods: {
        getNoRegisteredDeliveler() {
            axios.get('/api/deliveler-no-registered')
                .then((res) => {
                    this.delivelers = res.data;
                })
                .catch(error =>{
                    this.responseMessage = error.response.data.message;
                });
                
        },
        approve: function(userExaminationId) {
            axios.post('/api/approve-deliveler-form', {
                userExaminationId: userExaminationId,
            })
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '審査承認にしました。';
                    this.getNoRegisteredDeliveler();
                } else {
                    this.responseMessage = '予期せぬエラーが発生しました。'
                }
            })
            .catch(error =>{
                this.responseMessage = error.response.data.message;
            });
        },
        disapprove: function(userExaminationId) {
            axios.post('/api/disapprove-deliveler-form', {
                userExaminationId: userExaminationId,
            })
            .then((res) => {
                if (res.status == 200) {
                    this.responseMessage = '審査非承認にしました。';
                    this.getNoRegisteredDeliveler();
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
        this.getNoRegisteredDeliveler();
    },
}
</script>