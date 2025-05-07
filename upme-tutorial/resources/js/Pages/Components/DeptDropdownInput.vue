<script setup>

const model = defineModel({
    type: null,
    required: true
});

defineProps({
    modelValue: String, 
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
    },
    disabled: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div>
    <label for="department" class="block mb-2 text-sm font-medium text-gray-900">Department</label>
    <select
        id="department"
        :disabled="disabled"
        v-model="model"
        class="bg-gray-50 border  text-gray-900 text-sm rounded-lg block w-full p-2.5"
    >
        <option value="" disabled selected>Choose department</option>
        <option value="Product and Technology">Product and Technology</option>
        <option value="Sales">Sales</option>
        <option value="Marketing">Marketing</option>
        <option value="HR/Admin">HR/Admin</option>
        <option value="Finance">Finance</option>
    </select>
    <small class="error" v-if="message">{{ message }}</small>
    </div>

</template>
