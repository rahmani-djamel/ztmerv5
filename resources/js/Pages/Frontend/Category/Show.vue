<template>
    <Head title="المنتجات" />
    <FrontLayout>
      <div class="container mx-auto max-w-7xl px-4 py-8">
  
        <!--filter and search-->
        <div class="container mx-auto max-w-7xl px-4 py-8 bg-white rounded shadow-lg mb-4 dark:bg-gray-800">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
              <div class="flex flex-col">
                <label for="" class="mb-2">
                    البحث
                </label>
                <input type="text" v-model="search" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:ring-opacity-50" placeholder="إسم المنتج">
              </div>
              <div class="flex flex-col">
                  <label for="" class="mb-2">
                      ترتيب حسب
                  </label>
                  <select v-model="order_by" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:ring-opacity-50">
                    <option value="">
                        الافتراضي
                    </option>  
                    <option value="low_to_high">
                          اقل سعر
                      </option>
                      <option value="high_to_low">
                          أكبر سعر
                      </option>
                  </select>
              </div>
            </div>
        </div>
  
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
          <ProductCard v-for="product in products.data" :key="product.id" :product="product" />
        </div>
      
        <Pagination :links="products.links" />
      </div>
  
    </FrontLayout>
  </template>
    
    <script setup>
    import { ref, watch,onMounted } from 'vue';
    import FrontLayout from '@/Layouts/FrontLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';
    import Pagination from '@/Components/Helper/Pagination.vue';
    import ProductCard from '@/Components/Frontend/ProductCard.vue';
    import Swiper from 'swiper/bundle';
    import 'swiper/swiper-bundle.css';
    
    let props = defineProps({
    products: Object,
    category:Object,
    filters: Object,
  });
    
  let search = ref(props.filters.search);
  let order_by = ref(props.filters.order_by);
  
  
  onMounted(() => {    
      new Swiper('.swiper-container', {
        loop: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
      });
    });
  
    watch([search,order_by], function (value) {    
    router.visit('/categories/'+props.category.slug, {
      method: 'get',
      replace: true,
      preserveState: true,
      data: {
        search: search.value,
        order_by: order_by.value,
      },
    });
  }, 300);
    </script>