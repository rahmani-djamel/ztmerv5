<template>
    <Head title="الأصناف" />
    <FrontLayout>
      <div class="container mx-auto max-w-7xl px-4 py-8">
  
        <!--filter and search-->
        <div class="container mx-auto max-w-7xl px-4 py-8 bg-white rounded shadow-lg mb-4 dark:bg-gray-800">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <div class="flex flex-col">
              <label for="" class="mb-2">
                  البحث
              </label>
              <input type="text" v-model="search" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:ring-opacity-50" placeholder="إسم الصنف">
            </div>
          </div>

        </div>
  
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <CategoryCard v-for="category in categories.data" :key="category.id" :category="category" />
        </div>
        <Pagination :links="categories.links" />

      
      </div>
  
    </FrontLayout>
  </template>
  <script setup>
    import { ref, watch,onMounted } from 'vue';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import { Head,router } from '@inertiajs/vue3';
    import Swiper from 'swiper/bundle';
    import 'swiper/swiper-bundle.css';
    import CategoryCard from '@/Components/Frontend/Categorycard.vue';
    import Pagination from '@/Components/Helper/Pagination.vue';

let props =  defineProps({
  categories: Object,
  filters: Object,
});


let search = ref(props.filters.search);


onMounted(() => {    
    new Swiper('.swiper-container', {
      loop: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  });

  watch([search], function (value) {    
  router.visit('/categories', {
    method: 'get',
    replace: true,
    preserveState: true,
    data: {
      search: search.value,
    },
  });
}, 300);
    </script>