<template>
    <div>
      <h2 class="text-xl font-bold mb-4 flex items-center">
        <UserIcon class="w-6 h-6 mr-2 text-sky-500" />
        المعلومات الشخصية
      </h2>    
      <div v-if="form.avatarPreview" class="mt-4">
        <img :src="form.avatarPreview" alt="Avatar Preview" class="w-32 h-32 object-cover rounded-full mx-auto" />
      </div>
  
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="name" class="block text-gray-700">الاسم</label>
          <input
            v-model="form.name"
            type="text"
            id="name"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            required
          />
          <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
        </div>
        <div class="mb-4">
          <label for="email" class="block text-gray-700">البريد الإلكتروني</label>
          <input
            v-model="form.email"
            type="email"
            id="email"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
            required
          />
          <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mt-1"></div>
        </div>
        <div class="mb-4">
          <label for="phone" class="block text-gray-700">رقم الهاتف</label>
          <input
            v-model="form.phone"
            type="tel"
            id="phone"
            placeholder="05xxxxxxxx"
            class="mt-1 block w-full text-start border-gray-300 rounded-md shadow-sm"
          />
          <div v-if="form.errors.phone" v-text="form.errors.phone" class="text-red-500 text-xs mt-1"></div>
        </div>
  
        <div class="mb-4">
          <label for="phone" class="block text-gray-700">
            تاريخ الميلاد
          </label>
          <input
            v-model="form.date_of_birth"
            type="date"
            id="date-of-birth"
            class="mt-1 block w-full  border-gray-300 rounded-md shadow-sm"
          />
          <div v-if="form.errors.birthday" v-text="form.errors.birthday" class="text-red-500 text-xs mt-1"></div>
        </div>
        <div class="mb-4">
          <label for="avatar" class="block text-gray-700">الصورة الشخصية</label>
          <div
            class="border-2 border-dashed border-gray-300 p-4 text-center cursor-pointer"
            @click="triggerFileInput"
            @dragover.prevent
            @drop.prevent="handleDrop"
          >
            انقر هنا أو اسحب الصورة إلى هنا
            <input
              type="file"
              accept="image/*"
              class="hidden"
              ref="fileInput"
              @change="handleFileChange"
            />
          </div>
          <div v-if="form.errors.avatar" v-text="form.errors.avatar" class="text-red-500 text-xs mt-1"></div>
        </div>
        <button
          type="submit"
          class="bg-sky-500 text-white px-4 py-2 rounded-md hover:bg-sky-600"
        >
          حفظ
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { useForm, usePage } from '@inertiajs/vue3';
  import Swal from 'sweetalert2';
  import { UserIcon } from '@heroicons/vue/24/solid';
  
  
  // Define the form
  const page = usePage();
  const form = useForm({
    name: page.props.auth.user.name,
    email: page.props.auth.user.email,
    phone: transformPhone(page.props.auth.user.phone),
    avatar: null,
    avatarPreview: page.props.auth.avatar,
    date_of_birth: page.props.auth.user.date_of_birth,
  });
  
  // Reference to the file input element
  const fileInput = ref(null);
  
  // Trigger the file input click
  const triggerFileInput = () => {
    fileInput.value.click();
  };
  
  // Function to transform the phone number
  function transformPhone(phone) {
    if (phone && phone.startsWith('9665')) {
      return '0' + phone.slice(3);
    }
    return phone;
  }
  
  // Handle file input change
  const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
      form.avatar = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        form.avatarPreview = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  // Handle file drop
  const handleDrop = (event) => {
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      form.avatar = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        form.avatarPreview = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  // Handle form submission
  const submitForm = () => {
    form.post('/setting/update/personal-information', {
      preserveScroll: true,
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: 'تم تحديث المعلومات الشخصية بنجاح',
        });
      },
    });
  };
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>