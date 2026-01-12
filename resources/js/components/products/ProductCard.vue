<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { router } from '@inertiajs/vue3';
import { ShoppingCart } from 'lucide-vue-next';
import { ref } from 'vue';

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
}

interface Props {
    product: Product;
}

const props = defineProps<Props>();

const quantity = ref(1);
const processing = ref(false);

const addToCart = () => {
    if (processing.value) return;
    
    processing.value = true;
    router.post(
        '/cart',
        {
            product_id: props.product.id,
            quantity: quantity.value,
        },
        {
            preserveScroll: true,
            onFinish: () => {
                processing.value = false;
            },
        }
    );
};
</script>

<template>
    <Card class="flex flex-col">
        <CardHeader>
            <CardTitle class="text-lg">{{ product.name }}</CardTitle>
        </CardHeader>
        <CardContent class="flex-1">
            <div class="space-y-2">
                <!-- <p class="text-2xl font-bold">${{ product.price.toFixed(2) }}</p> -->
                <p class="text-2xl font-bold">${{ product.price }}</p>
                <p class="text-sm text-muted-foreground">
                    Stock: {{ product.stock_quantity }}
                </p>
            </div>
        </CardContent>
        <CardFooter class="flex flex-col gap-2">
            <div v-if="product.stock_quantity > 0" class="flex items-center gap-2 w-full">
                <input
                    v-model.number="quantity"
                    type="number"
                    min="1"
                    :max="product.stock_quantity"
                    class="w-20 h-9 rounded-md border border-input bg-transparent px-3 py-1 text-sm"
                />
                <Button
                    @click="addToCart"
                    :disabled="processing || quantity < 1 || quantity > product.stock_quantity"
                    class="flex-1"
                >
                    <ShoppingCart class="h-4 w-4 mr-2" />
                    Add to Cart
                </Button>
            </div>
            <p v-else class="text-sm text-destructive font-medium w-full text-center">
                Out of Stock
            </p>
        </CardFooter>
    </Card>
</template>

