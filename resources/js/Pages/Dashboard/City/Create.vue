<template>
  <PanelLayout>
    <Head title="إضافة مدينة" />

    <Header>
      إضافة مدينة
    </Header>
    <div class="grid grid-cols-1 justify-center items-center bg-gray-100 dark:bg-gray-900">
      <div></div>
      <div class="col-span-3 bg-white dark:bg-gray-800 p-6 rounded shadow-md">
        <form @submit.prevent="saveCity">
          <div class="mb-4">
            <label for="state" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">اختر المقاطعة:</label>
            <select id="state" v-model="form.state_id" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700">
              <option v-for="(state, key) in states" :key="key" :value="state.id">{{ state.name }}</option>
            </select>
            <div v-if="form.errors.state_id" v-text="form.errors.state_id" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
          </div>
          <div class="mb-4">
            <label for="city" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">اسم المدينة:</label>
            <input type="text" id="city" v-model="form.name" class="shadow appearance-none border dark:border-gray-600 rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 leading-tight focus:outline-none focus:shadow-outline dark:bg-gray-700" />
            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">حفظ</button>
          </div>
        </form>
      </div>
      <div></div>
    </div>
  </PanelLayout>
</template>
  
  <script setup>
  import { reactive } from 'vue';
  import PanelLayout from '@/Layouts/PanelLayout.vue';
  import InputError from '@/Components/InputError.vue';
  import { router } from '@inertiajs/vue3';
  import { Head,useForm } from '@inertiajs/vue3';


  
  const props = defineProps({
    states: {
      type: Object,
      required: true
    }
  });
  const form = useForm({
    state_id: '',
    name: '',
  })
  
  const saveCity = () => {
    // Add your save logic here
    form.post('/city/create')
  };
  </script>
  
  <style scoped>
  /* Add any additional styling here */
  </style>