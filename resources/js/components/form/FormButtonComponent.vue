<template>
    <div class="form_btn_center">
        <p class="btn">
            <span><input type="submit" value="確認" /></span>
        </p>
    </div>
</template>
<script>
    export default {
        name: "FormButtonComponent",
        props: {
            inputValue: {
                type: String,
                required: true,
            },
        },
    }
</script>