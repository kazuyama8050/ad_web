<template>
    <div class="mb-3">
        <label :for="inputName" class="form-label">{{ thValue }}<span :class="spanClass">{{ spanValue }}</span></label>
        <input :type="inputType" class="form-control" :id="inputName">
    </div>
</template>
<script>
    export default {
        name: "FormTextComponent",
        props: {
            thValue: {
                type: String,
                required: true,
            },
            spanValue: {
                type: String,
                required: false,
                default: "必須",
            },
            textSize: {
                type: String,
                required: false,
                default: "20",
            },
            inputName: {
                type: String,
                required: true,
            },
            inputType: {
                type: String,
                required: false,
                default: "text",
            },
        },
        setup(props) {
            const spanValue = props.spanValue;
            var spanClass = "hissu";
            if (spanValue == null) {
                spanClass = "display-none";
            }
            return {
                spanClass,
            }
        }
    }
</script>
