<?php
namespace Tests\Feature;

use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_transaksi_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/transaksi')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/transaksi/create')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_show_transaksi()
    {
        $user = User::factory()->create();
        $pel = Pelanggan::create(['nama_pelanggan' => 'Pak Joni']);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-100', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 25000, 'status' => 'tunai',
        ]);
        $this->actingAs($user)->get("/transaksi/{$t->id}")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_transaksi()
    {
        $user = User::factory()->create();
        $pel = Pelanggan::create(['nama_pelanggan' => 'Bu Lia']);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-101', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 30000, 'status' => 'tunai',
        ]);
        $this->actingAs($user)->delete("/transaksi/{$t->id}");
        $this->assertDatabaseMissing('transaksis', ['id' => $t->id]);
    }
}
