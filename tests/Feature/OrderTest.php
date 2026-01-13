<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function test_authenticated_user_can_access_checkout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/orders');

        // Should fail with empty cart error
        $response->assertSessionHas('error');
    }

    public function test_guest_cannot_checkout(): void
    {
        $response = $this->post('/orders');

        $response->assertRedirect('/login');
    }
}
