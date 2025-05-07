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

function handleInput(e) {
  const input = e.target.value;
  if (!input.startsWith('+639')) {
    model.value = '+639' + input.replace(/^(\+63|0|639)?/, '');
  }
}
</script>

<template>
    <div class="mb-6">
        <label for="cellphone_num" class="block mb-2 text-sm font-medium text-gray-900">Cellphone Number</label>
        <div class="flex rounded-md shadow-sm">
            <input
                id="cellphone_num"
                 @input="handleInput"
                type="text"
                :disabled="disabled"
                maxlength="12"
                v-model="model"
                class="rounded-none rounded-r-md border border-gray-300 block flex-1 min-w-0 w-full text-sm p-2.5"
                placeholder="1231234"
            />
        </div>
        <small class="error" v-if="message">{{ message }}</small>
    </div>
</template>