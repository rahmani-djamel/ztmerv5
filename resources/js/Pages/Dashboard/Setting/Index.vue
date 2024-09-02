<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import PanelLayout from '@/Layouts/PanelLayout.vue';
import { UserIcon, KeyIcon, BellIcon } from '@heroicons/vue/24/solid';
// Import the new components
import PersonalInformation from '@/Components/Settings/PersonalInformation.vue';
import PasswordInformation from '@/Components/Settings/PasswordInformation.vue';
import NotificationSettings from '@/Components/Settings/NotificationSettings.vue';


// Define the state for the selected section
const selectedSection = ref('personalInformation');

// Function to change the selected section
const selectSection = (section: string) => {
  selectedSection.value = section;
};
</script>

<template>
  <Head title="الإعدادات" />

  <PanelLayout>
    <div class="flex flex-col md:flex-row">
      <!-- First Column: Navigation -->
      <div class="w-full md:w-1/5 p-4 border-r mx-auto bg-white shadow-md mb-4 md:mb-0">
        <ul>
            <li
            @click="selectSection('personalInformation')"
            class="cursor-pointer p-2 hover:bg-gray-100 flex items-center"
            :class="{ 'bg-sky-500 text-white': selectedSection === 'personalInformation' }"
            >
            <UserIcon
                class="w-6 h-6 mr-2"
                :class="{ 'text-sky-500': selectedSection !== 'personalInformation', 'text-white': selectedSection === 'personalInformation' }"
            />
            المعلومات الشخصية
            </li>
            <li
            @click="selectSection('passwordInformation')"
            class="cursor-pointer p-2 hover:bg-gray-100 flex items-center"
            :class="{ 'bg-sky-500 text-white': selectedSection === 'passwordInformation' }"
            >
            <KeyIcon
                class="w-6 h-6 mr-2"
                :class="{ 'text-sky-500': selectedSection !== 'passwordInformation', 'text-white': selectedSection === 'passwordInformation' }"
            />
            معلومات كلمة المرور
            </li>
            <li
            @click="selectSection('notificationSettings')"
            class="cursor-pointer p-2 hover:bg-gray-100 flex items-center"
            :class="{ 'bg-sky-500 text-white': selectedSection === 'notificationSettings' }"
            >
            <BellIcon
                class="w-6 h-6 mr-2"
                :class="{ 'text-sky-500': selectedSection !== 'notificationSettings', 'text-white': selectedSection === 'notificationSettings' }"
            />
            إعدادات الإشعارات
            </li>
        </ul>
    </div>

      <!-- Second Column: Content -->
      <div class="w-full md:w-3/4 p-4 bg-white shadow-md">
        <PersonalInformation v-if="selectedSection === 'personalInformation'" />
        <PasswordInformation v-if="selectedSection === 'passwordInformation'" />
      </div>
    </div>
  </PanelLayout>
</template>

<style scoped>
/* Add any additional styling here */
</style>