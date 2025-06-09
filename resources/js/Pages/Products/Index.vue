<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Products</h1>
      <div class="flex space-x-4">
        <Link 
          :href="route('products.create')"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
        >
          Add Product
        </Link>
      </div>
    </div>
    
    <!-- Products Grid -->
    <div v-if="products.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      <div
        v-for="product in products"
        :key="product.id"
        class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow"
      >
        <!-- Product Image -->
        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gray-200">
          <img
            v-if="product.image_url"
            :src="product.image_url"
            :alt="product.name"
            class="h-48 w-full object-cover object-center"
          />
          <div 
            v-else
            class="h-48 w-full flex items-center justify-center bg-gray-100"
          >
            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>

        <!-- Product Info -->
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-900 mb-2">
            {{ product.name }}
          </h3>
          <p class="text-gray-600 text-sm mb-3 line-clamp-2">
            {{ product.description }}
          </p>
          
          <!-- Categories -->
          <div v-if="product.categories.length" class="mb-3">
            <div class="flex flex-wrap gap-1">
              <span
                v-for="category in product.categories"
                :key="category.id"
                class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full"
              >
                {{ category.name }}
              </span>
            </div>
          </div>

          <!-- Price and Actions -->
          <div class="flex items-center justify-between">
            <span class="text-2xl font-bold text-green-600">
              ${{ parseFloat(product.price).toFixed(2) }}
            </span>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
      </svg>
      <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
      <Link
        :href="route('products.create')"
        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
      >
        Add Product
      </Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  products: Array,
})
</script>