<template>
    <Head title="المتاجر" />
    <PanelLayout>
      <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <Link :href="route('product.create')" class="w-full md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <PlusIcon class="w-5 h-5 mr-2" />
                    إضافة متجر
                </Link>
                <div class="relative w-full md:w-auto">
                    <label for="name" class="absolute -top-2 right-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">
                    بحث
                    </label>
                    <input
                    type="text"
                    name="search"
                    v-model="search"
                    id="name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    placeholder="إبحث عن متجر"
                    />
                </div>
            </div>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th class="py-2 text-right">اسم المحل</th>
                <th class="py-2 text-right">
                    العنوان
                </th>
                <th class="py-2 text-right">
                    المدينة
                </th>
                <th class="py-2 text-right">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="product in products" :key="product.id" class="border-t">
                <td class="py-2 flex items-start">
                    <img :src="product.avatar" alt="الصورة" class="hidden sm:block w-10 h-10 rounded-full mr-2" />
                    <span class="mt-1">{{ product.name }}</span>
                </td>
                <td class="py-2">{{ product.price }}</td>
                <td class="py-2">{{ product.quantity }}</td>
                <td class="py-2 flex space-x-2">
                  <button class="text-blue-500 hover:text-blue-700">
                    <PencilIcon class="w-5 h-5" />
                  </button>
                  <button class="text-green-500 hover:text-green-700">
                    <EyeIcon class="w-5 h-5" />
                  </button>
                  <button class="text-red-500 hover:text-red-700">
                    <TrashIcon class="w-5 h-5" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>


      </div>
    </PanelLayout>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { PlusIcon, PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/24/solid';
  import Pagination from '@/Components/Helper/Pagination.vue';

  
  const search = ref('');
  const products = ref([]);
  
  watch(search, (newSearch) => {
    Inertia.post('/products/search', { search: newSearch });
  });
  </script>