<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <h3 class="text-lg font-semibold">Create New Category</h3>
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
          <form @submit.prevent="submit" class="space-y-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700"
                >Name</label
              >
              <input
                type="text"
                id="name"
                v-model="form.name"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
              />
              <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                {{ form.errors.name }}
              </div>
            </div>

            <div>
              <label
                for="parent_category_id"
                class="block text-sm font-medium text-gray-700"
                >Parent Category</label
              >
              <select
                id="parent_category_id"
                v-model="form.parent_category_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
              >
                <option value="">None</option>
                <option
                  v-for="category in categories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </select>
              <div
                v-if="form.errors.parent_category_id"
                class="text-red-500 text-sm mt-1"
              >
                {{ form.errors.parent_category_id }}
              </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
              <Link
                :href="route('categories.index')"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
              >
                Cancel
              </Link>
              <button
                type="submit"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                :disabled="form.processing"
              >
                Create Category
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  categories: Array,
});

const form = useForm({
  name: "",
  parent_category_id: "",
});

const submit = () => {
  form.post(route("categories.store"));
};
</script>
