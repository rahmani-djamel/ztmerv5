<template>
    <Head title="المتاجر" />
    <PanelLayout>
      <Header >
           المتاجر 
        </Header>

      <div class="p-4 mt-2 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <div class="flex flex-col md:flex-row space-y-2  md:space-y-0 md:space-x-2 mb-2">
                  <Link v-if="can.createMarket" :href="route('market.create')" class="w-full mx-2 md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <PlusIcon class="w-5 h-5 mr-2" />
                    إضافة متجر
                  </Link>
                  <button @click="toggleView" class="w-full md:w-auto flex items-center text-center px-4 py-2 bg-green-700 text-white rounded-md hover:bg-gray-300">
                    <template v-if="isMapView">
                      <TableCellsIcon class="w-5 h-5 mx-2" />
                      عرض كجدول
                    </template>
                    <template v-else>
                      <MapIcon class="w-5 h-5 mx-2" />
                      عرض كخريطة
                    </template>
                  </button>
                </div>

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
        <div class="overflow-x-auto" v-show="!isMapView">
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th class="py-2 text-right">اسم المحل</th>
                <th class="py-2 text-right">
                  رقم الهاتف
                </th>
                <th class="py-2 text-right">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="market in markets.data" :key="market.id" class="border-t">
                <td class="py-2 flex items-start">
                    <span class="mt-1">{{ market.market_name }}</span>
                </td>
                <td class="py-2">{{ market.phone }}</td>
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
        <div v-show="isMapView">
          <GoogleMap
              api-key="AIzaSyAMFf3ukIr6AdAf3eJLTkvzcuxFoKG4Fac"
              style="width: 100%; height: 500px"
              :center="center"
              :zoom="7"
            >

            <Marker :options="{ position: center }">
              <InfoWindow>
                <div id="content">
                  <div id="siteNotice"></div>
                  <h1 id="firstHeading" class="firstHeading">
                    موقع المتجر
                  </h1>
                  <div id="bodyContent">
                    
                  </div>
                </div>
              </InfoWindow>
            </Marker>
            </GoogleMap>
        </div>


      </div>
    </PanelLayout>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { PlusIcon, PencilIcon, EyeIcon, TrashIcon,MapIcon, TableCellsIcon } from '@heroicons/vue/24/solid';
  import Pagination from '@/Components/Helper/Pagination.vue';
  import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map'

const isMapView = ref(false);
const center = { lat: 24.7136, lng: 46.6753 };
const showInfoWindow = ref(false);

const toggleView = () => {
  isMapView.value = !isMapView.value;
};

const toggleInfoWindow = () => {
  showInfoWindow.value = !showInfoWindow.value;
};


  
  const search = ref('');
  const products = ref([]);


  defineProps({
    can: Object,
    markets: {
      type: Object,
      required: true,
    },
  });
  
  watch(search, (newSearch) => {
    Inertia.post('/products/search', { search: newSearch });
  });
  </script>