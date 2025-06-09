<template>
  <tr>
    <td class="px-6 py-4 whitespace-nowrap" :style="{ paddingLeft: `${level * 20}px` }">
      {{ category.name }}
    </td>
  </tr>

  <CategoryRow
    v-for="child in category.descendants || []"
    :key="child.id"
    :category="child"
    :level="level + 1"
  />
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  category: Object,
  level: {
    type: Number,
    default: 0,
  },
});
</script>
