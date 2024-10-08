<template>
  <div class="flex h-screen bg-gray-100 dark:bg-gray-900" :class="{'dark': isDarkMode}">
    <!-- Sidebar -->
    <aside
      class="bg-white dark:bg-gray-800 shadow-md flex-shrink-0 transition-all duration-300"
      :class="{
        'w-full md:w-1/4 lg:w-1/6': isSidebarOpen,
        'w-0 md:w-16 lg:w-16': !isSidebarOpen,
      }"
    >
      <div
        class="p-4 flex flex-col items-center"
        :class="{ 'hidden md:flex': !isSidebarOpen }"
      >
      <Link href="/" class="flex items-center mb-4">
          <img
            v-show="isSidebarOpen"
            :src="'/images/logo.png'"
            alt="User Image"
            class="w-36 h-16"
          />
        </Link>
        <Sidebar :isSidebarOpen="isSidebarOpen" :closeSidebar="closeSidebar" class="mt-12" />
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden bg-white dark:bg-gray-800">
      <!-- Header -->
      <header class="bg-white dark:bg-gray-800 shadow-md p-4 flex justify-between items-center">
        <button
          @click="toggleSidebar"
          class="text-gray-500 dark:text-gray-300 focus:outline-none"
        >
          <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16m-7 6h7"
            ></path>
          </svg>
        </button>
        <div class="relative">
          <button
            @click="toggleDarkMode"
            class="text-gray-500 dark:text-gray-300 focus:outline-none ml-4 p-2 rounded-full"
          >
            <SunIcon v-if="isDarkMode" class="h-6 w-6" />
            <MoonIcon v-else class="h-6 w-6" />
          </button>

          <button class="text-gray-500 dark:text-gray-300 focus:outline-none">
            <img
              :src="avatar"
              alt="User Image"
              class="w-8 h-8 rounded-full"
            />
          </button>
          <!-- Notification dropdown can be added here -->
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 overflow-y-auto p-4 bg-gray-100 dark:bg-gray-900">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import Sidebar from '@/Components/Dashboard/Sidebar.vue';
import { usePage } from '@inertiajs/vue3';
import { SunIcon, MoonIcon } from '@heroicons/vue/24/solid';

defineProps({
  user: {
    type: Object,
    required: false,
    default: null,
  },
  avatar: {
    type: String,
    required: false,
    default: null,
  },
  pageTitle: {
    type: String,
    required: false,
    default: '',
  }
});

const page = usePage();
const avatar = computed(() => page.props.auth.avatar);

const isSidebarOpen = ref(true);

const isDarkMode = ref(false);

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  localStorage.setItem('darkMode', isDarkMode.value);
  applyDarkMode();
};

const applyDarkMode = () => {
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

const closeSidebar = () => {
  isSidebarOpen.value = false;
};

onMounted(() => {
  if (window.innerWidth < 768) {
    isSidebarOpen.value = false;
  }
  isDarkMode.value = localStorage.getItem('darkMode') === 'true';
  applyDarkMode();
});
</script>

<style scoped>
.container {
  max-width: 1200px;
}
</style>