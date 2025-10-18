<script setup lang="ts">
import {
    SidebarGroup,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar'
import { urlIsActive } from '@/lib/utils'
import { type NavItem } from '@/types'
import { Link, usePage } from '@inertiajs/vue3'
import { ChevronRight, ChevronDown } from 'lucide-vue-next'
import { ref } from 'vue'

defineProps<{
    items: NavItem[]
}>()

const page = usePage()
const openDropdown = ref<string | null>(localStorage.getItem('openDropdown') || null)

const toggleDropdown = (title: string) => {
  openDropdown.value = openDropdown.value === title ? null : title
  localStorage.setItem('openDropdown', openDropdown.value || '')
}

</script>

<template>
    <SidebarGroup class="px-2 py-0">

        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                <!-- DROPDOWN ITEM -->
                <SidebarMenuItem v-if="item.children">
                    <SidebarMenuButton
                        as="button"
                        class="flex items-center justify-between w-full px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        @click="toggleDropdown(item.title)"
                    >
                        <div class="flex items-center gap-2">
                            <!-- ✅ Icon always visible -->
                            <component
                                v-if="item.icon"
                                :is="item.icon"
                                class="h-4 w-4 shrink-0"
                            />
                            <span class="truncate text-sm">
                                {{ item.title }}
                            </span>
                        </div>

                        <component
                            :is="openDropdown === item.title ? ChevronDown : ChevronRight"
                            class="h-4 w-4 transition-transform duration-200"
                        />
                    </SidebarMenuButton>

                    <!-- CHILDREN -->
                    <transition name="fade">
                        <div
                            v-if="openDropdown === item.title"
                            class="ml-6 mt-1 pl-3 border-l border-gray-200 dark:border-gray-700 space-y-1"
                        >
                            <SidebarMenuItem
                                v-for="child in item.children"
                                :key="child.title"
                            >
                                <SidebarMenuButton
                                    as-child
                                    :is-active="urlIsActive(child.href, page.url)"
                                    :tooltip="child.title"
                                >
                                    <Link
                                        :href="child.href"
                                        class="flex items-center gap-2 px-2 py-1.5 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                                    >
                                        <span>{{ child.title }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </div>
                    </transition>
                </SidebarMenuItem>

                <!-- REGULAR ITEM -->
                <SidebarMenuItem v-else>
                    <SidebarMenuButton
                        as-child
                        :is-active="urlIsActive(item.href, page.url)"
                        :tooltip="item.title"
                    >
                        <Link
                            :href="item.href"
                            class="flex items-center gap-2 px-2 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                        >
                            <!-- ✅ Icon always visible -->
                            <component
                                v-if="item.icon"
                                :is="item.icon"
                                class="h-4 w-4 shrink-0"
                            />
                            <span class="truncate text-sm">
                                {{ item.title }}
                            </span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-4px);
}
</style>
