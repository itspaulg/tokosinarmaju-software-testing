<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class PelangganCrudTest extends TestCase {
    use RefreshDatabase;
    public function test_authenticated_user_can_view_pelanggan_list() {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/pelanggans')->assertStatus(200);
    }
}
