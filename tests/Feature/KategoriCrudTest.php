<?php
namespace Tests\Feature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class KategoriCrudTest extends TestCase {
    use RefreshDatabase;
    public function test_authenticated_user_can_view_kategori_list() {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/kategoris')->assertStatus(200);
    }
    public function test_authenticated_user_can_store_kategori() {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/kategoris', ['nama_kategori' => 'Minuman']);
        $this->assertDatabaseHas('kategoris', ['nama_kategori' => 'Minuman']);
    }
}
