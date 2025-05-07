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
    //type of input
    type:{
        type: Boolean,
        default: false
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
    <div class="flex items-start mb-6">
        <div class="flex flex-col items-start space-y-1">
            <!-- Checkbox + Label -->
            <div class="flex items-center space-x-2">
            <input
                id="helper-checkbox"
                type="checkbox"
                v-model="model"
                :disabled="disabled"
                :class="[
                'w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600',
                message && '!ring-red-500 !border-red-500'
                ]"
                aria-describedby="helper-checkbox-text"
            />
            <label for="helper-checkbox" class="text-sm font-medium text-gray-900 dark:text-black-300">
                {{ name }}
            </label>
            </div>

            <!-- Description -->
            <p id="helper-checkbox-text" class="text-xs text-gray-500 dark:text-gray-400">
            Admins can CRUD all employees.
            </p>

            <!-- Error Message -->
            <small v-if="message" class="text-red-500 block">{{ message }}</small>
        </div>
    </div>
</template>
