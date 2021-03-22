<template>
	<nav class="bg-gray-800">
	  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
	    <div class="relative flex items-center justify-between h-16">
	      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
	        <!-- Mobile menu button-->
	        <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
	          <span class="sr-only">Open main menu</span>
	          <!--
	            Icon when menu is closed.

	            Heroicon name: outline/menu

	            Menu open: "hidden", Menu closed: "block"
	          -->
	          <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
	          </svg>
	          <!--
	            Icon when menu is open.

	            Heroicon name: outline/x

	            Menu open: "block", Menu closed: "hidden"
	          -->
	          <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
	            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
	          </svg>
	        </button>
	      </div>
	      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
	        <div class="hidden sm:block sm:ml-6">
	          <div class="flex space-x-4">
	            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
	            <router-link :to="{ name: 'home' }" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Home</router-link>
	            <a href="#" ref="boardsMenu" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium" id="boards-menu" aria-expanded="false" aria-haspopup="true" @click="isOpen = !isOpen">Boards</a>

	            <!-- Boards dropdown -->
		        <div class="ml-3 relative z-10">
		          <transition 
		          	enter-active-class="transition ease-out duration-100" 
		          	leave-active-class="transition ease-in duration-75" 
		          	enter-from-class="transition ease-out duration-100" 
		          	enter-to-class="transform opacity-100 scale-100" 
		          	leave-from-class="transform opacity-100 scale-100" 
		          	leave-to-class="transform opacity-0 scale-95"
		          	>
			          <div class="origin-top-right absolute right-0 mt-10 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="boards-menu" v-if="isOpen">
			            <router-link v-for="board in boards" v-bind:key="board.href" :to="board.href" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">/{{ board.href }}/ {{ board.name }}</router-link>
			          </div>
			      </transition>
		        </div>
	          </div>
	        </div>
	      </div>
	      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

	        
	      </div>
	    </div>
	  </div>

	  <!-- Mobile menu, show/hide based on menu state. -->
	  <div class="sm:hidden" id="mobile-menu">
	    <div class="px-2 pt-2 pb-3 space-y-1">
	      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
	      <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
	      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>
	      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>
	      <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
	    </div>
	  </div>
	</nav>
</template>

<script>
import { mixin as VueClickAway } from 'vue3-click-away'

export default {
	name: 'Navbar',
	mixins: [VueClickAway],
	data: function () {
		return {
			'isOpen': false,
			'boards': [
				{"href": "#", "name": "Loading..."}
			],
		}
	},
	methods: {
		documentClick (e) {
			let el = this.$refs.boardsMenu;
			let target = e.target;
			if (( el !== target) && !el.contains(target)) {
				this.isOpen = false;
			}
		}
	},
	mounted() {
		var that = this;

		this.axios.get('/api/boards').then((response) => {
			that.boards = response.data;
		});
	},
	created() {
		document.addEventListener('click', this.documentClick);
	},
	destroyed() {
		document.removeEventListener('click', this.documentClick);
	}
}
</script>