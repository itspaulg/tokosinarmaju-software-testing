<?php
namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PelangganCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_pelanggan_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/pelanggans')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/pelanggans/create')->assertStatus(200);
    }


    public function test_authenticated_user_can_view_edit_form()
    {
        $user = User::factory()->create();
        $p = Pelanggan::create(['nama_pelanggan' => 'Bu Sari']);
        $this->actingAs($user)->get("/pelanggans/{$p->id}/edit")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_pelanggan()
    {
        $user = User::factory()->create();
        $p = Pelanggan::create(['nama_pelanggan' => 'Pak Hapus']);
        $this->actingAs($user)->delete("/pelanggans/{$p->id}");
        $this->assertDatabaseMissing('pelanggans', ['id' => $p->id]);
    }
}
