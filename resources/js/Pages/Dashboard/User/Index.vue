<template>
    <Head title="المدن" />
    <PanelLayout>
        <Header >
          المستخدمين
        </Header>

      <div class="p-4 bg-white rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                <Link :href="route('user.create')" class="w-full md:w-auto flex items-center text-center mb-2 md:mb-0 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    <PlusIcon class="w-5 h-5 mr-2" />
                    إضافة مستخدم
                </Link>
                <div class="relative w-full md:w-auto flex items-center">
                    <div class="relative w-full md:w-auto mr-2">
                        <label for="name" class="absolute -top-2 right-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">
                            بحث
                        </label>
                        <input
                            type="text"
                            name="search"
                            v-model="search"
                            id="name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            placeholder="إبحث عن مستخدم"
                        />
                    </div>
                    <div class="relative w-full md:w-auto mx-2">
                        <label for="role" class="absolute -top-2 right-2 inline-block bg-white px-1 text-xs font-medium text-gray-900">
                            دور
                        </label>
                        <select
                            name="role"
                            v-model="role"
                            id="role"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        >
                            <option value="">الكل</option>
                            <option value="SuperAdmin">أدمين</option>
                            <option value="Vendor">بائع</option>
                            <option value="User">مشتري</option>
                        </select>
                    </div>
                </div>
            </div>
        <div class="overflow-x-auto">
          <table class="min-w-full bg-white">
            <thead>
              <tr>
                <th class="py-2 text-right">ID</th>
                <th class="py-2 text-right">الاسم</th>
                <th class="py-2 text-right">البريد الإلكتروني</th>
                <th class="py-2 text-right">الدور</th>
                <th class="py-2 text-right">الإجراءات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-if="users.data.length === 0">
                <td colspan="5" class="py-4 text-center text-gray-500">
                  لا توجد مستخدمين للعرض    
                  </td>
              </tr>
              <tr v-for="user in users.data" :key="user.id" class="border-t">
                <td class="py-2">{{ user.id }}</td>

                <td class="py-2">{{ user.name }}</td>
                <td class="py-2">{{ user.email }}</td>
                <td class="py-2">
                    <span
                        :class="{
                        'bg-blue-500 text-white px-2 py-1 rounded': user.role === 'أدمين',
                        'bg-green-500 text-white px-2 py-1 rounded': user.role === 'مشتري',
                        'bg-gray-500 text-white px-2 py-1 rounded': user.role === 'بائع'
                        }"
                    >
                        {{ user.role }}
                    </span>
                </td>
                <td class="py-2 flex space-x-2">
                  <button v-if="Authuser.id != user.id && !user.is_admin " class="text-red-500 hover:text-red-700" @click="confirmDelete(user.id)">
                    <TrashIcon class="w-5 h-5" />
                </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <Pagination :links="users.links" />

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
import { usePage } from '@inertiajs/vue3';
  
  let props = defineProps({
  users: Object,
  filters: Object,
});
let page = usePage();
let search = ref(props.filters.search);
let role = ref(props.filters.role);
let Authuser = ref(page.props.auth.user);


const confirmDelete = (userId) => {
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

                router.delete(route('user.destroy', userId));

                Swal.fire(
                    'تم الحذف!',
                    'تم حذف المستخدم بنجاح.',
                    'success'
                );
            }
        });
    }

watch(search, function (value) {
    console.log(value);
    
  router.visit('/user', {
    method: 'get',
    replace: true,
    preserveState: true,
    data: {
      search: value,
      role: role.value,
    },
  });
}, 300);

watch(role, function (value) {
    router.visit('/user', {
        method: 'get',
        replace: true,
        preserveState: true,
        data: {
        search: search.value,
        role: value,
        },
    });
}, 300);
  </script>