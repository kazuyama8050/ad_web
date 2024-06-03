<template>
    <div class="page-title">{{ title }}</div>
</template>
<script>
    export default {
        name: "PageTitleComponent",
        props: {
            title: {
                type: String,
                required: true,
            },
        },
    }
</script>