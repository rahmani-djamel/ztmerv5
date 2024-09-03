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
            <div class="mb-4" v-show="form.address != ''">
              <label for="lat" class="block text-gray-700">
                العنوان
              </label>
              <input type="text" disabled id="lat" v-model="form.address" class="w-full p-2 border border-gray-300 bg-slate-300 rounded" />
            </div>
            <div class="mb-4" v-show="form.city != ''">
              <label for="lat" class="block text-gray-700">
                المدينة
              </label>
              <input type="text" disabled id="lat" v-model="form.city" class="w-full p-2 border border-gray-300 bg-slate-300 rounded" />
            </div>
            <div class="mb-4" v-show="form.state != ''">
              <label for="lat" class="block text-gray-700">
                المحافظة
              </label>
              <input type="text" disabled id="lat" v-model="form.state" class="w-full p-2 border border-gray-300 bg-slate-300 rounded" />
            </div>
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
  import { Head,useForm,usePage } from '@inertiajs/vue3';
  import { TrashIcon } from '@heroicons/vue/24/solid';
  import { GoogleMap, Marker } from 'vue3-google-map';
  import { Loader } from '@googlemaps/js-api-loader';
  
  const loader = new Loader({
    apiKey: 'AIzaSyAMFf3ukIr6AdAf3eJLTkvzcuxFoKG4Fac',
    version: 'weekly',
    libraries: ['geocoding'],
    language: 'ar',
    region: 'SA',
  });


  
  const apiPromise = loader.load();
  const page = usePage();
  
  
  const form = useForm({
    market_name: page.props.market.market_name,
    phone: page.props.market.phone,
    lat: parseFloat(page.props.market.lat),
    lng: parseFloat(page.props.market.lng),
    address: '',
    city: '',
    state: '',
  });
  
  const geocodeLatLng = () => {
  
    apiPromise.then(() => {
    const geocoder = new google.maps.Geocoder();
  
    // Example usage of reverse geocoding
    const latLng = { lat: form.lat, lng: form.lng }; // Bind lat and lng from form
  
    geocoder.geocode({ location: latLng }, (results, status) => {
      if (status === 'OK') {
        if (results[0]) {
          console.log("Here is the address for the coordinates you entered: ");
          console.log(results[0]);
  
          // Extract formatted address
          form.address = results[0].formatted_address;
          console.log("Address: " + form.address);
  
          // Extract city from the address components
          const addressComponents = results[0].address_components;
          const cityComponent = addressComponents.find(component => component.types.includes('locality'));
          form.city = cityComponent ? cityComponent.long_name : 'N/A';
          console.log("City: " + form.city);
  
          // Extract state from the address components
          const stateComponent = addressComponents.find(component => component.types.includes('administrative_area_level_1'));
          form.state = stateComponent ? stateComponent.long_name : 'N/A';
          console.log("State: " + form.state);
        } else {
          console.error('No results found');
        }
      } else {
        console.error('Geocode was not successful for the following reason: ' + status);
      }
    });
  });
  
  }
  
  
  
  
  const center = ref({
    lat: parseFloat(page.props.market.lat),
    lng: parseFloat(page.props.market.lng),
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
    geocodeLatLng();
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
    var id = page.props.market.id;
    form.patch(route('market.update',id), {
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

  onMounted(() => {
    geocodeLatLng();
});
  </script>
  
  <style scoped>
  .container {
    max-width: 1200px;
  }
  </style>