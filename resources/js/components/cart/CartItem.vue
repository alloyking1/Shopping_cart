<script setup lang="ts">
import { Button } from '@/components/ui/button';
import InputError from '@/components/InputError.vue';
import { Input } from '@/components/ui/input';
import { router } from '@inertiajs/vue3';
import { Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';

interface Product {
    id: number;
    name: string;
    price: number;
    stock_quantity: number;
}

interface CartItem {
    id: number;
    quantity: number;
    product: Product;
}

interface Props {
    cartItem: CartItem;
}

const props = defineProps<Props>();

const quantity = ref(props.cartItem.quantity);
const processing = ref(false);
const errors = ref<Record<string, string>>({});

const updateQuantity = () => {
    if (processing.value || quantity.value === props.cartItem.quantity) return;
    if (quantity.value < 1 || quantity.value > props.cartItem.product.stock_quantity) {
        return;
    }

    processing.value = true;
    errors.value = {};

    router.put(
        `/cart/${props.cartItem.id}`,
        {
            quantity: quantity.value,
        },
        {
            preserveScroll: true,
            onError: (pageErrors) => {
                errors.value = pageErrors;
            },
            onFinish: () => {
                processing.value = false;
            },
        }
    );
};

const removeItem = () => {
    if (processing.value) return;

    processing.value = true;
    router.delete(`/cart/${props.cartItem.id}`, {
        preserveScroll: true,
        onFinish: () => {
            processing.value = false;
        },
    });
};

const itemTotal = props.cartItem.quantity * props.cartItem.product.price;
</script>

<template>
    <div class="flex items-center gap-4 border-b pb-4">
        <div class="flex-1">
            <h3 class="font-semibold">{{ cartItem.product.name }}</h3>
            <p class="text-sm text-muted-foreground">
                ${{ cartItem.product.price }} each
            </p>
            <!-- <p class="text-sm text-muted-foreground">
                ${{ cartItem.product.price.toFixed(2) }} each
            </p> -->
            <p class="text-xs text-muted-foreground mt-1">
                Stock: {{ cartItem.product.stock_quantity }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            <div class="flex flex-col gap-1">
                <Input
                    v-model.number="quantity"
                    type="number"
                    min="1"
                    :max="cartItem.product.stock_quantity"
                    @change="updateQuantity"
                    :disabled="processing"
                    class="w-20 h-9"
                />
                <InputError :message="errors.quantity" class="text-xs" />
            </div>

            <div class="w-24 text-right">
                <p class="font-semibold">${{ itemTotal.toFixed(2) }}</p>
            </div>

            <Button
                @click="removeItem"
                variant="ghost"
                size="icon"
                :disabled="processing"
                class="text-destructive hover:text-destructive"
            >
                <Trash2 class="h-4 w-4" />
            </Button>
        </div>
    </div>
</template>

