<template>
    <Head title="عناوين الشحن" />
    <PanelLayout>
      <Header>
        عناوين الشحن
      </Header>
  
      <div class="p-4 mt-2 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
          <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2 mb-2">
            <Link v-if="can.createAddress" :href="route('addresses.create')" class="w-full mx-2 md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
              <PlusIcon class="w-5 h-5 mr-2" />
              إضافة عنوان شحن
            </Link>
            <button @click="toggleView" class="w-full md:w-auto flex items-center text-center px-4 py-2 bg-green-700 text-white rounded-md hover:bg-gray-300 dark:bg-green-600 dark:hover:bg-green-700">
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
            <label for="name" class="absolute -top-2 right-2 inline-block bg-white dark:bg-gray-800 px-1 text-xs font-medium text-gray-900 dark:text-gray-100">
              بحث
            </label>
            <input
              type="text"
              name="search"
              v-model="search"
              id="name"
              class="block w-full rounded-md border-0 py-1.5 text-gray-900 dark:text-gray-100 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-400 sm:text-sm sm:leading-6 dark:bg-gray-700"
              placeholder="إبحث عن عنوان شحن"
            />
          </div>
        </div>
        <div class="overflow-x-auto" v-show="!isMapView">
          <table class="min-w-full bg-white dark:bg-gray-800">
            <thead>
              <tr>
                <th class="py-2 text-right text-gray-900 dark:text-gray-100">
                    اسم المستلم
                </th>
                <th class="py-2 text-right text-gray-900 dark:text-gray-100">رقم الهاتف</th>
                <th class="py-2 text-right text-gray-900 dark:text-gray-100">
                    المدينة
                </th>
                <th class="py-2 text-right text-gray-900 dark:text-gray-100">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="addresses.data.length === 0">
                <td class="py-2 text-center text-gray-500 dark:text-gray-400" colspan="3">لا يوجد عناوين</td>
              </tr>
              <tr v-for="market in addresses.data" :key="market.id" class="border-t border-gray-200 dark:border-gray-700">
                <td class="py-2 flex items-start text-gray-900 dark:text-gray-100">
                  <span class="mt-1">{{ market.user_name }}</span>
                </td>
                <td class="py-2 text-gray-900 dark:text-gray-100">{{ market.phone }}</td>
                <td class="py-2 text-gray-900 dark:text-gray-100">{{ market.city }}</td>

                <td class="py-2 flex space-x-2">
                  <button type="button" @click="showData(market.id)"  class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                    <EyeIcon class="w-5 h-5" />
                  </button>
                  <button v-if="can.createAddress" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600" @click="confirmDelete(market.id)">
                    <TrashIcon class="w-5 h-5" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
          <Pagination :links="addresses.links" />

        </div>
        <div v-show="isMapView">
          <GoogleMap
            api-key="AIzaSyAMFf3ukIr6AdAf3eJLTkvzcuxFoKG4Fac"
            style="width: 100%; height: 500px"
            :center="center"
            :zoom="7"
          >
            <Marker v-for="n in addresses.data" :key="n.id" :options="{ position: { lat: parseFloat(n.lat), lng: parseFloat(n.lng) } }">
              <InfoWindow>
                <div id="content">
                  <div id="siteNotice"></div>
                  <h1 id="firstHeading" class="text-lg font-bold">
                    {{ n.user_name }}
                  </h1>
                  <a :href="'tel:' + n.phone" class="text-sky-500 hover:text-sky-600">
                    {{ n.phone }}
                  </a>
                  <div id="bodyContent"></div>
                </div>
              </InfoWindow>
            </Marker>
          </GoogleMap>
        </div>

      </div>
    </PanelLayout>
  </template>
    
    <script setup>
    import { ref, watch,onMounted } from 'vue';
    import PanelLayout from '@/Layouts/PanelLayout.vue';
    import { Head,router, usePage } from '@inertiajs/vue3';
    import { PlusIcon, PencilIcon, TrashIcon,MapIcon, TableCellsIcon,EyeIcon } from '@heroicons/vue/24/solid';
    import Pagination from '@/Components/Helper/Pagination.vue';
    import { GoogleMap, Marker, InfoWindow } from 'vue3-google-map'
    import Swal from 'sweetalert2';
    
  
  
  const isMapView = ref(false);
  const center = { lat: 24.7136, lng: 46.6753 };
  const showInfoWindow = ref(false);
  
  const toggleView = () => {
    isMapView.value = !isMapView.value;
  };
  
  const toggleInfoWindow = () => {
    showInfoWindow.value = !showInfoWindow.value;
  };

  const showData = (addressId) => {
    //get information of the address from addresses and show it in swal 
    const address = page.props.addresses.data.find((address) => address.id === addressId);
    Swal.fire({
      title: 'بيانات العنوان',
      html: `
      <div class="text-right">
        <p><strong>اسم المستلم:</strong> ${address.user_name}</p>
        <p><strong>رقم الهاتف:</strong> ${address.phone}</p>
        <p><strong>المدينة:</strong> ${address.city}</p>
        <p><strong>الحي:</strong> ${address.address}</p>
        <p><strong>الإحداثيات:</strong> ${address.lat}, ${address.lng}</p>
      </div>
      `,
      showCloseButton: true,
      showConfirmButton: false,
    });
  };
  
  
    
 
  
    defineProps({
      can: Object,
      addresses: {
        type: Object,
        required: true,
      },
      filters: {
        type: Object,
        required: false,
      },
    });


  
    const page = usePage();
    const search = ref(page.props.filters.search);

    onMounted(() => {
    console.log(page.props.addresses.links);
    
  });
  
    const confirmDelete = (marketId) => {
          Swal.fire({
              title: 'هل أنت متأكد؟',
              text: 'لن تتمكن من التراجع عن هذا!',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'نعم، احذفها!',
              cancelButtonText: 'إلغاء'
          }).then((result) => {
              if (result.isConfirmed) {
  
                  router.delete(route('addresses.destroy', marketId));
  
                  Swal.fire(
                      'تم الحذف!',
                      'تم حذف العنوان شحن بنجاح.',
                      'success'
                  );
              }
          });
      }
  
  
    watch(search, function (value) {    
    router.visit('/addresses', {
      method: 'get',
      replace: true,
      preserveState: true,
      data: {
        search: value,
      },
    });
  }, 300);
    </script>