<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// --- STATE ---
const menuItems = ref([]);
const cart = ref([]);
const orders = ref([]); 
const loading = ref(true);
const currentView = ref('menu'); 
const showCartModal = ref(false); 
const expandedOrderId = ref(null); 

// --- FETCH DATA ---
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

const switchView = async (view) => {
  currentView.value = view;
  showCartModal.value = false;
  
  if (view === 'orders') {
    loading.value = true;
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/orders');
      orders.value = response.data;
    } catch (error) {
      console.error(error);
    } finally {
      loading.value = false;
    }
  } else if (view === 'menu' && menuItems.value.length === 0) {
    await fetchMenu();
  }
};

// --- LOGIC ---
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
  if (item.quantity > 1) item.quantity--;
  else cart.value = cart.value.filter(i => i.id !== item.id);
};

const toggleOrderDetails = (id) => {
  expandedOrderId.value = expandedOrderId.value === id ? null : id;
};

const cartTotal = computed(() => cart.value.reduce((total, item) => total + (item.price * item.quantity), 0));
const cartItemCount = computed(() => cart.value.reduce((total, item) => total + item.quantity, 0));
const formatPrice = (price) => parseFloat(price).toFixed(2);

const checkout = async () => {
  if (cart.value.length === 0) return;
  if (!confirm(`Confirm charge of $${formatPrice(cartTotal.value)}?`)) return;

  try {
    await axios.post('http://127.0.0.1:8000/api/orders', { cart: cart.value, total: cartTotal.value });
    alert('Order successfully saved!');
    cart.value = []; 
    showCartModal.value = false; 
    if(currentView.value === 'orders') switchView('orders'); 
  } catch (error) {
    alert('Failed to save order.');
  }
};
</script>

