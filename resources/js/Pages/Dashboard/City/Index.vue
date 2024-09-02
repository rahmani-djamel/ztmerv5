<template>
    <Head title="المدن" />
    <PanelLayout>
        <Header >
          المدن
        </Header>

      <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <Link :href="route('city.create')" class="w-full md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <PlusIcon class="w-5 h-5 mr-2" />
                    إضافة مدينة
                </Link>
                <div class="relative w-full md:w-auto">
                    <label for="name"  class="absolute -top-2 right-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">
                    بحث
                    </label>
                    <input
                    type="text"
                    name="search"
                    v-model="search"
                    id="name"
                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                    placeholder="إبحث عن مدينة"
                    />
                </div>
            </div>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th class="py-2 text-right">ID</th>
                <th class="py-2 text-right">الاسم</th>
                <th class="py-2 text-right">المحافظة</th>
                <th class="py-2 text-right">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="city in cities.data" :key="city.id" class="border-t">
                <td class="py-2">{{ city.id }}</td>

                <td class="py-2">{{ city.name }}</td>
                <td class="py-2">{{ city.state }}</td>
                <td class="py-2 flex space-x-2">
                  <Link type="button" :href="route('city.edit',city.id)" class="text-blue-500 hover:text-blue-700">
                    <PencilIcon class="w-5 h-5" />
                  </Link>
                  <button class="text-red-500 hover:text-red-700" @click="confirmDelete(city.id)">
                    <TrashIcon class="w-5 h-5" />
                </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Pagination :links="cities.links" />

    </PanelLayout>
  </template>
  
  <script setup>
  import { ref, watch } from 'vue';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { Head } from '@inertiajs/vue3';
  import { router } from '@inertiajs/vue3';
  import { PlusIcon, PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/24/solid';
  import Pagination from '@/Components/Helper/Pagination.vue';
    import Swal from 'sweetalert2';
  
  let props = defineProps({
  cities: Object,
  filters: Object,
});
  
let search = ref(props.filters.search);

const confirmDelete = (cityId) => {
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

                router.delete(route('city.destroy', cityId));

                Swal.fire(
                    'تم الحذف!',
                    'تم حذف المدينة بنجاح.',
                    'success'
                );
            }
        });
    }

watch(search, function (value) {
    console.log(value);
    
  router.visit('/city', {
    method: 'get',
    replace: true,
    preserveState: true,
    data: {
      search: value,
    },
  });
}, 300);
  </script>