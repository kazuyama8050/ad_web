<template>
    <div class="container">
        <PageTitleComponent title="アフィリエイター"></PageTitleComponent>
        <AlertComponent :responseMessage="responseMessage"></AlertComponent>
        <TabComponent :tabObject="tabObject" :activePage="activePage"></TabComponent>
        <TableListComponent :headList="userHeadList" :bodyList="users"></TableListComponent>
    </div>
</template>
<script>
import Vue from "vue";
import TabComponent from "../../../components/common/TabComponent.vue";
import AlertComponent from "../../../components/common/AlertComponent.vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";
import TableListComponent from "../../../components/common/TableListComponent.vue";

const tabObject = {
    '/admin/user':  '登録済み一覧',
    '/admin/user/no-registered': '未審査一覧',
};
const activePage = '/admin/user';

const userHeadList = {
    'lastName': '苗字',
    'firstName': '名前',
    'phone': '電話番号',
    'email': 'メールアドレス',
    'zipcode': '郵便番号',
    'address': '住所',
    'paymentWay': '支払い方法',
    'budget': '予算',
    'isStopped': '停止済みフラグ',
    'isRetire': '退会済みフラグ',
};

export default {
    name: "AdminUser",
    components: {
        TabComponent,
        PageTitleComponent,
        TableListComponent,
        AlertComponent,
    },
    data: function() {
        return {
            tabObject,
            activePage,
            data: [],
            responseMessage: null,
            userHeadList,
            users: [],
        }
    },
    methods: {
        getAllUser() {
            axios.get('/api/all-user')
                .then((res) => {
                    this.users = res.data;
                })
                .catch(error =>{
                this.responseMessage = error.response.data.message;
            });
        },
    },
    mounted() {
        this.getAllUser();
    },
}
</script>