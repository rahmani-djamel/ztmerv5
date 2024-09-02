<template>
    <Head title="إضافة صنف" />
    <PanelLayout>
      <div class="container mx-auto p-4">
        <div class="p-4 rounded">
          <Header>إضافة صنف</Header>
          <form @submit.prevent="saveCategory" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Form Section -->
            <div class="md:col-span-3 bg-white p-2">
              <div class="mb-4">
                <label for="productName" class="block text-gray-700">اسم</label>
                <input type="text" id="productName" v-model="form.name" class="w-full p-2 border border-gray-300 rounded" />
                <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 text-xs mt-1"></div>
              </div>
  
              <div class="mb-4">
                <label for="avatar" class="block text-gray-700">الصورة</label>
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
                <div v-if="form.errors.image" v-text="form.errors.image" class="text-red-500 text-xs mt-1"></div>
  
                <div v-if="form.image_preview" class="mt-4 flex items-center justify-center">
                  <button @click="removeImage" class="text-red-500 mr-2">
                    <TrashIcon class="w-6 h-6" />
                  </button>
                  <img :src="form.image_preview" alt="Uploaded Image" class="w-32 h-32 object-cover" />
                </div>
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
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { ref } from 'vue';
  import { Head, useForm, router } from '@inertiajs/vue3';
  import { TrashIcon } from '@heroicons/vue/24/solid';
  import Swal from 'sweetalert2';
  
  const form = useForm({
    name: '',
    image: null,
    image_preview: ''
  });
  
  const fileInput = ref(null);
  
  const triggerFileInput = () => {
    fileInput.value.click();
  };
  
  const handleFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
      form.image = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        form.image_preview = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  const handleDrop = (event) => {
    const file = event.dataTransfer.files[0];
    if (file) {
      form.image = file;
      const reader = new FileReader();
      reader.onload = (e) => {
        form.image_preview = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  };
  
  const removeImage = () => {
    form.image = null;
    form.image_preview = '';
    fileInput.value.value = '';
  };
  
  const saveCategory = () => {
  // Add your save logic here
  form.post('/category/create', {
    onSuccess: () => {
      Swal.fire('نجاح', 'تم إنشاء الصنف بنجاح', 'success');
    },
    onError: () => {
      Swal.fire('خطأ', 'حدث خطأ أثناء إنشاء الصنف', 'error');
    }
  });
};
  </script>