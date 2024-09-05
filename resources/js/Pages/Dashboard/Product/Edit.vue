<template>
    <Head title="تعديل منتج " />
    <PanelLayout>
      <div class="container mx-auto p-4 bg-gray-100 dark:bg-gray-900">
        <Header>
          تعديل منتج 
        </Header>
  
        <div class="p-4 rounded bg-white dark:bg-gray-800">
          <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- Form Section -->
          <div class="md:col-span-2 bg-white dark:bg-gray-800 p-2">
            <div class="mb-4">
              <label for="productName" class="block text-gray-700 dark:text-gray-300">اسم المنتج</label>
              <input type="text" id="productName" v-model="form.name" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-gray-100" />
              <div v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</div>
            </div>
            <div class="mb-4">
              <label for="city" class="block text-gray-700 dark:text-gray-300">الصنف</label>
              <select id="state" v-model="form.category_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
                <option v-for="(category, key) in categories" :key="key" :value="category.id">{{ category.name }}</option>
              </select>   
              <div v-if="form.errors.category_id" class="text-red-500 text-xs mt-1">{{ form.errors.category_id }}</div>         
            </div>

            <div class="mb-4">
              <label for="city" class="block text-gray-700 dark:text-gray-300">
                منطقة الإنتاج
              </label>
              <select id="state" v-model="form.state_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
                <option v-for="(state, key) in states" :key="key" :value="state.id">{{ state.name }}</option>
              </select> 
              <div v-if="form.errors.state_id" class="text-red-500 text-xs mt-1">{{ form.errors.state_id }}</div>                    
            </div>
            <div v-if="showCities" class="mb-4">
              <label for="city" class="block text-gray-700 dark:text-gray-300">
                المدينة
              </label>
              <select id="city" v-model="form.city_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
                <option v-for="(city, key) in cities" :key="key" :value="city.id">{{ city.name }}</option>
              </select>    
              <div v-if="form.errors.city_id" class="text-red-500 text-xs mt-1">{{ form.errors.city_id }}</div>                            
            </div>
            <div class="mb-4">
              <label for="city" class="block text-gray-700 dark:text-gray-300">الوحدة</label>
              <select id="state" v-model="form.unit_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
                <option v-for="(unit, key) in units" :key="key" :value="unit.id">{{ unit.name }}</option>
              </select>            
              <div v-if="form.errors.unit_id" class="text-red-500 text-xs mt-1">{{ form.errors.unit_id }}</div>                            
            </div>

            <div class="mb-4">
              <label for="city" class="block text-gray-700 dark:text-gray-300">التغليف</label>
              <select id="state" v-model="form.package_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
                <option v-for="(packag, key) in packages" :key="key" :value="packag.id">{{ packag.name }}</option>
              </select>            
              <div v-if="form.errors.package_id" class="text-red-500 text-xs mt-1">{{ form.errors.package_id }}</div>                            
            </div>

            <div class="mb-4">
              <label for="weight" class="block text-gray-700 dark:text-gray-300">الوزن</label>
              <input type="number" id="weight" v-model="form.weight" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-gray-100" />
              <div v-if="form.errors.weight" class="text-red-500 text-xs mt-1">{{ form.errors.weight }}</div>                            
            </div>

            <div class="mb-4">
              <label for="qte" class="block text-gray-700 dark:text-gray-300">الكمية</label>
              <input type="number" id="qte" v-model="form.qte" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-gray-100" />
              <div v-if="form.errors.qte" class="text-red-500 text-xs mt-1">{{ form.errors.qte }}</div>                            

            </div>
            <div class="mb-4">
              <label for="price" class="block text-gray-700 dark:text-gray-300">السعر</label>
              <input type="number" id="price" v-model="form.price" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-gray-100" />
              <div v-if="form.errors.price" class="text-red-500 text-xs mt-1">{{ form.errors.price }}</div>                            

            </div>

            <div class="mb-4">
              <label for="description" class="block text-gray-700 dark:text-gray-300">الوصف</label>
              <textarea id="description" v-model="form.description" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-gray-100"></textarea>
              <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>                            
            </div>
          </div>
            <!-- File Upload Section -->
            <div class="md:col-span-1 p-2 bg-white dark:bg-gray-800">
              <div v-if="form.errors.media" class="text-red-500 text-xs mt-1">{{ form.errors.media }}</div>                            
              <div
                class="border-2 border-dashed border-gray-300 dark:border-gray-600 p-4 rounded cursor-pointer"
                @dragover.prevent
                @drop.prevent="handleDrop"
                @click="handleClick"
              >
                <div class="mb-4" @click.stop>
                  <label for="media" class="block text-center text-gray-700 dark:text-gray-300">الصور والفيديوهات</label>
                  <input type="file" id="media" ref="fileInputRef" @change="uploadMedia" class="hidden" accept="image/*,video/*" multiple />
                </div>
                <p class="text-center text-gray-500 dark:text-gray-400">
                  اسحب وأفلت الصور أو الفيديوهات هنا أو انقر للتحميل (الحد الأقصى 5 ملفات، كل ملف حتى 6 ميجا)
                </p>
              </div>
              <div v-if="form.media.length" class="mt-4 grid grid-cols-3 gap-2">
                <div
                  v-for="(media, index) in form.media"
                  :key="index"
                  class="relative mb-2"
                  draggable="true"
                  @dragstart="dragStart(index)"
                  @dragover.prevent
                  @drop="drop(index)"
                >
                  <img v-if="media.file.type.startsWith('image/')" :src="media.preview" alt="الصورة" class="w-full h-24 object-cover rounded cursor-pointer" @click="previewMedia(media)" />
                  <video v-if="media.file.type.startsWith('video/')" :src="media.preview" class="w-full h-24 object-cover rounded cursor-pointer" @click="previewMedia(media)" />
                  <button @click="removeMedia(index)" type="button" class="absolute top-2 right-2 bg-red-500 text-white p-1 rounded-full">
                    <TrashIcon class="h-5 w-5" />
                  </button>
                </div>
              </div>
            </div>
            <!-- Submit Button -->
            <div class="md:col-span-3">
              <div v-if="form.progress" class="w-full bg-gray-200 dark:bg-gray-700 rounded-full mb-2">
                <div class="bg-sky-500 dark:bg-sky-600 text-xs leading-none py-1 text-center text-white rounded-full" :style="{ width: form.progress.percentage + '%' }">
                  {{ form.progress.percentage  }}%
                </div>
              </div>
              <button type="submit" class="mt-3 w-full text-white bg-sky-500 dark:bg-sky-600 dark:hover:bg-sky-700 text-center p-1 rounded shadow-md md:mt-0 md:mb-3">
                تعديل المنتج
              </button>
            </div>
          </form>
        </div>
      </div>
    </PanelLayout>
  </template>
  
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import Swal from 'sweetalert2';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import { Head, useForm, usePage } from '@inertiajs/vue3';
  import { TrashIcon } from '@heroicons/vue/24/solid';
  import axios from 'axios';
  
  const page = usePage();
  
  const form = useForm({
    name: page.props.product.name,
    category_id: page.props.product.category_id,
    unit_id: page.props.product.unit_id,
    state_id: page.props.product.state_id,
    city_id: page.props.product.city_id,
    package_id: page.props.product.package_id,
    qte: page.props.product.qte,
    weight: page.props.product.weight,
    price: page.props.product.price,
    description: page.props.product.description,
    media: page.props.product.media
        .sort((a, b) => a.order - b.order)
        .map(media => ({
            id: media.id,
            name: media.name,
            path: media.path,
            url: media.url,
            file: { type: media.url.endsWith('.mp4') ? 'video/mp4' : 'image/jpeg' }, // Assuming file type based on URL
            preview: media.url,
        })),
  });
  
  const showCities = ref(true);
  const cities = ref([]);
  const fileInputRef = ref(null);
  let draggedIndex = null;
  
  const fetchCities = async (stateId) => {
    const response = await axios.get(`/state/${stateId}/cities`);
    cities.value = response.data;
  };
  
  watch(() => form.state_id, async (newState) => {
    if (newState) {
      await fetchCities(newState);
      showCities.value = true;
    } else {
      cities.value = [];
      showCities.value = false;
    }
  });
  
  onMounted(() => {   
    fetchCities(page.props.product.state_id)
    form.city_id = page.props.product.city_id 
  })
  
  defineProps({
    categories: {
      type: Object,
      required: true,
    },
    units: {
      type: Object,
      required: true,
    },
    states: {
      type: Object,
      required: true,
    },
    product: {
      type: Object,
      required: true,
    },
    packages: {
      type: Object,
      required: true,
    },
  });
  
  const submitForm = () => {
    // Check if the number of files exceeds 5
    if (form.media.length > 5) {
      Swal.fire('حدث خطأ!', 'لا يمكن تحميل أكثر من 5 ملفات.', 'error');
      return;
    }
  
    // Check if any file exceeds 6 MB
    for (let media of form.media) {
      if (media.file.size > 6 * 1024 * 1024) { // 6 MB in bytes
        Swal.fire('حدث خطأ!', `الملف ${media.file.name} أكبر من 6 ميجا.`, 'error');
        return;
      }
    }
    let id = page.props.product.id;
  
    // Handle form submission
    form.post('/product/update/'+id, {
      preserveScroll: true,
      onBefore: () => {
        form.progress = { percentage: 0 };
      },
      onSuccess: () => {
        Swal.fire('تمت العملية بنجاح!', 'تمت تعديل المنتج بنجاح.', 'success');
        form.reset();
      },
      onError: (errors) => {
        console.log(errors);
        
        Swal.fire('حدث خطأ!', 'يرجى التحقق من البيانات المدخلة.', 'error');
      },
    });
  };
  
  const handleDrop = (event) => {
    const files = event.dataTransfer.files;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (file && (file.type.startsWith('image/') || file.type.startsWith('video/'))) {
        form.media.push({ preview: URL.createObjectURL(file), file });
      }
    }
  };
  
  const handleClick = () => {
    const fileInput = fileInputRef.value;  
    fileInput.click();
  };
  
  const uploadMedia = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      if (file && (file.type.startsWith('image/') || file.type.startsWith('video/'))) {
        form.media.push({ preview: URL.createObjectURL(file), file });
      }
    }
  };
  
  const removeMedia = (index) => {
    Swal.fire({
      title: 'هل أنت متأكد؟',
      text: "لن تتمكن من التراجع عن هذا!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'نعم، احذفها!',
      cancelButtonText: 'إلغاء',
    }).then((result) => {
      if (result.isConfirmed) {
        form.media.splice(index, 1);
        Swal.fire('تم الحذف!', 'تم حذف الوسائط.', 'success');
      }
    });
  };
  
  const previewMedia = (media) => {
    if (media.file.type.startsWith('image/')) {
      Swal.fire({
        imageUrl: media.preview,
        imageAlt: 'Preview Image',
        showCloseButton: true,
        showConfirmButton: false,
      });
    } else if (media.file.type.startsWith('video/')) {
      Swal.fire({
        html: `<video controls autoplay style="width: 100%; height: auto;"><source src="${media.preview}" type="${media.file.type}"></video>`,
        showCloseButton: true,
        showConfirmButton: false,
      });
    }
  };
  
  const dragStart = (index) => {
    draggedIndex = index;
  };
  
  const drop = (index) => {
    const draggedItem = form.media[draggedIndex];
    form.media.splice(draggedIndex, 1);
    form.media.splice(index, 0, draggedItem);
    draggedIndex = null;
    console.log('Updated media list:', form.media);
  };
  
  </script>
  
  <style scoped>
  .container {
    max-width: 1200px;
  }
  </style>