<template>
  <Head title="وحدات الوزن" />
  <PanelLayout>
    <Header>
      وحدات الوزن
    </Header>

    <div class="p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
      <div class="flex flex-col md:flex-row justify-between items-center mb-4">
        <Link :href="route('unit.create')" class="w-full md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">
          <PlusIcon class="w-5 h-5 mr-2" />
          إضافة وحدة جديدة
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
            placeholder="إبحث عن وحدة"
          />
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white dark:bg-gray-800">
          <thead>
            <tr>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">ID</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">الاسم</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">الرمز</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">القيمة بالكيلوغرام</th>
              <th class="py-2 text-right text-gray-900 dark:text-gray-100">الإجراءات</th>
            </tr>
          </thead>
          <tbody>
            <tr v-if="units.data.length === 0">
              <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
                لا توجد مدن لعرضها
              </td>
            </tr>
            <tr v-for="unit in units.data" :key="unit.id" class="border-t border-gray-200 dark:border-gray-700">
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ unit.id }}</td>
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ unit.name }}</td>
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ unit.symbole }}</td>
              <td class="py-2 text-gray-900 dark:text-gray-100">{{ unit.value }}</td>
              <td class="py-2 flex space-x-2">
                <Link type="button" :href="route('unit.edit', unit.id)" class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-600">
                  <PencilIcon class="w-5 h-5" />
                </Link>
                <button class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600" @click="confirmDelete(unit.id)">
                  <TrashIcon class="w-5 h-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <Pagination :links="units.links" />
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
    units: Object,
    filters: Object,
});
  
let search = ref(props.filters.search);

const confirmDelete = (unitId) => {
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

                router.delete(route('unit.destroy', unitId));

                Swal.fire(
                    'تم الحذف!',
                    'تم حذف الوحدة بنجاح.',
                    'success'
                );
            }
        });
    }

watch(search, function (value) {
    console.log(value);
    
  router.visit('/unit', {
    method: 'get',
    replace: true,
    preserveState: true,
    data: {
      search: value,
    },
  });
}, 300);
  </script>