<template>
  <div class="flex bg-gray-100 font-sans min-h-screen">
    
    <aside class="fixed inset-y-0 left-0 z-30 w-20 lg:w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300">
      <div class="h-16 flex items-center justify-center lg:justify-start lg:px-6 border-b border-gray-100 flex-shrink-0">
        <h1 class="text-xl font-extrabold text-red-600 tracking-tight hidden lg:block">Restau POS</h1>
        <span class="text-2xl lg:hidden">🍔</span>
      </div>
      <nav class="flex-1 p-2 space-y-2 overflow-y-auto">
        <a href="#" @click.prevent="switchView('menu')" class="flex items-center p-3 rounded-lg font-bold justify-center lg:justify-start transition" :class="currentView === 'menu' ? 'bg-red-50 text-red-600' : 'text-gray-400 hover:bg-gray-50'">
          <span class="text-xl">🍔</span><span class="ml-3 hidden lg:block">Menu</span>
        </a>
        <a href="#" @click.prevent="switchView('orders')" class="flex items-center p-3 rounded-lg font-bold justify-center lg:justify-start transition" :class="currentView === 'orders' ? 'bg-red-50 text-red-600' : 'text-gray-400 hover:bg-gray-50'">
          <span class="text-xl">🧾</span><span class="ml-3 hidden lg:block">Orders</span>
        </a>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col min-h-screen ml-20 lg:ml-64 transition-all duration-300 relative">
      
      <header class="fixed top-0 right-0 left-20 lg:left-64 h-16 bg-white border-b border-gray-200 flex items-center px-6 justify-between z-20 shadow-sm transition-all duration-300">
        <h2 class="text-lg font-bold text-gray-800">
          {{ currentView === 'menu' ? 'Select Items' : 'Transaction History' }}
        </h2>
        <div class="text-sm text-gray-500">Cashier: <span class="font-bold text-gray-800">Admin</span></div>
      </header>

      <main class="flex-1 p-6 pt-24 pb-24">
        
        <div v-if="loading" class="flex h-64 items-center justify-center text-gray-400">Loading...</div>

        <Transition name="fade" mode="out-in">
          
          <div v-if="!loading && currentView === 'menu'" class="max-w-7xl mx-auto w-full">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 w-full">
              <div 
                v-for="item in menuItems" 
                :key="item.id" 
                class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 flex flex-col hover:shadow-md transition duration-300"
              >
                <div class="h-40 w-full mb-3 overflow-hidden rounded-lg bg-white flex items-center justify-center">
                  <img v-if="item.image" :src="item.image" :alt="item.name" class="h-full w-full object-contain" />
                  <div v-else class="text-4xl">🍽️</div>
                </div>
                
                <div class="mt-auto">
                  <h3 class="font-bold text-gray-800 text-lg leading-tight mb-2">{{ item.name }}</h3>
                  <div class="flex items-center justify-between">
                    <span class="font-bold text-gray-900 text-lg">${{ formatPrice(item.price) }}</span>
                    <button 
                      @click="addToCart(item)"
                      class="w-8 h-8 rounded-full bg-red-600 text-white font-bold text-lg flex items-center justify-center hover:bg-red-700 hover:scale-110 active:scale-95 transition-all shadow-md"
                    >
                      +
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div v-else-if="!loading && currentView === 'orders'" class="max-w-4xl mx-auto w-full space-y-4">
            <div v-if="orders.length === 0" class="text-center text-gray-400 py-10">No orders found.</div>
              
            <div 
              v-for="order in orders" 
              :key="order.id" 
              class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden w-full"
            >
              <div 
                @click="toggleOrderDetails(order.id)"
                class="p-4 flex justify-between items-center cursor-pointer hover:bg-gray-50 transition select-none"
              >
                <div class="flex items-center gap-4">
                  <div class="bg-red-50 text-red-600 w-10 h-10 rounded-full flex items-center justify-center font-bold">
                    #{{ order.id }}
                  </div>
                  <div>
                    <div class="font-bold text-gray-800">Sale - {{ new Date(order.created_at).toLocaleTimeString() }}</div>
                    <div class="text-xs text-gray-500">{{ new Date(order.created_at).toLocaleDateString() }} • {{ order.items.length }} Items</div>
                  </div>
                </div>
                <div class="flex items-center gap-4">
                  <div class="font-bold text-xl text-gray-800">${{ formatPrice(order.total_amount) }}</div>
                  <span class="text-gray-400 text-sm transform transition-transform" :class="expandedOrderId === order.id ? 'rotate-180' : ''">▼</span>
                </div>
              </div>

              <div v-if="expandedOrderId === order.id" class="bg-gray-50 p-4 border-t border-gray-100">
                <table class="w-full text-sm">
                  <tr v-for="item in order.items" :key="item.id" class="border-b border-gray-200 last:border-0">
                    <td class="py-2 text-gray-600">{{ item.name }}</td>
                    <td class="py-2 text-center text-gray-500">x{{ item.quantity }}</td>
                    <td class="py-2 text-right font-bold text-gray-800">${{ formatPrice(item.price_at_order * item.quantity) }}</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>

        </Transition>
      </main>

      <div v-if="cart.length > 0 && currentView === 'menu'" class="fixed bottom-6 right-6 z-40">
        <button 
          @click="showCartModal = true"
          class="bg-red-600 hover:bg-red-700 text-white shadow-xl rounded-full px-8 py-4 flex items-center gap-4 transition transform hover:scale-105"
        >
          <span class="font-bold text-xl">View Order</span>
          <span class="bg-white text-red-600 px-3 py-1 rounded-full font-bold text-sm">{{ cartItemCount }}</span>
          <span class="font-mono font-bold text-lg border-l border-red-500 pl-4 ml-2">${{ formatPrice(cartTotal) }}</span>
        </button>
      </div>
    </div>

    <div v-if="showCartModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm p-4">
      <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md flex flex-col max-h-[90vh]">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
          <h2 class="text-2xl font-bold text-gray-800">Current Order</h2>
          <button @click="showCartModal = false" class="p-2 hover:bg-gray-100 rounded-full text-gray-500">✕</button>
        </div>
        <div class="flex-1 overflow-y-auto p-6 space-y-4">
          <div v-for="item in cart" :key="item.id" class="flex items-center justify-between">
            <div class="flex items-center gap-4">
              <div class="flex items-center border rounded-lg">
                <button @click="decreaseQty(item)" class="px-3 py-1 hover:bg-gray-100 text-gray-600">-</button>
                <span class="w-8 text-center font-bold">{{ item.quantity }}</span>
                <button @click="increaseQty(item)" class="px-3 py-1 hover:bg-gray-100 text-gray-600">+</button>
              </div>
              <div>
                <div class="font-bold text-gray-800">{{ item.name }}</div>
                <div class="text-xs text-gray-500">${{ formatPrice(item.price) }}</div>
              </div>
            </div>
            <div class="font-bold text-gray-800">${{ formatPrice(item.price * item.quantity) }}</div>
          </div>
        </div>
        <div class="p-6 bg-gray-50 rounded-b-2xl">
          <div class="flex justify-between mb-6 text-2xl font-extrabold text-gray-800">
            <span>Total</span>
            <span>${{ formatPrice(cartTotal) }}</span>
          </div>
          <button @click="checkout" class="w-full bg-red-600 hover:bg-red-700 text-white py-4 rounded-xl font-bold text-lg shadow-lg transition">
            Charge ${{ formatPrice(cartTotal) }}
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>