<template>
    <div>
      <select
        :id="id"
        :class="class"
        v-model="selectedValue"
        :required="required"
        :autocomplete="autocomplete"
        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-full"
      >
        <option value="" disabled>
          يرجى اختيار
        </option>
        <option v-for="(value, key) in options" :key="key" :value="key">
          {{ value }}
        </option>
      </select>
    </div>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  
  const props = defineProps({
    id: {
      type: String,
      required: false,
    },
    class: {
      type: String,
      required: false,
    },
    modelValue: {
      type: [String, Number],
      required: true,
    },
    options: {
      type: Object,
      required: true,
    },
    required: {
      type: Boolean,
      required: false,
    },
    autocomplete: {
      type: String,
      required: false,
    },
  });
  
  const emit = defineEmits(['update:modelValue']);
  const selectedValue = ref(props.modelValue);
  
  watch(selectedValue, (newValue) => {
    emit('update:modelValue', newValue);
  });
  </script>
  
  <style scoped>
  /* Add any styles you need here */
  </style>