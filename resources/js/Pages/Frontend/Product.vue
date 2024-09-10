<template>
    <FrontLayout>
      <div class="container mx-auto max-w-7xl px-4 py-8">

        <!--filter and search-->
        <div class="container mx-auto max-w-7xl px-4 py-8 bg-white rounded shadow-md mb-4 dark:bg-gray-800">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <input type="text" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="إسم المنتج">
                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Select Option 1</option>
                    <!-- Add more options as needed -->
                </select>
                <select class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">Select Option 2</option>
                    <!-- Add more options as needed -->
                </select>
                <button class="rounded-md shadow-sm bg-blue-500 text-white px-4 py-2">
                    بحث
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          
        <ProductCard v-for="product in products.data" :key="product" :product="product"  />
        </div>

  

      </div>
    </FrontLayout>
  </template>
  
  <script setup>
  import FrontLayout from '@/Layouts/FrontLayout.vue';
  import { onMounted } from 'vue';
  import Swiper from 'swiper/bundle';
  import 'swiper/swiper-bundle.css';
  import { ShoppingCartIcon } from '@heroicons/vue/24/solid';
  import ProductCard from '@/Components/Frontend/ProductCard.vue';
  import { usePage } from '@inertiajs/vue3';
  import { ref } from 'vue';

  const page = usePage();

  const products = ref(page.props.products);

  
  onMounted(() => {
    console.log(products.value);
    
    new Swiper('.swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  });
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>