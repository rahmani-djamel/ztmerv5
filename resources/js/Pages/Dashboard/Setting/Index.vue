<template>
  <Head title="الإعدادات" />

  <PanelLayout>
    <div class="flex flex-col md:flex-row">
      <!-- First Column: Navigation -->
      <div class="w-full md:w-1/5 p-4 border-r mx-auto bg-white dark:bg-gray-800 shadow-md mb-4 md:mb-0">
        <ul>
          <li
            @click="selectSection('personalInformation')"
            class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center"
            :class="{ 'bg-sky-500 text-white': selectedSection === 'personalInformation', 'dark:bg-sky-500 dark:text-white': selectedSection === 'personalInformation' }"
          >
            <UserIcon
              class="w-6 h-6 mr-2"
              :class="{ 'text-sky-500': selectedSection !== 'personalInformation', 'text-white': selectedSection === 'personalInformation', 'dark:text-sky-500': selectedSection !== 'personalInformation', 'dark:text-white': selectedSection === 'personalInformation' }"
            />
            المعلومات الشخصية
          </li>
          <li
            @click="selectSection('passwordInformation')"
            class="cursor-pointer p-2 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center"
            :class="{ 'bg-sky-500 text-white': selectedSection === 'passwordInformation', 'dark:bg-sky-500 dark:text-white': selectedSection === 'passwordInformation' }"
          >
            <KeyIcon
              class="w-6 h-6 mr-2"
              :class="{ 'text-sky-500': selectedSection !== 'passwordInformation', 'text-white': selectedSection === 'passwordInformation', 'dark:text-sky-500': selectedSection !== 'passwordInformation', 'dark:text-white': selectedSection === 'passwordInformation' }"
            />
            معلومات كلمة المرور
          </li>
        </ul>
      </div>

      <!-- Second Column: Content -->
      <div class="w-full md:w-3/4 p-4 bg-white dark:bg-gray-800 shadow-md">
        <Personal v-if="selectedSection === 'personalInformation'" />
        <Password v-if="selectedSection === 'passwordInformation'" />
      </div>
    </div>
  </PanelLayout>
</template>

<script setup >
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import PanelLayout from '@/Layouts/PanelLayout.vue';
import { UserIcon, KeyIcon, BellIcon } from '@heroicons/vue/24/solid';
// Import the new components
import Personal from '@/Components/Settings/Pdata.vue';
import Password from '@/Components/Settings/Password.vue';

// Define the state for the selected section
const selectedSection = ref('personalInformation');

// Function to change the selected section
const selectSection = (section) => {
  selectedSection.value = section;
};
</script>


<style scoped>
/* Add any additional styling here */
</style>