<template>
  <div class="flex justify-center mt-4">
    <Component
      v-for="link in links"
      :key="link.url || link.label"
      :is="link.url ? 'Link' : 'span'"
      :href="link.url"
      v-html="translateLinkLabel(link.label)"
      class="px-3 py-1 mx-1 rounded-full bg-sky-500 text-white hover:bg-sky-700 transition duration-300 ease-in-out"
      :class="{ 'text-gray-500': !link.url, 'bg-gray-700': link.active, 'font-bold': link.active }"
      v-bind="link.url ? { 'preserve-scroll': true } : {}"
    />
  </div>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      required: true
    }
  },
  methods: {
    translateLinkLabel(label) {
      if (label === 'Previous') return 'السابق';
      if (label === 'Next') return 'التالي';
      return label;
    }
  }
};
</script>

<style scoped>
/* Additional styles if needed */
</style>