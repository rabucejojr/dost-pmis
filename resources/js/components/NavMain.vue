<script setup lang="ts">
import {
    SidebarGroup,
    SidebarGroupLabel,
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
const openDropdown = ref<string | null>(null)

const toggleDropdown = (title: string) => {
    openDropdown.value = openDropdown.value === title ? null : title
}
</script>

<template>
    <SidebarGroup class="px-2 py-0">
        <SidebarGroupLabel>Platform</SidebarGroupLabel>

        <SidebarMenu>
            <template v-for="item in items" :key="item.title">
                <!-- If item has children (dropdown) -->
                <SidebarMenuItem v-if="item.children">
                    <button
                        @click="toggleDropdown(item.title)"
                        class="flex items-center w-full gap-2 px-3 py-2 rounded-md text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                    >
                        <component :is="item.icon" class="w-4 h-4" />
                        <span class="flex-1 text-left">{{ item.title }}</span>
                        <component
                            :is="openDropdown === item.title ? ChevronDown : ChevronRight"
                            class="w-4 h-4"
                        />
                    </button>

                    <!-- Dropdown children -->
                    <transition name="fade">
                        <div
                            v-if="openDropdown === item.title"
                            class="ml-6 mt-1 border-l border-gray-200 dark:border-gray-700 pl-3 space-y-1"
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
                                        class="flex items-center gap-2 px-2 py-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition"
                                    >
                                        <span>{{ child.title }}</span>
                                    </Link>
                                </SidebarMenuButton>
                            </SidebarMenuItem>
                        </div>
                    </transition>
                </SidebarMenuItem>

                <!-- Regular nav item -->
                <SidebarMenuItem v-else>
                    <SidebarMenuButton
                        as-child
                        :is-active="urlIsActive(item.href, page.url)"
                        :tooltip="item.title"
                    >
                        <Link :href="item.href" class="flex items-center gap-2">
                            <component :is="item.icon" class="w-4 h-4" />
                            <span>{{ item.title }}</span>
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
