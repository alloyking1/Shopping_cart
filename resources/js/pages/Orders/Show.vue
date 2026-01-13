<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

interface Product {
    id: number;
    name: string;
}

interface OrderItem {
    id: number;
    quantity: number;
    price_at_purchase: number;
    product: Product;
}

interface Order {
    id: number;
    total_amount: number;
    created_at: string;
    order_items: OrderItem[];
}

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Orders', href: '/orders' },
    { title: `Order #${props.order.id}`, href: `/orders/${props.order.id}` },
];
</script>

<template>

    <Head title="Order Confirmation" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4 space-y-6">
            <div>
                <h1 class="text-2xl font-bold">Order Confirmation</h1>
                <p class="text-muted-foreground">Thank you for your purchase.</p>
            </div>

            <div class="space-y-4">
                <div class="border rounded-md p-4">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-muted-foreground">Order ID</p>
                            <p class="font-medium">#{{ props.order.id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-muted-foreground">Placed</p>
                            <p class="font-medium">{{ props.order.created_at }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-muted-foreground">Total</p>
                            <p class="font-bold text-lg">${{ props.order.total_amount }}</p>
                            <!-- <p class="font-bold text-lg">${{ props.order.total_amount.toFixed(2) }}</p> -->
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div v-for="item in props.order.order_items" :key="item.id" class="flex justify-between">
                            <div>
                                <div class="font-medium">{{ item.product.name }}</div>
                                <div class="text-sm text-muted-foreground">${{ item.price_at_purchase }} each
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">x{{ item.quantity }}</div>
                                <div class="text-sm text-muted-foreground">
                                    ${{ (item.quantity * item.price_at_purchase) }}
                                </div>
                                <!-- <div class="text-sm text-muted-foreground">
                                    ${{ (item.quantity * item.price_at_purchase).toFixed(2) }}
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <Link href="/products" as="button">
                        <Button variant="outline">Continue Shopping</Button>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
