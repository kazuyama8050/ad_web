<template>
    <div class="container overflow-hidden">
        <div class="row gy-5">
            <a :href="path" class="text-decoration-none text-reset col-6" v-for="(menu, path) in menuObject">
                <div class="p-3 border bg-light text-center">{{ menu }}</div>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        name: "HomeMenuComponent",
        props: {
            menuObject: {
                type: Object,
                required: true,
            },
        },
    }
</script>