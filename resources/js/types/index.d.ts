import { InertiaLinkProps } from '@inertiajs/vue3';
import type { LucideIcon } from 'lucide-vue-next';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon?: LucideIcon;
    isActive?: boolean;
    children?: NavItem[];
}

export type AppPageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    roles?: string[];
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

// Define the Program interface type
export interface Program {
  id: number
  program_name: string
  description: string
  slug: string
  type: string
}

export interface Project {
    program: any;
    id: number
    program_id: number
    user_id: number
    title: string
    description: string
    location: string
    status: string
    budget: number
    start_date: date
    end_date: date
    project_leader: string
    contact_email: string
    deleted_at?: string | null  // ✅ Added for soft deletes
    program?: any               // ✅ Optional relationship
}


export type BreadcrumbItemType = BreadcrumbItem;
