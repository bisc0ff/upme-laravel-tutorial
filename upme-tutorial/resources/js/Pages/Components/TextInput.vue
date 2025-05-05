<script setup>

const model = defineModel({
    type: null,
    required: true
});

defineProps({
    name: {
        type: String, 
        required: true,
        maxLength: 255
    },
    type:{
        type: String,
        default: 'text'
    },
    message: {
        type: String
    }

})
</script>

<template>

    <div class="mb-6">
        <label for="name">{{ name }}</label>
        <input :type="type" v-model="model" :class="{'!ring-red-500' :message}" />
        <small class="error" v-if="message">{{ message }}</small>
    </div>

</template>
