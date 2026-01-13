<?php

namespace Tests\Feature;

use App\Models\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_products_page_is_accessible(): void
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertInertia(fn($page) => $page->component('Products/Index'));
    }
}
