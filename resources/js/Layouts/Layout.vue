<template>
  <div class="flex min-h-screen bg-zinc-900">
    <!-- Sidebar Navigation -->
    <div class="h-screen bg-zinc-800 w-64 fixed flex flex-col border-r border-zinc-700 shadow-xl">
      <!-- User Profile Section -->
      <div class="p-6 border-b border-zinc-700">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center">
            <span class="text-white font-semibold">JD</span>
          </div>
          <div>
            <p class="text-white font-medium">John Doe</p>
            <p class="text-emerald-400 text-xs">Premium Banking</p>
          </div>
        </div>
      </div>

      <!-- Navigation Menu -->
      <div class="p-6 flex-1">
        <nav class="space-y-1">
          <Link
            v-for="(item, index) in navItems"
            :key="index"
            :href="item.route"
            class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200"
            :class="[
              $page.url.startsWith(item.route) 
                ? 'bg-zinc-700 text-white border-l-4 border-emerald-500 shadow-md' 
                : 'text-zinc-300 hover:bg-zinc-700 hover:border-l-4 hover:border-emerald-400/30 border-l-4 border-transparent'
            ]"
          >
            <component 
              :is="item.icon" 
              class="w-6 h-6 transition-transform duration-200"
              :class="{
                'text-emerald-400': $page.url.startsWith(item.route),
                'text-zinc-400 group-hover:text-emerald-400': !$page.url.startsWith(item.route)
              }"
            />
            <span class="text-sm font-medium flex-1">{{ item.name }}</span>
            <span v-if="item.notification" class="bg-rose-500 text-white px-2 py-1 rounded-full text-xs">
              {{ item.notification }}
            </span>
          </Link>
        </nav>
      </div>

      <!-- Security Section -->
      <div class="mt-auto p-4 border-t border-zinc-700 bg-zinc-800/30">
        <div class="flex items-center gap-2 text-emerald-400 text-sm">
          <ShieldCheckIcon class="w-5 h-5" />
          <span>Security Verified</span>
        </div>
        <p class="text-xs text-zinc-500 mt-2">Last login: 2 hours ago</p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 min-h-screen bg-zinc-900">
      <!-- Header -->
      <header class="bg-zinc-800 shadow-sm p-6 border-b border-zinc-700">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-zinc-100">Good Morning, John</h1>
            <p class="text-zinc-400 text-sm">Today is Friday, 12 January 2024</p>
          </div>
          <div class="flex items-center gap-4">
            <button class="p-2 hover:bg-zinc-700 rounded-full transition-colors">
              <BellIcon class="w-6 h-6 text-zinc-300" />
              <span class="sr-only">Notifications</span>
            </button>
            <button class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-2 rounded-lg flex items-center gap-2 transition-colors">
              <PlusIcon class="w-5 h-5" />
              New Transfer
            </button>
          </div>
        </div>
      </header>
      
      <!-- Page Content -->
      <div class="p-8 text-zinc-200">
        <slot />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { 
  HomeIcon,
  BanknotesIcon,
  ArrowsRightLeftIcon,
  CreditCardIcon,
  ChartBarIcon,
  ShieldCheckIcon,
  BellIcon,
  PlusIcon,
  BuildingLibraryIcon,
  LockClosedIcon
} from '@heroicons/vue/24/outline'

interface NavItem {
  name: string
  route: string
  icon: any
  notification?: number
}

const navItems: NavItem[] = [
  {
    name: 'Accounts Overview',
    route: '/dashboard',
    icon: HomeIcon
  },
  {
    name: 'Transactions',
    route: '/transactions',
    icon: ArrowsRightLeftIcon,
    notification: 3
  },
  {
    name: 'Funds Transfer',
    route: '/transfer',
    icon: BanknotesIcon
  },
  {
    name: 'Credit Cards',
    route: '/cards',
    icon: CreditCardIcon
  },
  {
    name: 'Loans & Mortgages',
    route: '/loans',
    icon: BuildingLibraryIcon
  },
  {
    name: 'Investments',
    route: '/investments',
    icon: ChartBarIcon
  },
  {
    name: 'Security Settings',
    route: '/security',
    icon: LockClosedIcon
  }
]
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
  @apply bg-zinc-900 text-zinc-200;
}

/* Scrollbar Styling */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  @apply bg-zinc-800;
}

::-webkit-scrollbar-thumb {
  @apply bg-zinc-600 rounded-full hover:bg-zinc-500;
}
</style>