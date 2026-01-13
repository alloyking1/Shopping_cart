<script setup lang="ts">
import CartItem from '@/components/cart/CartItem.vue';
import { Button } from '@/components/ui/button';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
}

interface CartItemType {
    id: number;
    quantity: number;
    product: Product;
}

interface Props {
    cartItems: CartItemType[];
    total: number;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Cart',
        href: '/cart',
    },
];

const checkout = () => {
    router.post('/orders', {}, { preserveScroll: false });
};
</script>

<template>

    <Head title="Shopping Cart" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">
            <div>
                <h1 class="text-2xl font-bold">Shopping Cart</h1>
                <p class="text-muted-foreground">Review your items</p>
            </div>

            <div v-if="cartItems.length > 0" class="space-y-6">
                <div class="space-y-4">
                    <CartItem v-for="item in cartItems" :key="item.id" :cart-item="item" />
                </div>

                <div class="border-t pt-4 space-y-4">
                    <div class="flex justify-between items-center text-lg">
                        <span class="font-semibold">Total:</span>
                        <span class="font-bold text-2xl">${{ total.toFixed(2) }}</span>
                    </div>

                    <div class="flex gap-4">
                        <Link href="/products" as="button">
                            <Button variant="outline">Continue Shopping</Button>
                        </Link>
                        <Button class="flex-1" @click="checkout">Checkout</Button>
                    </div>
                </div>
            </div>

            <div v-else class="text-center py-12 space-y-4">
                <p class="text-muted-foreground text-lg">Your cart is empty.</p>
                <Link href="/products" as="button">
                    <Button>Browse Products</Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
