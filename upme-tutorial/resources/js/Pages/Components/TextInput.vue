<script setup>
const props = defineProps({
  name: {
    type: String,
    required: true,
    maxLength: 255,
  },
  type: {
    type: String,
    default: 'text',
  },
  message: {
    type: String,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  modelValue: {
    type: [String, Number],
    default: '',
  },
});

// Emit the update to the parent when the input changes
const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="mb-6 flex-1">
    <label :for="name">{{ name }}</label>
    <input
      :name="name"
      :type="type"
      :value="modelValue"
      :disabled="disabled"
      @input="$emit('update:modelValue', $event.target.value)"
    />
    <small v-if="message" class="text-red-500 text-xs">{{ message }}</small>
  </div>
</template>
