<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
    ClipboardCheck,
    FileText,
    Plus,
    Pencil,
    Trash2
} from 'lucide-vue-next'
import { can } from '@/lib/can'
import { type BreadcrumbItem } from '@/types'

interface Category {
    id: number
    title: string
    description: string | null
}


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ប្រភេទ',
        href: '/categories',
    },
]

defineProps<{
    categories: Category[]
}>()

function deleteCategory(id) {
    if (confirm("តើអ្នកនិងលុបប្រភេទ")) {
        router.delete(route('categories.destroy', id));
    }
}

</script>




<template>

    <Head title="ប្រភេទ" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">

            <!-- Create Button -->
            <Link 
            v-if="can('category.create')"
            :href="route('categories.create')" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold
                       text-white bg-blue-600 rounded-md hover:bg-blue-700 transition">
                <Plus class="w-4 h-4" />
                បង្កើត​ ប្រភេទថ្មី
            </Link>

            <!-- Table -->
            <table class="w-full mt-3 text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">លរ</th>
                        <th class="px-6 py-3">ឈ្មោះ</th>
                        <th class="px-6 py-3">ការរៀបរាប់</th>
                        <th class="px-6 py-3 text-center">សកម្មភាព</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(category, index) in categories" :key="category.id"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-900">

                        <td class="px-6 py-2 dark:text-gray-300">{{ index + 1 }}</td>
                        <td class="px-6 py-2 dark:text-gray-300">{{ category.title }}</td>
                        <td class="px-6 py-2 dark:text-gray-300">{{ category.description }}</td>


                        <td class="px-6 py-2">

                            <Link :href="route('categories.show', category.id)"
                                class="cursor-pointer px-3 py-2 text-xs mr-2 font-medium text-white bg-gray-700 rounded">
                                បង្ហាញ
                            </Link>

                            <Link :href="route('categories.edit', category.id)"
                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-500 rounded">
                                កែរ
                            </Link>
                            <button @click="deleteCategory(category.id)"
                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-500 rounded ml-2">
                                លុប
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
