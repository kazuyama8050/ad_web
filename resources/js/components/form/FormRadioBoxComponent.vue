<template>
    <div class="mb-3">
        <label class="form-label">{{ thValue }}</label><br>
        <div class="form-check form-check-inline" v-for="(key, message) in options">
            <input class="form-check-input" type="radio" :name="key" :id="key" :value="key">
            <label class="form-check-label" :for="key">{{ message }}</label>
        </div>
    </div>
</template>
<script>
    export default {
        name: "FormRadioBoxComponent",
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