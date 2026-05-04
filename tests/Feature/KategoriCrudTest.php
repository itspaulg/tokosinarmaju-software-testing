<?php
namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_kategori_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/kategoris')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/kategoris/create')->assertStatus(200);
    }

    public function test_authenticated_user_can_store_kategori()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/kategoris', ['nama_kategori' => 'Minuman']);
        $this->assertDatabaseHas('kategoris', ['nama_kategori' => 'Minuman']);
    }

    public function test_authenticated_user_can_view_edit_form()
    {
        $user = User::factory()->create();
        $k = Kategori::create(['nama_kategori' => 'Snack']);
        $this->actingAs($user)->get("/kategoris/{$k->id}/edit")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_kategori()
    {
        $user = User::factory()->create();
        $k = Kategori::create(['nama_kategori' => 'HapusMe']);
        $this->actingAs($user)->delete("/kategoris/{$k->id}");
        $this->assertDatabaseMissing('kategoris', ['id' => $k->id]);
    }
}
