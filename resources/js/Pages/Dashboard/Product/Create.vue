<template>
    <Head title="إضافة منتج" />
    <PanelLayout>
      <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Form Section -->
          <div class="md:col-span-2 bg-white p-4 rounded shadow">
            <form @submit.prevent="submitForm">
              <div class="mb-4">
                <label for="productName" class="block text-gray-700">اسم المنتج</label>
                <input type="text" id="productName" v-model="productName" class="w-full p-2 border border-gray-300 rounded" />
              </div>
              <div class="mb-4">
                <label for="description" class="block text-gray-700">الوصف</label>
                <textarea id="description" v-model="description" class="w-full p-2 border border-gray-300 rounded"></textarea>
              </div>
              <div class="mb-4">
                <label for="city" class="block text-gray-700">المدينة</label>
                <input type="text" id="city" v-model="city" class="w-full p-2 border border-gray-300 rounded" />
              </div>
              <div class="mb-4">
                <label for="qte" class="block text-gray-700">الكمية</label>
                <input type="number" id="qte" v-model="qte" class="w-full p-2 border border-gray-300 rounded" />
              </div>
              <div class="mb-4">
                <label for="price" class="block text-gray-700">السعر</label>
                <input type="number" id="price" v-model="price" class="w-full p-2 border border-gray-300 rounded" />
              </div>
              <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full md:w-auto">إضافة المنتج</button>
            </form>
          </div>
          <!-- File Upload Section -->

        </div>
      </div>
    </PanelLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { Head } from '@inertiajs/vue3';
  </script>
  