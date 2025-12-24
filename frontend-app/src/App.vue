<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// --- STATE ---
const menuItems = ref([]);
const cart = ref([]);
const orders = ref([]); // Stores order history
const loading = ref(true);
const currentView = ref('menu'); // Controls which screen is visible ('menu' or 'orders')

// --- FETCH MENU ON LOAD ---
onMounted(async () => {
  await fetchMenu();
});

const fetchMenu = async () => {
  try {
    loading.value = true;
    const response = await axios.get('http://127.0.0.1:8000/api/menu-items'); 
    menuItems.value = response.data;
  } catch (error) {
    console.error("Error fetching menu:", error);
  } finally {
    loading.value = false;
  }
};

// --- NAVIGATION LOGIC ---
const switchView = async (view) => {
  currentView.value = view;
  
  if (view === 'orders') {
    loading.value = true;
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/orders');
      orders.value = response.data;
    } catch (error) {
      console.error("Error fetching orders:", error);
    } finally {
      loading.value = false;
    }
  } else if (view === 'menu' && menuItems.value.length === 0) {
    // Reload menu if empty
    await fetchMenu();
  }
};

// --- CART LOGIC ---
const addToCart = (item) => {
  const existingItem = cart.value.find(i => i.id === item.id);
  if (existingItem) {
    existingItem.quantity++;
  } else {
    cart.value.push({ ...item, quantity: 1 });
  }
};

const increaseQty = (item) => item.quantity++;

const decreaseQty = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
  } else {
    cart.value = cart.value.filter(i => i.id !== item.id);
  }
};

// --- CALCULATIONS & CHECKOUT ---
const cartTotal = computed(() => {
  return cart.value.reduce((total, item) => total + (item.price * item.quantity), 0);
});

const formatPrice = (price) => parseFloat(price).toFixed(2);

const checkout = async () => {
  if (cart.value.length === 0) return;
  
  if (!confirm(`Confirm charge of $${formatPrice(cartTotal.value)}?`)) return;

  try {
    await axios.post('http://127.0.0.1:8000/api/orders', {
      cart: cart.value,
      total: cartTotal.value
    });

    alert('Order successfully saved!');
    cart.value = []; // Clear the cart
    
    // If we are on the orders page, refresh the list
    if (currentView.value === 'orders') {
      switchView('orders');
    }
  } catch (error) {
    console.error(error);
    alert('Failed to save order.');
  }
};
</script>

