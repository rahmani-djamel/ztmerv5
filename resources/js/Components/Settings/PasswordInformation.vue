<template>
    <div>
      <h2 class="text-xl font-bold mb-4 flex items-center">
        <KeyIcon class="w-6 h-6 mr-2 text-sky-500" />
         كلمة المرور
      </h2>

      <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="name" class="block text-gray-700">
          كلمة المرور الحالية
        </label>
        <input
          v-model="form.current_password"
          type="password"
          id="name"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          required
        />
        <div v-if="form.errors.current_password" v-text="form.errors.current_password" class="text-red-500 text-xs mt-1"></div>
      </div>

      <div class="mb-4">
        <label for="name" class="block text-gray-700">
          كلمة المرور الجديدة
        </label>
        <input
          v-model="form.password"
          type="password"
          id="name"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          required
        />
        <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
      </div>

      <div class="mb-4">
        <label for="name" class="block text-gray-700">
          تأكيد كلمة المرور الجديدة
        </label>
        <input
          v-model="form.password_confirmation"
          type="password"
          id="name"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          required
        />
        <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation" class="text-red-500 text-xs mt-1"></div>
      </div>
      <button
        type="submit"
        class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600"
      >
        حفظ
      </button>
    </form>
      
    </div>
  </template>
  
  <script setup>
  import { KeyIcon } from '@heroicons/vue/24/solid';
  import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const form = useForm({
  current_password: '',
  password: '',
  password_confirmation: '',
});

// Handle form submission
const submitForm = () => {
  form.post('/setting/update/password-update', {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'تم تحديث   كلمة السر بنجاح',
      });
      form.reset();
    },
  });
};

  </script>
  
  <style scoped>
  </style>