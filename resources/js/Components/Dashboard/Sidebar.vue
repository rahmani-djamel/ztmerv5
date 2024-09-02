<template>
  <nav class="flex flex-col w-full">
    <!-- Close Sidebar Link for Mobile View -->
    <li
      @click="closeSidebar"
      class="flex items-center p-2 rounded-md text-gray-700 hover:bg-gray-200 cursor-pointer md:hidden"
    >
      <Bars4Icon
        :class="[
          {'w-6 h-6 ml-2': isSidebarOpen, 'w-8 h-8': !isSidebarOpen},
          isActive('/') ? 'text-white' : 'text-sky-500'
        ]"
        :style="{ marginLeft: isSidebarOpen ? '0.5rem' : '0' }"
      />
      <span v-show="isSidebarOpen" class="ml-2">رجوع</span>
    </li>

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


    <!-- Logout Link -->
    <Link
      href="/logout"
      method="post" as="button" type="button"
      class="flex items-center p-2 rounded-md text-gray-700 hover:bg-gray-200"
    >
      <ArrowRightStartOnRectangleIcon
        :class="[
          {'w-6 h-6 ml-2': isSidebarOpen, 'w-8 h-8': !isSidebarOpen},
          'text-sky-500'
        ]"
        :style="{ marginLeft: isSidebarOpen ? '0.5rem' : '0' }"
      />
      <span v-show="isSidebarOpen" class="ml-2">تسجيل الخروج</span>
    </Link>
  </nav>
</template>

<script setup>
import { ref, defineProps, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { HomeIcon, ArchiveBoxIcon, BuildingStorefrontIcon, Bars4Icon, ArrowRightStartOnRectangleIcon,UserGroupIcon,MapPinIcon, Cog6ToothIcon } from '@heroicons/vue/24/solid';

const page = usePage();
const user = page.props.auth.user;
const role = page.props.auth.role;

const menuItems = ref([
  { name: 'الرئيسية', link: '/dashboard', icon: HomeIcon, component: 'Home' },
  { name: 'المنتجات', link: '/product', icon: ArchiveBoxIcon, component: 'Product', roles: ['SuperAdmin', 'Vendor'], permissions: ['view-products'] },
  { name: 'المتاجر', link: '/market', icon: BuildingStorefrontIcon, component: 'Market', roles: ['SuperAdmin', 'Vendor'], permissions: ['view-markets'] },
  { name: 'المستخدمين', link: '/user', icon: UserGroupIcon, component: 'User', roles: ['SuperAdmin'], permissions: ['view-users'] },
  {name: 'المدن', link: '/city', icon: MapPinIcon, component: 'City', roles: ['SuperAdmin'], permissions: ['view-cities'] },
  {name: 'الإعدادات', link: '/setting', icon: Cog6ToothIcon, component: 'Setting',  },
  // Add more menu items as needed
]);

const filteredMenuItems = computed(() => {
  return menuItems.value.filter(item => {
    if (item.roles && !item.roles.includes(role)) {
      return false;
    }
    return true;
  });
});

const props = defineProps({
  isSidebarOpen: Boolean,
  closeSidebar: Function
});

const isActive = (link) => {
  if (link === '/') {
    return page.url === '/';
  }
  return page.url.startsWith(link);
};
</script>