<template>
  <div class="flex h-screen bg-gray-100 font-sans overflow-hidden">
    
    <div class="w-20 lg:w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 transition-all duration-300">
      <div class="h-16 flex items-center justify-center lg:justify-start lg:px-6 border-b border-gray-100">
        <h1 class="text-xl font-extrabold text-red-600 tracking-tight hidden lg:block">Restau POS</h1>
        <span class="text-2xl lg:hidden">🍔</span>
      </div>
      
      <nav class="flex-1 p-2 space-y-2">
        <a 
          href="#" 
          @click.prevent="switchView('menu')"
          class="flex items-center p-3 rounded-lg font-bold justify-center lg:justify-start transition"
          :class="currentView === 'menu' ? 'bg-red-50 text-red-600' : 'text-gray-400 hover:bg-gray-50'"
        >
          <span class="text-xl">🍔</span>
          <span class="ml-3 hidden lg:block">Menu</span>
        </a>
        
        <a 
          href="#" 
          @click.prevent="switchView('orders')"
          class="flex items-center p-3 rounded-lg font-bold justify-center lg:justify-start transition"
          :class="currentView === 'orders' ? 'bg-red-50 text-red-600' : 'text-gray-400 hover:bg-gray-50'"
        >
          <span class="text-xl">🧾</span>
          <span class="ml-3 hidden lg:block">Orders</span>
        </a>

        <a href="#" class="flex items-center p-3 text-gray-400 hover:bg-gray-50 rounded-lg transition justify-center lg:justify-start">
          <span class="text-xl">⚙️</span>
          <span class="ml-3 hidden lg:block">Settings</span>
        </a>
      </nav>
    </div>

    <div class="flex-1 flex flex-col min-w-0 bg-gray-50">
      <header class="h-16 bg-white border-b border-gray-200 flex items-center px-6 justify-between flex-shrink-0">
        <h2 class="text-lg font-bold text-gray-800">
          {{ currentView === 'menu' ? 'Select Items' : 'Transaction History' }}
        </h2>
        <div class="text-sm text-gray-500">Cashier: <span class="font-bold text-gray-800">Admin</span></div>
      </header>

      <main class="flex-1 overflow-y-auto p-6 scrollbar-hide">
        
        <div v-if="loading" class="flex h-full items-center justify-center text-gray-400">
          Loading...
        </div>

        <div v-else-if="currentView === 'menu'">
            <div v-if="menuItems.length === 0" class="flex h-full items-center justify-center text-gray-400">
              No items found.
            </div>

            <div v-else class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
              <div 
                v-for="item in menuItems" 
                :key="item.id" 
                @click="addToCart(item)"
                class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 cursor-pointer hover:shadow-md hover:border-red-200 transition group"
              >
                <div class="h-28 bg-orange-50 rounded-lg mb-3 flex items-center justify-center text-3xl group-hover:scale-105 transition">
                  🍽️
                </div>
                <div>
                  <h3 class="font-bold text-gray-800 truncate">{{ item.name }}</h3>
                  <p class="text-xs text-gray-500 line-clamp-1">{{ item.description }}</p>
                  <div class="mt-2 font-bold text-red-600">${{ formatPrice(item.price) }}</div>
                </div>
              </div>
            </div>
        </div>

        <div v-else-if="currentView === 'orders'" class="space-y-4">
            <div v-if="orders.length === 0" class="text-center text-gray-400 py-10">No orders found.</div>

            <div 
              v-for="order in orders" 
              :key="order.id" 
              class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center"
            >
              <div>
                <div class="font-bold text-gray-800">Order #{{ order.id }}</div>
                <div class="text-sm text-gray-500">{{ new Date(order.created_at).toLocaleString() }}</div>
                <div class="text-xs text-gray-400 mt-1">Cashier: {{ order.cashier_name }}</div>
              </div>
              
              <div class="text-right">
                <div class="font-bold text-xl text-green-600">${{ formatPrice(order.total_amount) }}</div>
                <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                  {{ order.status }}
                </span>
              </div>
            </div>
        </div>

      </main>
    </div>

    <div class="w-96 bg-white border-l border-gray-200 flex flex-col flex-shrink-0 shadow-xl z-20">
      <div class="h-16 flex items-center px-6 border-b border-gray-100 bg-gray-50">
        <h2 class="text-lg font-bold text-gray-800">Current Order</h2>
        <span class="ml-auto bg-red-100 text-red-600 py-1 px-3 rounded-full text-xs font-bold">
          {{ cart.length }} items
        </span>
      </div>

      <div class="flex-1 overflow-y-auto p-4 space-y-3">
        <div v-if="cart.length === 0" class="h-full flex flex-col items-center justify-center text-gray-400 opacity-50">
          <span class="text-4xl mb-2">🛒</span>
          <p>Order is empty</p>
        </div>

        <div 
          v-for="item in cart" 
          :key="item.id" 
          class="flex items-center bg-white p-3 rounded-lg border border-gray-100 shadow-sm"
        >
          <div class="flex flex-col items-center gap-1 mr-4">
            <button @click.stop="increaseQty(item)" class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-xs font-bold">+</button>
            <span class="text-sm font-bold w-6 text-center">{{ item.quantity }}</span>
            <button @click.stop="decreaseQty(item)" class="w-6 h-6 rounded bg-gray-100 hover:bg-gray-200 text-xs font-bold">-</button>
          </div>

          <div class="flex-1">
            <h4 class="text-sm font-bold text-gray-800">{{ item.name }}</h4>
            <div class="text-xs text-gray-500">${{ formatPrice(item.price) }} each</div>
          </div>

          <div class="font-bold text-gray-800">
            ${{ formatPrice(item.price * item.quantity) }}
          </div>
        </div>
      </div>

      <div class="p-6 bg-gray-50 border-t border-gray-200">
        <div class="flex justify-between mb-2 text-sm text-gray-500">
          <span>Subtotal</span>
          <span>${{ formatPrice(cartTotal) }}</span>
        </div>
        <div class="flex justify-between mb-6 text-xl font-extrabold text-gray-800">
          <span>Total</span>
          <span>${{ formatPrice(cartTotal) }}</span>
        </div>

        <button 
          @click="checkout"
          :disabled="cart.length === 0"
          class="w-full py-4 rounded-xl font-bold text-white shadow-lg transition-all"
          :class="cart.length === 0 ? 'bg-gray-300 cursor-not-allowed' : 'bg-red-600 hover:bg-red-700 hover:shadow-red-200'"
        >
          Charge ${{ formatPrice(cartTotal) }}
        </button>
      </div>
    </div>

  </div>
</template>