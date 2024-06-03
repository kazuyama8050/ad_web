<template>
    <div class="right-top-link">
        <a :href="linkUrl">{{ linkStr }}</a>
    </div>
</template>
<script>
    export default {
        name: "RightTopLinkComponent",
        props: {
            linkUrl: {
                type: String,
                required: true,
            },
            linkStr: {
                type: String,
                required: true,
            },
        },
    }
</script>