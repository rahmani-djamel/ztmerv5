<template>
  <Head title="إضافة منتج" />
  <PanelLayout>
    <div class="container mx-auto p-4">

      <div class=" p-4 rounded ">

        <Header >
          إضافة منتج
        </Header>


        <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Form Section -->
          <div class="md:col-span-2 bg-white p-2">
            <div class="mb-4">
              <label for="productName" class="block text-gray-700">اسم المنتج</label>
              <input type="text" id="productName" v-model="productName" class="w-full p-2 border border-gray-300 rounded" />
            </div>
            <div class="mb-4">
              <label for="description" class="block text-gray-700">الوصف</label>
              <textarea id="description" v-model="description" class="w-full p-2 border border-gray-300 rounded"></textarea>
            </div>
            <div class="mb-4">
              <label for="city" class="block text-gray-700">المدينة</label>
              <input type="text" id="city" v-model="city" class="w-full p-2 border border-gray-300 rounded" />
            </div>
            <div class="mb-4">
              <label for="qte" class="block text-gray-700">الكمية</label>
              <input type="number" id="qte" v-model="qte" class="w-full p-2 border border-gray-300 rounded" />
            </div>
            <div class="mb-4">
              <label for="price" class="block text-gray-700">السعر</label>
              <input type="number" id="price" v-model="price" class="w-full p-2 border border-gray-300 rounded" />
            </div>
          </div>
          <!-- File Upload Section -->
          <div class="md:col-span-1 p-2 bg-white">
            <div
              class="border-2 border-dashed border-gray-300 p-4 rounded cursor-pointer"
              @dragover.prevent
              @drop.prevent="handleDrop"
              @click="handleClick"
            >
              <div class="mb-4">
                <label for="avatar" class="block text-gray-700">الصور</label>
                <input type="file" id="avatar" ref="fileInput" @change="uploadImages" class="hidden" accept="image/*" multiple />
              </div>
              <p class="text-center text-gray-500">اسحب وأفلت الصور هنا أو انقر للتحميل</p>
            </div>
            <div v-if="images.length" class="mt-4 grid grid-cols-3 gap-2">
              <div v-for="(img, index) in images" :key="index" class="relative mb-2">
                <img :src="img" alt="الصورة" class="w-full h-24 object-cover rounded" />
                <button @click="removeImage(index)" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full">
                  <TrashIcon class="h-5 w-5" />
                </button>
              </div>
            </div>
          </div>
          <!-- Submit Button -->
          <div class="md:col-span-3">
            <button type="submit" class="mt-3 w-full text-white bg-sky-500 text-center p-1 rounded shadow-md md:mt-0 md:mb-3">
              إضافة المنتج
            </button>
          </div>
        </form>
      </div>
    </div>
  </PanelLayout>
</template>

<script setup>
import { ref } from 'vue';
import Swal from 'sweetalert2';
import PanelLayout from '@/Layouts/PanelLayout.vue';
import { Head } from '@inertiajs/vue3';

import { TrashIcon } from '@heroicons/vue/24/solid';

const productName = ref('');
const description = ref('');
const city = ref('');
const qte = ref('');
const price = ref('');
const images = ref([]);

const submitForm = () => {
  // Handle form submission
};

const handleDrop = (event) => {
  const files = event.dataTransfer.files;
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    if (file && file.type.startsWith('image/')) {
      images.value.push(URL.createObjectURL(file));
    }
  }
};

const handleClick = () => {
  const fileInput = fileInputRef.value;
  fileInput.click();
};

const uploadImages = (event) => {
  const files = event.target.files;
  for (let i = 0; i < files.length; i++) {
    const file = files[i];
    if (file && file.type.startsWith('image/')) {
      images.value.push(URL.createObjectURL(file));
    }
  }
};

const removeImage = (index) => {
  Swal.fire({
    title: 'هل أنت متأكد؟',
    text: "لن تتمكن من التراجع عن هذا!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'نعم، احذفها!',
    cancelButtonText: 'إلغاء'
  }).then((result) => {
    if (result.isConfirmed) {
      images.value.splice(index, 1);
      Swal.fire(
        'تم الحذف!',
        'تم حذف الصورة.',
        'success'
      );
    }
  });
};

const fileInputRef = ref(null);
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>