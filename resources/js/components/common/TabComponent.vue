<template>
    <ul class="nav nav-tabs">
        <li class="nav-item" v-for="(value, path) in tabObject">
            <a class="nav-link active" aria-current="page" href="#" v-if="activePage == path">{{ value }}</a>
            <a class="nav-link text-reset" :href="path" v-if="activePage != path">{{ value }}</a>
        </li>
    </ul>
</template>
<script>
    export default {
        name: "TabComponent",
        props: {
            tabObject: {
                type: Object,
                required: true,
            },
            activePage: {
                type: String,
                required: true,
            },
        },
    }
</script>