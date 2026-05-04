<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class SupplierCrudTest extends TestCase {
    use RefreshDatabase;
    public function test_authenticated_user_can_view_supplier_list() {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/suppliers')->assertStatus(200);
    }
}
