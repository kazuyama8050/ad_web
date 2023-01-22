<template>
    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" v-for="(value, key) in headList">{{ value }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(value, keys) in Object.keys(headList)">
                    <td v-for="(key) in keys">{{ value[key] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        name: "TableListComponent",
        props: {
            headList: {
                type: Object,
                required: true,
            },
            bodyList: {
                type: Object,
                required: true,
            },
        },
    }
</script>