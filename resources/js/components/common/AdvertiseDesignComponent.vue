<template>
    <a class="adlink-container text-decoration-none text-reset" :href="value.url">
        <div class="adlink-element">
            <img class="" :src="'http://localhost:8080/'+value.imagePath" alt="">
        </div>
        <div class="adlink-element">
            <p class="">{{ value.bannerText }}</p>
        </div>
    </a>
</template>
<script>
    export default {
        name: "AdvertiseDesignComponent",
        props: {
            value: {
                type: Object,
                required: true,
            },
        },
    }
</script>