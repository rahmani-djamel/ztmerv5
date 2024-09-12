<template>
  <div class="relative min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-white dark:bg-gray-800 shadow-md">
      <div class="container mx-auto px-4 py-2 flex justify-between items-center">
        <!-- Logo and Menu Items -->
        <div class="flex items-center space-x-6">
          <!-- Logo -->
          <div class="text-xl font-bold text-gray-800 dark:text-white ml-6">
            <img src="/images/logo.png" alt="Logo" class="h-8">
          </div>
          <!-- Menu Items -->
          <div class="hidden md:flex space-x-8">
            <Link :href="route('front.states.index')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المناطق</Link>
            <Link :href="route('front.categories.index')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">الأصناف</Link>
            <Link :href="route('front.product')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المنتجات</Link>
            <Link href="#" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المتاجر</Link>
            <Link href="#" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">من نحن</Link>
          </div>
        </div>

        <!-- Icons and Login Link -->
        <div class="flex items-center space-x-4">
          <button @click="toggleDarkMode"  class="text-gray-800 dark:text-white p-2 rounded-full">
            <SunIcon v-if="!isDarkMode" class="h-6 w-6 hover:text-yellow-500" />
            <MoonIcon v-else class="h-6 w-6" />
          </button>
          <div class="relative">
            <ShoppingCartIcon class="h-6 w-6 text-gray-800 dark:text-white hover:text-blue-500" />
            <span class="absolute top-0 left-0 transform -translate-x-1/2 -translate-y-1/2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">5</span>
          </div>
          <Link href="/login" class="hidden lg:block text-gray-800 dark:text-white hover:border-b-2 border-blue-500">تسجيل الدخول</Link>
          <!-- Mobile Menu Button -->
          <button @click="toggleMobileMenu" class="md:hidden text-gray-800 dark:text-white p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
            <Bars3Icon v-if="!mobileMenuOpen" class="h-6 w-6" />
            <XMarkIcon v-else class="h-6 w-6" />
          </button>
        </div>
      </div>
    </nav>

    <!-- Mobile Menu -->
    <div v-if="mobileMenuOpen" class="fixed inset-0 bg-white dark:bg-gray-800 z-50 flex flex-col items-center justify-center space-y-6">
      <Link :href="route('front.states.index')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المناطق</Link>
      <Link :href="route('front.categories.index')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">الأصناف</Link>
      <Link href="#" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المتاجر</Link>
      <Link :href="route('front.product')" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">المنتجات</Link>
      <Link href="#" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">من نحن</Link>
      <Link href="/login" class="text-gray-800 dark:text-white hover:border-b-2 border-blue-500">تسجيل الدخول</Link>
      <button @click="toggleMobileMenu" class="text-gray-800 dark:text-white p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700">
        <XMarkIcon class="h-6 w-6" />
      </button>
    </div>

    <!-- Main Content -->
    <main class="flex-grow dark:bg-gray-700">
      <slot></slot>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-800 text-gray-800 dark:text-white py-4 text-center">
      <p>© 2023 تمرتك. جميع الحقوق محفوظة.</p>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { SunIcon, MoonIcon, Bars3Icon, XMarkIcon, ShoppingCartIcon } from '@heroicons/vue/24/solid';

const isDarkMode = ref(false);
const mobileMenuOpen = ref(false);

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
  document.documentElement.classList.toggle('dark', isDarkMode.value);
  localStorage.setItem('darkMode', isDarkMode.value);
};

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

onMounted(() => {
  const savedMode = localStorage.getItem('darkMode');
  if (savedMode) {
    isDarkMode.value = savedMode === 'true';
    document.documentElement.classList.toggle('dark', isDarkMode.value);
  }
});
</script>

<style scoped>
/* Add any additional styling here */
</style>