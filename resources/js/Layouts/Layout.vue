<template>
  <div class="flex min-h-screen bg-gradient-to-br from-zinc-900 via-zinc-900/95 to-zinc-900">
    <!-- Sidebar Navigation -->
    <div class="h-screen bg-gradient-to-b from-zinc-800 to-zinc-900 w-64 fixed flex flex-col border-r border-zinc-700/50 shadow-2xl">
      <!-- User Profile Section -->
      <div class="p-6 border-b border-zinc-700/50 bg-zinc-800/30 backdrop-blur-sm">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center shadow-lg">
            <span class="text-white font-semibold tracking-wide">JD</span>
          </div>
          <div>
            <p class="text-white font-medium text-sm tracking-tight">John Doe</p>
            <p class="text-emerald-400/90 text-xs font-light mt-0.5">Premium Banking</p>
          </div>
        </div>
      </div>

      <!-- Navigation Menu -->
      <div class="p-6 flex-1">
        <nav class="space-y-2">
          <Link
            v-for="(item, index) in navItems"
            :key="index"
            :href="item.route"
            class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-300 ease-out"
            :class="[
              $page.url.startsWith(item.route) 
                ? 'bg-gradient-to-r from-zinc-700/60 to-zinc-700/30 text-white border-l-4 border-emerald-400 shadow-lg' 
                : 'text-zinc-300 hover:bg-zinc-700/40 hover:border-l-4 hover:border-emerald-400/20 border-l-4 border-transparent'
            ]"
          >
            <component 
              :is="item.icon" 
              class="w-6 h-6 transition-all duration-300"
              :class="{
                'text-emerald-400 drop-shadow-sm': $page.url.startsWith(item.route),
                'text-zinc-400 group-hover:text-emerald-300/90': !$page.url.startsWith(item.route)
              }"
            />
            <span class="text-sm font-medium flex-1 tracking-tight">{{ item.name }}</span>
            <span 
              v-if="item.notification" 
              class="bg-rose-500/90 text-white px-2 py-1 rounded-full text-xs font-semibold shadow-sm animate-pulse"
            >
              {{ item.notification }}
            </span>
          </Link>
        </nav>
      </div>

      <!-- Security Section -->
      <div class="mt-auto p-4 border-t border-zinc-700/50 bg-zinc-800/40 backdrop-blur-sm">
        <div class="flex items-center gap-2 text-emerald-400/90 text-sm">
          <ShieldCheckIcon class="w-5 h-5 drop-shadow-sm" />
          <span class="font-light tracking-tight">Security Verified</span>
        </div>
        <p class="text-xs text-zinc-500/80 mt-2 font-light">Last login: 2 hours ago</p>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 min-h-screen bg-zinc-900/95 backdrop-blur">
      <!-- Header -->
      <header class="bg-zinc-800/60 shadow-sm p-6 border-b border-zinc-700/50 backdrop-blur">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-2xl font-bold text-zinc-100 tracking-tight">Good Morning, John</h1>
            <p class="text-zinc-400/90 text-sm font-light mt-1">Today is Friday, 12 January 2024</p>
          </div>
          <div class="flex items-center gap-4">
            <button class="p-2 hover:bg-zinc-700/40 rounded-full transition-all duration-300 group relative">
              <BellIcon class="w-6 h-6 text-zinc-300/90 group-hover:text-emerald-400 transition-colors" />
              <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-rose-500 rounded-full shadow-sm"></div>
              <span class="sr-only">Notifications</span>
            </button>
            <button class="bg-gradient-to-br from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 transition-all duration-300 shadow-lg hover:shadow-emerald-500/20">
              <PlusIcon class="w-5 h-5 text-white/90" />
              <span class="font-medium tracking-tight text-sm">New Transfer</span>
            </button>
          </div>
        </div>
      </header>
      
      <!-- Page Content -->
      <div class="p-8 text-zinc-200/95">
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