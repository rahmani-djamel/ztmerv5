<template>
    <!-- Category Cards -->
    <Link :href="`/categories/${category.slug}`" class="block">
      <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
        <div class="relative">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div>
                <img :src="category.image" alt="Category Image" class="w-full h-48 object-cover">
              </div>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
          </div>
          <div class="p-4">
            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-300">
              {{ category.name }}
            </h3>
            <p class="text-gray-600 dark:text-gray-400">
              عدد المنتجات <span class="font-bold">{{ category.products_count }}</span>
            </p>
          </div>
        </div>
      </div>
    </Link>
  </template>
  
  <script setup>  
  defineProps({
    category: Object,
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