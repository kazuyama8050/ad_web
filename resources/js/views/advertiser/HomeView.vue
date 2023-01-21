<template>
    <HomeMenuComponent :menuObject="menuObject"></HomeMenuComponent>
</template>
<script>
import Vue from "vue";
import HomeMenuComponent from "../../components/common/HomeMenuComponent.vue";

const menuObject = {
    'advertise':  '広告',
    'report': 'レポート',
    'deposit': '入金',
};
export default {
    name: "UserHome",
    components: {
        HomeMenuComponent,
    },
    data: function() {
        return {
            menuObject,
        }
    },
}
</script>