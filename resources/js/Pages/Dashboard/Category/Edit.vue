<template>
  <Head title="تعديل صنف" />
  <PanelLayout>
    <div class="container mx-auto p-4">
      <Header>تعديل صنف</Header>

      <div class="p-4 rounded bg-white dark:bg-gray-800">
        <form @submit.prevent="saveCategory" class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Form Section -->
          <div class="md:col-span-3 bg-white dark:bg-gray-800 p-2">
            <div class="mb-4">
              <label for="productName" class="block text-gray-700 dark:text-gray-300">اسم</label>
              <input
                type="text"
                id="productName"
                v-model="form.name"
                class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
              />
              <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
            </div>

            <div class="mb-4">
              <label for="avatar" class="block text-gray-700 dark:text-gray-300">الصورة</label>
              <div
                class="border-2 border-dashed border-gray-300 dark:border-gray-600 p-4 text-center cursor-pointer bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
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
              <div v-if="form.errors.image" v-text="form.errors.image" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>

              <div v-if="form.image_preview" class="mt-4 flex items-center justify-center">
                <button @click="removeImage" class="text-red-500 dark:text-red-400 mr-2">
                  <TrashIcon class="w-6 h-6" />
                </button>
                <img :src="form.image_preview" alt="Uploaded Image" class="w-32 h-32 object-cover" @click="showFullSizeImage(form.image_preview)" />
              </div>
            </div>
          </div>
          <!-- Submit Button -->
          <div class="md:col-span-3">
            <button type="submit" class="mt-3 w-full text-white bg-sky-500 dark:bg-sky-600 text-center p-1 rounded shadow-md md:mt-0 md:mb-3">
              تعديل
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
import { Head, useForm, router, usePage } from '@inertiajs/vue3';
import { TrashIcon } from '@heroicons/vue/24/solid';
import Swal from 'sweetalert2';

const page = usePage();

const form = useForm({
  name: page.props.category.name,
  image: null,
  image_preview: page.props.category.image
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

const showFullSizeImage = (imageUrl) => {
  Swal.fire({
    html: `<img src="${imageUrl}" alt="Full Size Image" style="width: 100%; height: auto;" />`,
    showCloseButton: true,
    showConfirmButton: false,
    width: 'auto',
    padding: '1em',
  });
};

const saveCategory = () => {
  const id = page.props.category.id;

  form.post(`/category/update/${id}`, {
    onSuccess: () => {
      Swal.fire('نجاح', 'تم تعديل الصنف بنجاح', 'success');
    },
    onError: () => {
      Swal.fire('خطأ', 'حدث خطأ أثناء تعديل الصنف', 'error');
    },
    preserveScroll: true,
    forceFormData: true
  });
};
</script>