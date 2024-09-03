<template>
  <PanelLayout>
    <Head title="إضافة وحدة جديدة" />

    <Header>
      إضافة وحدة جديدة
    </Header>
    <div class="grid grid-cols-1 justify-center items-center bg-gray-100 dark:bg-gray-900">
      <div></div>
      <div class="col-span-3 bg-white dark:bg-gray-800 p-6 rounded shadow-md">
        <form @submit.prevent="saveUnit">
          <div class="mb-4">
            <label for="name" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">الإسم</label>
            <input
              type="text"
              id="name"
              v-model="form.name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600"
            />
            <div v-if="form.errors.name" v-text="form.errors.name" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
          </div>
          <div class="mb-4">
            <label for="symbole" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">الرمز</label>
            <input
              type="text"
              id="symbole"
              v-model="form.symbole"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600"
            />
            <div v-if="form.errors.symbole" v-text="form.errors.symbole" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
          </div>
          <div class="mb-4">
            <label for="value" class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">القيمة بالكيلوغرام</label>
            <input
              type="number"
              step="0.001"
              min="0"
              id="value"
              v-model="form.value"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-100 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:border-gray-600"
            />
            <div v-if="form.errors.value" v-text="form.errors.value" class="text-red-500 dark:text-red-400 text-xs mt-1"></div>
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
              حفظ
            </button>
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
    symbole: '',
name: '',
value: '',
})

const saveUnit = () => {
// Add your save logic here
form.post('/unit/create')
};
</script>

<style scoped>
/* Add any additional styling here */
</style>