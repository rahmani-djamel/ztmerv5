<template>
  <Head title="إضافة متجر جديد" />
  <PanelLayout>
    <div class="container mx-auto p-4">
      <div class="p-4 rounded">
        <Header>
          إضافة متجر جديد
        </Header>
      </div>
      <div v-if="form.errors && Object.keys(form.errors).length > 0" class="mt-4">
        <div v-for="(error, index) in form.errors" :key="index" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
          <span class="block sm:inline">{{ error }}</span>
        </div>
      </div>
      <form @submit.prevent="submitForm" class="grid grid-cols-1 md:grid-cols-6 gap-4">
        <!-- First Column -->
        <div class="bg-white p-4 rounded md:col-span-2">
          <div class="mb-4" v-show="form.lat != ''">
            <label for="lat" class="block text-gray-700">
              lat
            </label>
            <input type="text" disabled id="lat" v-model="form.lat" class="w-full p-2 border border-gray-300 bg-slate-300 rounded" />
          </div>
          <div class="mb-4" v-show="form.lng != ''">
            <label for="lng" class="block text-gray-700">
              lng
            </label>
            <input type="text" disabled id="lng" v-model="form.lng" class="w-full p-2 border border-gray-300 bg-slate-300 rounded" />
          </div>
          <div class="mb-4">
            <label for="market_name" class="block text-gray-700">
                إسم المتجر
            </label>
            <input type="text"  id="market_name" v-model="form.market_name" class="w-full p-2 border border-gray-300  rounded" />
          </div>
          <div class="mb-4">
            <label for="city" class="block text-gray-700">
               رقم الهاتف
            </label>
            <input type="text"  id="phone" v-model="form.phone" class="w-full p-2 border border-gray-300  rounded" placeholder="05xxxxxxxx" />
          </div>
        </div>
        <!-- Second Column -->
        <div class="bg-white p-4 rounded md:col-span-4">
          <h2 class="text-lg font-bold mb-2">
            🗺️ يرجى تحديد موقع المتجر على الخريطة لتحديد الإحداثيات 📍
          </h2>
          <GoogleMap
            api-key="AIzaSyAMFf3ukIr6AdAf3eJLTkvzcuxFoKG4Fac"
            style="width: 100%; height: 500px"
            :center="center"
            :zoom="6"
            @click="placeMarker"
          >
            <Marker
              :options="{ position: center, draggable: true, clickable: true, cursor: 'pointer' }"
              @dragend="updatePosition"
            />
          </GoogleMap>
        </div>
        <!-- Submit Button -->
        <div class="md:col-span-6">
          <button type="submit" class="mt-3 w-full text-white bg-sky-500 text-center p-2 rounded shadow-md md:mt-0 md:mb-3">
            إضافة المتجر
          </button>
        </div>
      </form>
    </div>
  </PanelLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';
import PanelLayout from '@/Layouts/PanelLayout.vue';
import { Head,useForm } from '@inertiajs/vue3';
import { TrashIcon } from '@heroicons/vue/24/solid';
import { GoogleMap, Marker } from 'vue3-google-map';
import { Loader } from '@googlemaps/js-api-loader';




const form = useForm({
  market_name: '',
  phone: '',
  lat: 0,
  lng: 0,
});


const center = ref({
  lat: 24.7136,
  lng: 46.6753,
});

const cordinate = ref({
  lat: 24.7136,
  lng: 46.6753,
});


const updatePosition = (event) => {
  center.value = {
    lat: event.latLng.lat(),
    lng: event.latLng.lng(),
  };
};

const placeMarker = (event) => {
  center.value = {
    lat: event.latLng.lat(),
    lng: event.latLng.lng(),
  };
  form.lat = event.latLng.lat();
  form.lng = event.latLng.lng();
};

const setPlace = (place) => {
  if (place.geometry) {
    center.value = {
      lat: place.geometry.location.lat(),
      lng: place.geometry.location.lng(),
    };
  }
};


const submitForm = () => {
  form.post(route('market.store'), {
    onSuccess: () => {
      Swal.fire({
        title: 'تمت العملية بنجاح',
        icon: 'success',
        showConfirmButton: false,
        timer: 1500,
      });
    },
    onError: () => {
      // Scroll to the top of the page
      window.scrollTo({ top: 0, behavior: 'smooth' });

      Swal.fire({
        title: 'يرجى التأكد من البيانات المدخلة و الموقع على الخريطة و المحاولة مرة أخرى',  
        icon: 'error',
        showConfirmButton: false,
        timer: 1500,
      });
    },
  });
};
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>