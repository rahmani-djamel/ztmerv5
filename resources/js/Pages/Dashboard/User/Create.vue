<template>
    <Head title="إضافة مستخدم" />
    <PanelLayout>
      <div class="container mx-auto p-4">
  
        <div class=" p-4 rounded ">
  
          <Header >
            إضافة مستخدم
          </Header>
  
  
          <form @submit.prevent="saveUser" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Form Section -->
            <div class="md:col-span-3 bg-white p-2">
              <div class="mb-4">
                <label for="productName" class="block text-gray-700">
                    اسم المستخدم
                </label>
                <input type="text" id="productName" v-model="form.name" class="w-full p-2 border border-gray-300 rounded" />
                <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>

              </div>

                <div class="mb-4">
                    <label for="productDescription" class="block text-gray-700">
                        البريد الإلكتروني
                    </label>
                    <input type="email" id="productDescription" v-model="form.email" class="w-full p-2 border border-gray-300 rounded" />
                    <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>

                </div>

                <div class="mb-4">
                    <label for="productDescription" class="block text-gray-700">
                         الدور
                    </label>
                    <select id="role" v-model="form.role" class="w-full p-2 border border-gray-300 rounded">
                        <option value="">اختر الدور</option>
                        <option value="SuperAdmin">أدمين</option>
                        <option value="Vendor">بائع</option>
                        <option value="User">مشتري</option>
                    </select>
                    <div v-if="form.errors.role" v-text="form.errors.role" class="text-red-500 text-xs mt-1"></div>

                </div>

                <div class="mb-4">
                    <label for="productDescription" class="block text-gray-700">
                        كلمة المرور
                    </label>
                    <input type="password" id="productDescription" v-model="form.password" class="w-full p-2 border border-gray-300 rounded" />
                    <div v-if="form.errors.password" v-text="form.errors.password" class="text-red-500 text-xs mt-1"></div>
                </div>



            </div>
            <!-- Submit Button -->
            <div class="md:col-span-3">
              <button type="submit" class="mt-3 w-full text-white bg-sky-500 text-center p-1 rounded shadow-md md:mt-0 md:mb-3">
                إضافة 
              </button>
            </div>
          </form>
        </div>
      </div>
    </PanelLayout>
  </template>
  <script setup>
  import PanelLayout from '@/Layouts/PanelLayout.vue'
  import {ref} from 'vue';
    import { Head,useForm,router} from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';
    import Swal from 'sweetalert2';


    const form = useForm({
    name: '',
    email: '',
    password: '',
    role: '',

  });

   
  const saveUser = () => {
    // Add your save logic here
    router.post('/user/create', form, {
      onSuccess: () => {
        form.reset();
      }
    });

    form.post('/user/create')
    
  };
  </script>