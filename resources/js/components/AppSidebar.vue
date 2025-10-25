<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue'
import NavMain from '@/components/NavMain.vue'
import NavUser from '@/components/NavUser.vue'
import {
  Sidebar,
  SidebarContent,
  SidebarFooter,
  SidebarHeader,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem,
} from '@/components/ui/sidebar'
import { dashboard } from '@/routes'
import { route } from 'ziggy-js'
import { type NavItem } from '@/types'
import { Link, usePage } from '@inertiajs/vue3'
import { FileChartColumnIncreasing, Layers, LayoutGrid, Trophy } from 'lucide-vue-next'
import AppLogo from './AppLogo.vue'
import { computed } from 'vue'

// ✅ Get logged-in user info from Inertia
const page = usePage()
const userRoles = computed<string[]>(() => page.props.auth?.user?.roles || [])

// ✅ ADMIN NAVIGATION (retained from your code)
const adminNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
  },
  {
    title: 'Program',
    href: dashboard(),
    icon: Layers,
    children: [
      { title: 'SETUP', href: route('projects.index', { program: 1 }) },
      { title: 'LGIA', href: route('projects.index', { program: 2 }) },
      { title: 'SSCP', href: route('projects.index', { program: 3 }) },
      { title: 'CEST', href: route('projects.index', { program: 4 }) },
    ],
  },
  {
    title: 'Accomplishment',
    href: dashboard(),
    icon: Trophy,
    children: [
        { title: 'Financial', href: route('financial.index') },
        { title: 'Physical', href: route('projects.index', { program: 2 }) },
    ],
  },
  {
    title: 'Reports',
    href: dashboard(),
    icon: FileChartColumnIncreasing,
    children: [
      { title: 'Annual', href: '/projects/active' },
      { title: 'Quarterly', href: '/projects/completed' },
      { title: 'Semestral', href: '/projects' },
    ],
  },
]

// ✅ USER NAVIGATION
const userNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: route('user'),
    icon: LayoutGrid,
  },
//   {
//     title: 'Reports',
//     href: route('reports.index'),
//     icon: FileChartColumnIncreasing,
//   },
//   {
//     title: 'Documents',
//     href: route('documents.index'),
//     icon: Layers,
//   },
]

// ✅ GUEST NAVIGATION
const guestNavItems: NavItem[] = [
  {
    title: 'Home',
    href: route('guest'),
    icon: LayoutGrid,
  },
//   {
//     title: 'Announcements',
//     href: route('announcements.index'),
//     icon: Trophy,
//   },
//   {
//     title: 'Contact',
//     href: route('contact.index'),
//     icon: FileChartColumnIncreasing,
//   },
]

// ✅ Choose nav based on role
const mainNavItems = computed<NavItem[]>(() => {
  if (userRoles.value.includes('Admin')) return adminNavItems
  if (userRoles.value.includes('User')) return userNavItems
  if (userRoles.value.includes('Guest')) return guestNavItems
  return [] // fallback (no role)
})

const footerNavItems: NavItem[] = []
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <!-- Header / Logo -->
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="dashboard()">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <!-- Role-based sidebar -->
    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <!-- Footer -->
    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>

  <!-- Page slot -->
  <slot />
</template>
