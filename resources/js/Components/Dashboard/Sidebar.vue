<template>
    <nav class="flex flex-col w-full">
      <Link
        v-for="item in menuItems"
        :key="item.name"
        :href="item.link"
        class="flex items-center p-2 text-gray-700 hover:bg-gray-200 rounded-md"
      >
        <component
          :is="item.icon"
          :class="{'w-6 h-6 ml-2': isSidebarOpen, 'w-10 h-10': !isSidebarOpen}"
          class="text-sky-500"
          :style="{ marginLeft: isSidebarOpen ? '0.5rem' : '0' }"
        />
        <span v-show="isSidebarOpen" class="ml-2">{{ item.name }}</span>
      </Link>
    </nav>
  </template>
  
  <script setup>
  import { ref, defineProps } from 'vue';
  import { HomeIcon, ArchiveBoxIcon, RectangleGroupIcon } from '@heroicons/vue/24/solid';
  
  const menuItems = ref([
    { name: 'الرئيسية', link: '/', icon: HomeIcon },
    { name: 'المنتجات', link: '/about', icon: ArchiveBoxIcon },
    { name: 'المتاجر', link: '/contact', icon: RectangleGroupIcon },
    // Add more menu items as needed
  ]);
  
  const props = defineProps({
    isSidebarOpen: Boolean
  });
  </script>