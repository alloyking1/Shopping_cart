<script setup lang="ts">
import ProductCard from '@/components/products/ProductCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
}

interface Props {
    products: Product[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: '/products',
    },
];
</script>

<template>
    <Head title="Products" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">
            <div>
                <h1 class="text-2xl font-bold">Products</h1>
                <p class="text-muted-foreground">Browse our selection of products</p>
            </div>

            <div
                v-if="products.length > 0"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <ProductCard v-for="product in products" :key="product.id" :product="product" />
            </div>

            <div v-else class="text-center py-12">
                <p class="text-muted-foreground">No products available.</p>
            </div>
        </div>
    </AppLayout>
</template>

