<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
            <div class="flex space-x-4">
              <Link
                :href="route('products.index')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
              >
                Products
              </Link>
              <Link
                :href="route('categories.create')"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
              >
                Add Category
              </Link>
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                  >
                    Name
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <CategoryRow
                  v-for="category in categories"
                  :key="category.id"
                  :category="category"
                  :level="0"
                />
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import CategoryRow from "@/Components/CategoryRow.vue";

const props = defineProps({
  categories: Array,
});
</script>
