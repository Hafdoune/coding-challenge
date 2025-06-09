<template>
  <div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="flex items-center justify-between mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Create Product</h1>
        </div>
        <Link 
          :href="route('products.index')"
          class="text-gray-600 hover:text-gray-800 flex items-center space-x-2"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span>Back to Products</span>
        </Link>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-sm border p-6">
        <form @submit.prevent="submitForm" class="space-y-6">
          <!-- Product Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
              Product Name *
            </label>
            <input
              id="name"
              v-model="form.name"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              :class="{ 'border-red-500': errors.name }"
              placeholder="Enter product name"
              required
            />
            <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name }}</p>
          </div>

          <!-- Description -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
              Description
            </label>
            <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              :class="{ 'border-red-500': errors.description }"
              placeholder="Enter product description"
            ></textarea>
            <p v-if="errors.description" class="mt-1 text-sm text-red-600">{{ errors.description }}</p>
          </div>

          <!-- Price -->
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
              Price ($) *
            </label>
            <input
              id="price"
              v-model="form.price"
              type="number"
              step="0.01"
              min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              :class="{ 'border-red-500': errors.price }"
              placeholder="0.00"
              required
            />
            <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
          </div>

          <!-- Image Upload -->
          <div>
            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
              Product Image
            </label>
            <div class="mt-1 flex items-center space-x-4">
              <div class="flex-shrink-0">
                <img
                  v-if="imagePreview"
                  :src="imagePreview"
                  alt="Preview"
                  class="h-32 w-32 object-cover rounded-md border"
                />
                <div 
                  v-else
                  class="h-32 w-32 flex items-center justify-center bg-gray-100 rounded-md border"
                >
                  <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
              <div class="flex-grow">
                <input
                  id="image"
                  type="file"
                  accept="image/*"
                  class="hidden"
                  @change="handleImageUpload"
                  ref="fileInput"
                />
                <button
                  type="button"
                  @click="$refs.fileInput.click()"
                  class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                  Choose Image
                </button>
                <p class="mt-1 text-sm text-gray-500">
                  PNG, JPG, GIF up to 2MB
                </p>
                <p v-if="errors.image" class="mt-1 text-sm text-red-600">{{ errors.image }}</p>
              </div>
            </div>
          </div>

          <!-- Categories -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Categories
            </label>
            <div class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 rounded-md p-3">
              <div
                v-for="category in categories"
                :key="category.id"
                class="flex items-center"
              >
                <input
                  :id="`category-${category.id}`"
                  v-model="form.category_ids"
                  :value="category.id"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label 
                  :for="`category-${category.id}`" 
                  class="ml-2 text-sm text-gray-700 cursor-pointer"
                >
                  {{ category.name }}
                </label>
              </div>
            </div>
            <p v-if="errors.category_ids" class="mt-1 text-sm text-red-600">{{ errors.category_ids }}</p>
          </div>

          <!-- Form Actions -->
          <div class="flex items-center justify-end space-x-4 pt-6 border-t">
            <Link
              :href="route('products.index')"
              class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors"
            >
              Cancel
            </Link>
            <button
              type="submit"
              :disabled="processing"
              class="px-6 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white rounded-md transition-colors flex items-center space-x-2"
            >
              <svg 
                v-if="processing" 
                class="animate-spin h-4 w-4" 
                fill="none" 
                viewBox="0 0 24 24"
              >
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span>{{ processing ? 'Creating...' : 'Create Product' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const props = defineProps({
  categories: Array,
    errors: {
        type: Object,
        default: () => ({})
    }
})

const processing = ref(false)
const imagePreview = ref(null)
const fileInput = ref(null)

const form = reactive({
  name: '',
  description: '',
  price: '',
  image: null,
  category_ids: []
})

const selectedCategories = computed(() => {
  return props.categories.filter(cat => form.category_ids.includes(cat.id))
})

const handleImageUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.image = file
    const reader = new FileReader()
    reader.onload = (e) => {
      imagePreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const submitForm = () => {
  if (processing.value) return
  
  processing.value = true
  
  // Create FormData object to handle file upload
  const formData = new FormData()
  formData.append('name', form.name)
  formData.append('description', form.description)
  formData.append('price', form.price)
  if (form.image) {
    formData.append('image', form.image)
  }
  form.category_ids.forEach(id => {
    formData.append('categories[]', id)
  })
  
  router.post(route('products.store'), formData, {
    forceFormData: true,
    onFinish: () => {
      processing.value = false
    },
  })
}
</script>