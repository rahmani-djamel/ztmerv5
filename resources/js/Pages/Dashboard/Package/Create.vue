<template>
    <Head title="إضافة صنف" />
    <PanelLayout>
  
      <div class="container mx-auto p-4">
        <Header>إضافة صنف</Header>
  
        <div class="p-4 rounded bg-white dark:bg-gray-800">
          <form @submit.prevent="saveCategory" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Form Section -->
            <div class="md:col-span-3 bg-white dark:bg-gray-800 p-2">
              <div class="mb-4">
                <label for="productName" class="block text-gray-700 dark:text-gray-300">اسم</label>
                <input
                  type="text"
                  id="productName"
                  v-model="form.name"
                  class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                />
                <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
              </div>

            </div>
            <!-- Submit Button -->
            <div class="md:col-span-3">
              <button type="submit" class="mt-3 w-full text-white bg-sky-500 dark:bg-sky-600 text-center p-1 rounded shadow-md md:mt-0 md:mb-3">
                إضافة
              </button>
            </div>
          </form>
        </div>
      </div>
    </PanelLayout>
  </template>
    
    <script setup>
    import PanelLayout from '@/Layouts/PanelLayout.vue';
    import { ref } from 'vue';
    import { Head, useForm, router } from '@inertiajs/vue3';
    import { TrashIcon } from '@heroicons/vue/24/solid';
    import Swal from 'sweetalert2';
    
    const form = useForm({
      name: '',
    });
    
    

    const saveCategory = () => {
    // Add your save logic here
    form.post('/package/create', {
      onSuccess: () => {
        Swal.fire('نجاح', 'تم إنشاء نوع التغليف بنجاح', 'success');
      },
      onError: () => {
        Swal.fire('خطأ', 'حدث خطأ أثناء إنشاء نوع التغليف', 'error');
      }
    });
  };
    </script>
    <style lang="css" scoped>
  .container {
    max-width: 1200px;
  }
  </style>