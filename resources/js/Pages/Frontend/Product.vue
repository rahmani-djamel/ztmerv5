<template>
    <FrontLayout>
      <div class="container mx-auto max-w-7xl px-4 py-8">

  
        <!-- Product Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="i in 16" :key="i" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="relative">
              <div class="swiper-container">
                <div class="swiper-wrapper">
                  <div class="swiper-slide">
                    <img src="https://picsum.photos/200/300?random={{i}}" alt="Product Image" class="w-full h-48 object-cover">
                  </div>
                  <div class="swiper-slide">
                    <img src="https://picsum.photos/200/300?random={{i+1}}" alt="Product Image" class="w-full h-48 object-cover">
                  </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-800 dark:text-gray-300">اسم المنتج {{ i }}</h3>
              <p class="text-gray-600 dark:text-gray-400">اسم البائع</p>
              <p class="text-gray-600 dark:text-gray-400">الفئة</p>
              <p class="text-gray-600 dark:text-gray-400">المدينة</p>
              <div class="flex justify-between items-center mt-4">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-300">$100</span>
                <button class="border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white flex items-center">
                  <ShoppingCartIcon class="h-5 w-5" />
                </button>
              </div>
            </div>
          </div>
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
  
  onMounted(() => {
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