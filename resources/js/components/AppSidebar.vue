<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { route } from 'ziggy-js';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { FileChartColumnIncreasing, Layers, LayoutGrid, Trophy } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
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
            { title: 'Financial', href: route('projects.index', { program: 1 }) },
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

];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Github Repo',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: Folder,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
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

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
