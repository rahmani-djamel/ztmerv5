<template>
        <!-- Product Cards -->
          <div  class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="relative">
              <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div v-for="media in product.media" :key="media.id" class="swiper-slide">
                    <template v-if="media.type === 'image'">
                        <img :src="media.path" alt="Product Image" class="w-full h-48 object-cover">
                    </template>
                    <template v-else-if="media.type === 'video'">
                        <video controls class="w-full h-48 object-cover">
                        <source :src="media.path" type="video/mp4">
                        Your browser does not support the video tag.
                        </video>
                    </template>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
              </div>
            </div>
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-800 dark:text-gray-300">
                {{ product.name }}
              </h3>
              <p class="text-gray-600 dark:text-gray-400"> 
                {{ product.vendor }}
              </p>
              <p class="text-gray-600 dark:text-gray-400">
                {{ product.category }}
              </p>
              <p class="text-gray-600 dark:text-gray-400">
                {{  product.city }}
              </p>
              <div class="flex justify-between items-center mt-4">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-300">
                    {{ product.price }} ر.س
                </span>
                <button class="border border-blue-500 text-blue-500 px-4 py-2 rounded hover:bg-blue-500 hover:text-white flex items-center">
                  <ShoppingCartIcon class="h-5 w-5" />
                </button>
              </div>
            </div>
          </div>
  </template>
  
  <script setup>
  import { ShoppingCartIcon } from '@heroicons/vue/24/solid';

defineProps({
    product: Object,
    });

  </script>
<style scoped>
.swiper-container {
  width: 100%;
  height: 100%;
}

.swiper-slide {
  text-align: center;
  font-size: 18px;
  background: #fff;

  /* Center slide text vertically */
  display: -webkit-box;
  display: -ms-flexbox;
  display: -webkit-flex;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  -webkit-justify-content: center;
  justify-content: center;
  -webkit-box-align: center;
  -ms-flex-align: center;
  -webkit-align-items: center;
  align-items: center;
}
</style>