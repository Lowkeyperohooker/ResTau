<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// 1. Create a variable to hold our menu data
const menuItems = ref([]);
const loading = ref(true);

// 2. Fetch data when the app starts
onMounted(async () => {
  try {
    // Make sure this matches your Laravel URL
    const response = await axios.get('http://127.0.0.1:8000/api/menu-items'); 
    menuItems.value = response.data;
    loading.value = false;
  } catch (error) {
    console.error("Error fetching menu:", error);
    loading.value = false;
  }
});

// Helper function to format currency
const formatPrice = (price) => {
  return parseFloat(price).toFixed(2);
}
</script>

<template>
  <div class="flex h-screen bg-gray-100 font-sans">
    
    <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
      <div class="p-6 border-b border-gray-100">
        <h1 class="text-2xl font-extrabold text-red-600 tracking-tight">Restau POS</h1>
      </div>
      
      <nav class="flex-1 p-4 space-y-2">
        <a href="#" class="flex items-center p-3 bg-red-50 text-red-600 rounded-lg font-bold">
          <span>🍔 Menu</span>
        </a>
        <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
          <span>🧾 Orders</span>
        </a>
        <a href="#" class="flex items-center p-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
          <span>⚙️ Settings</span>
        </a>
      </nav>
    </div>

    <div class="flex-1 flex flex-col h-screen overflow-hidden">
      <header class="bg-white border-b border-gray-200 p-4 flex justify-between items-center shadow-sm z-10">
        <h2 class="text-xl font-bold text-gray-800">Select Items</h2>
        <div class="text-sm text-gray-500">Cashier: <span class="font-bold text-gray-800">Admin</span></div>
      </header>

      <main class="flex-1 overflow-y-auto p-6">
        
        <div v-if="loading" class="text-center py-20 text-gray-500">
          Loading menu items...
        </div>

        <div v-else-if="menuItems.length === 0" class="text-center py-20 text-gray-500">
          No items found in the database.
        </div>

        <div v-else class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div 
            v-for="item in menuItems" 
            :key="item.id" 
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-md transition cursor-pointer flex flex-col"
          >
            <div class="h-32 bg-orange-100 rounded-lg mb-4 flex items-center justify-center text-orange-400">
              <span class="text-4xl">🍽️</span>
            </div>
            
            <div class="flex-1">
              <span class="text-xs font-bold text-red-500 uppercase tracking-wide">{{ item.category_name }}</span>
              <h3 class="text-lg font-bold text-gray-800 leading-tight mt-1">{{ item.name }}</h3>
              <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ item.description }}</p>
            </div>
            
            <div class="mt-4 flex items-center justify-between">
              <span class="text-lg font-bold text-gray-900">${{ formatPrice(item.price) }}</span>
              <button class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold hover:bg-red-700">
                +
              </button>
            </div>
          </div>
        </div>

      </main>
    </div>
  </div>
</template>