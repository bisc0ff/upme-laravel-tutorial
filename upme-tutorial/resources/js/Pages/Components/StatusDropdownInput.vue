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
    },
    disabled: {
        type: Boolean,
        default: false
    }
})
</script>

<template>
    <div>
    <label for="status" class="block text-sm font-medium text-gray-900">Status</label>
    <select
        :disabled="disabled"
        id="status"
        v-model="model"
        class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-2.5"
    >
        <option value="" selected>Status</option>
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
        <option value="Terminated">Terminated</option>
        <option value="On-leave">On-leave</option>
        <option value="">Deleted</option>
    </select>
    <small class="error" v-if="message">{{ message }}</small>
    </div>

</template>
