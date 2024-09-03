<template>
  <Head title="المنتجات" />
  <PanelLayout>
    <Header>
      المنتجات
    </Header>

    <div class="p-4 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-md">
      <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <Link v-if="can.createProduct" :href="route('product.create')" class="w-full md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
          <PlusIcon class="w-5 h-5 mr-2" />
          إضافة منتج
        </Link>
        <div class="relative w-full md:w-auto">
          <label for="name" class="absolute -top-2 right-2 inline-block bg-white dark:bg-gray-800 px-1 text-xs font-medium text-gray-900 dark:text-gray-100">
            بحث
          </label>
          <input
            type="text"
            name="search"
            v-model="search"
            id="name"
            class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-400 sm:text-sm sm:leading-6 dark:bg-gray-700"
            placeholder="إبحث عن منتج"
          />
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
          <thead>
            <tr>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">المنتج</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">السعر</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">الكمية</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id" class="border-t border-gray-200 dark:border-gray-700">
              <td class="py-2 flex items-start text-gray-900 dark:text-gray-100">
                <img :src="product.avatar" alt="الصورة" class="hidden sm:block w-10 h-10 rounded-full mr-2" />
                <span class="mt-1">{{ product.name }}</span>
              </td>
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ product.price }}</td>
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ product.quantity }}</td>
              <td class="py-2 flex space-x-2">
                <button class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                  <PencilIcon class="w-5 h-5" />
                </button>
                <button class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-600">
                  <EyeIcon class="w-5 h-5" />
                </button>
                <button class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600">
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

  defineProps({
    products: {
      type: Array,
      required: false,
    },
    can: Object

  });
  
  watch(search, (newSearch) => {
    Inertia.post('/products/search', { search: newSearch });
  });
  </script>