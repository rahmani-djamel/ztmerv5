<template>
  <div>
    <h2 class="text-xl font-bold mb-4 flex items-center dark:text-white">
      <KeyIcon class="w-6 h-6 mr-2 text-sky-500 dark:text-sky-400" />
      كلمة المرور
    </h2>

    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="current_password" class="block text-gray-700 dark:text-gray-300">
          كلمة المرور الحالية
        </label>
        <input
          v-model="form.current_password"
          type="password"
          id="current_password"
          class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100"
          required
        />
        <div v-if="form.errors.current_password" v-text="form.errors.current_password" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
      </div>

      <div class="mb-4">
        <label for="new_password" class="block text-gray-700 dark:text-gray-300">
          كلمة المرور الجديدة
        </label>
        <input
          v-model="form.password"
          type="password"
          id="new_password"
          class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100"
          required
        />
        <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
      </div>

      <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300">
          تأكيد كلمة المرور الجديدة
        </label>
        <input
          v-model="form.password_confirmation"
          type="password"
          id="password_confirmation"
          class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100"
          required
        />
        <div v-if="form.errors.password_confirmation" v-text="form.errors.password_confirmation" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
      </div>
      <button
        type="submit"
        class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600 dark:bg-sky-600 dark:hover:bg-sky-700"
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