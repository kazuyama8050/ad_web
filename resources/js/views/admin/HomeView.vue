<template>
    <HomeMenuComponent :menuObject="menuObject"></HomeMenuComponent>
</template>
<script>
import Vue from "vue";
import HomeMenuComponent from "../../components/common/HomeMenuComponent.vue";

const menuObject = {
    'advertise':  '広告',
    'user': 'アフィリエイター',
    'advertiser': '広告主',
};
export default {
    name: "AdminHome",
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