<template>
     <!-- <tr>
        <th>{{ thValue }}</th>
        <td>
            <select :name="inputName">
                <option value="">選択してください</option>
                <option v-for="(key, message) in options" :value="key">{{ message }}</option>
            </select>
        </td>
    </tr> -->
    <div class="mb-3">
        <label :for="inputName" class="form-label">{{ thValue }}</label><br>
        <select class="form-select">
            <option selected>Open this select menu</option>
            <option v-for="(key, message) in options" :value="key">{{ message }}</option>
        </select>
    </div>
</template>
<script>
    export default {
        name: "FormSelectBoxComponent",
        props: {
            thValue: {
                type: String,
                required: true,
            },
            options: {
                type: Object,
                required: true,
            },  
            inputName: {
                type: String,
                required: true,
            },
        },
    }
</script>
