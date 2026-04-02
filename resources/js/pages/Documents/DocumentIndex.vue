<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'
import {
    FileText,
    Plus,
    Pencil,
    Trash2
} from 'lucide-vue-next'
import { type BreadcrumbItem } from '@/types'
import { ref, computed } from 'vue'
import { can } from '@/lib/can'

interface Document {
    id: number
    doc_name: string
    doc_title: string
    description: string | null
    doc_upload: string
    category_id: number
}

// Breadcrumb
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'ឯកសារ',
        href: '/documents',
    },
]

// Props from backend
const props = defineProps<{
    documents: Document[],
    categories: { id: number, title: string }[]
}>()

// ✅ Category filter state
const selectedCategory = ref<number | null>(null)

// ✅ Filter logic
const filteredDocuments = computed(() => {
    if (!selectedCategory.value) return props.documents

    return props.documents.filter(doc =>
        doc.category_id === selectedCategory.value
    )
})

// Delete function
function deleteDocument(id: number) {
    if (confirm("Are you want to delete this Final Slide")) {
        router.delete(route('documents.destroy', id));
    }
}
</script>

<template>
    <Head title="ឯកសារ" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto p-3">

            <!-- Create Button -->
            <Link
                v-if="can('document.create')"
                :href="route('documents.create')"
                class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-white bg-blue-600 rounded-md hover:bg-blue-700 transition"
            >
                <Plus class="w-4 h-4" />
                បង្កើត​ ឯកសារ
            </Link>

            <!-- ✅ Category Row -->
            <div class="flex flex-wrap gap-2 mt-4 mb-3">

                <!-- All -->
                <button
                    @click="selectedCategory = null"
                    :class="[
                        'px-4 py-1 text-xs font-medium rounded transition',
                        selectedCategory === null
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white'
                    ]"
                >
                    All
                </button>

                <!-- Categories -->
                <button
                    v-for="cat in props.categories"
                    :key="cat.id"
                    @click="selectedCategory = cat.id"
                    :class="[
                        'px-4 py-1 text-xs font-medium rounded transition',
                        selectedCategory === cat.id
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white'
                    ]"
                >
                    {{ cat.title }}
                </button>

            </div>

            <!-- Table -->
            <table class="w-full mt-3 text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3">លរ</th>
                        <th class="px-6 py-3">ឈ្មោះ​ ឯកសារ</th>
                        <th class="px-6 py-3">ចំណងជើង</th>
                        <th class="px-6 py-3">File</th>
                        <th class="px-6 py-3">រៀបរាប់</th>
                        <th class="px-6 py-3 text-center">សកម្មភាព</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="(document, index) in filteredDocuments"
                        :key="document.id"
                        class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-900 dark:even:bg-gray-800"
                    >
                        <td class="px-6 py-2">
                            {{ index + 1 }}
                        </td>

                        <td class="px-6 py-2">
                            {{ document.doc_name }}
                        </td>

                        <td class="px-6 py-2">
                            {{ document.doc_title }}
                        </td>

                        <!-- ✅ File -->
                        <td class="px-6 py-2">
                            <a
                                :href="`/storage/${document.doc_upload}`"
                                target="_blank"
                                class="text-blue-600 hover:underline"
                            >
                                View
                            </a>
                        </td>

                        <!-- ✅ Description -->
                        <td class="px-6 py-2">
                            {{ document.description }}
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-2">
                            <div class="flex justify-center gap-2">

                                <Link
                                    :href="route('documents.show', document.id)"
                                    class="p-2 bg-gray-800 rounded hover:bg-gray-700"
                                >
                                    <FileText class="w-4 h-4 text-white" />
                                </Link>

                                <Link
                                    :href="route('documents.edit', document.id)"
                                    class="p-2 bg-blue-500 rounded hover:bg-blue-900"
                                >
                                    <Pencil class="w-4 h-4 text-white" />
                                </Link>

                                <button
                                    @click="deleteDocument(document.id)"
                                    class="p-2 bg-red-500 rounded hover:bg-red-700"
                                >
                                    <Trash2 class="w-4 h-4 text-white" />
                                </button>

                            </div>
                        </td>
                    </tr>

                    <!-- Empty state -->
                    <tr v-if="filteredDocuments.length === 0">
                        <td colspan="6" class="text-center py-4 text-gray-400">
                            No documents found
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </AppLayout>
</template>