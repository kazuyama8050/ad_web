<template>
    <div class="container">
        <PageTitleComponent title="アフィリエイター"></PageTitleComponent>
        <TabComponent :tabObject="tabObject" :activePage="activePage"></TabComponent>
    </div>
</template>
<script>
import Vue from "vue";
import TabComponent from "../../../components/common/TabComponent.vue";
import PageTitleComponent from "../../../components/common/PageTitleComponent.vue";

const tabObject = {
    '/admin/deliveler':  '登録済み一覧',
    '/admin/deliveler/no-registered': '未審査一覧',
};
const activePage = '/admin/deliveler';
export default {
    name: "AdminDeliveler",
    components: {
        TabComponent,
        PageTitleComponent,
    },
    data: function() {
        return {
            tabObject,
            activePage,
        }
    },
}
</script>