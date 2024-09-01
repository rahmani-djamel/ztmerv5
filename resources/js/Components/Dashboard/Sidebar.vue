<template>
  <nav class="flex flex-col w-full">
    <Link
      v-for="item in filteredMenuItems"
      :key="item.name"
      :href="item.link"
      :class="[
        'flex items-center p-2 rounded-md',
        isActive(item.link) ? 'bg-sky-500 text-white' : 'text-gray-700 hover:bg-gray-200'
      ]"
    >
    <component
        :is="item.icon"
        :class="[
          {'w-6 h-6 ml-2': isSidebarOpen, 'w-8 h-8': !isSidebarOpen},
          isActive(item.link) ? 'text-white' : 'text-sky-500'
        ]"
        :style="{ marginLeft: isSidebarOpen ? '0.5rem' : '0' }"
      />
      <span v-show="isSidebarOpen" class="ml-2">{{ item.name }}</span>
    </Link>
  </nav>
</template>

<script setup>
import { ref, defineProps,computed } from 'vue';
import {usePage} from '@inertiajs/vue3';
import { HomeIcon, ArchiveBoxIcon, BuildingStorefrontIcon } from '@heroicons/vue/24/solid';

const page = usePage();
const user = page.props.user;

const menuItems = ref([
  { name: 'الرئيسية', link: '/', icon: HomeIcon, component: 'Home' },
  { name: 'المنتجات', link: '/product', icon: ArchiveBoxIcon, component: 'Product', roles: ['Admin','Vendor'], permissions: ['view-products'] },
  { name: 'المتاجر', link: '/market', icon: BuildingStorefrontIcon, component: 'Market', roles: ['Admin','Vendor'], permissions: ['view-markets'] },
  // Add more menu items as needed
]);

const filteredMenuItems = computed(() => {
  return menuItems.value.filter(item => {
   // const hasRole = item.roles ? item.roles.includes(user.role) : true;
   // const hasPermission = item.permissions ? item.permissions.some(permission => user.permissions.includes(permission)) : true;
   // return hasRole && hasPermission;

    return true;
  });
});

const props = defineProps({
  isSidebarOpen: Boolean
});

const isActive = (link) => {
  if (link === '/') {
    return page.url === '/';
  }
  return page.url.startsWith(link);
};
</script>