<?php
namespace Tests\Feature;

use App\Models\Pembelian;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PembelianCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_pembelian_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/pembelian')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/pembelian/create')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_show_pembelian()
    {
        $user = User::factory()->create();
        $sup = Supplier::create(['nama_supplier' => 'PT X', 'tipe_supplier' => 'baru']);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-100', 'tanggal' => '2025-05-01', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 50000, 'bayar' => 50000,
        ]);
        $this->actingAs($user)->get("/pembelian/{$p->id}")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_pembelian()
    {
        $user = User::factory()->create();
        $sup = Supplier::create(['nama_supplier' => 'PT Y', 'tipe_supplier' => 'baru']);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-101', 'tanggal' => '2025-05-01', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 75000, 'bayar' => 75000,
        ]);
        $this->actingAs($user)->delete("/pembelian/{$p->id}");
        $this->assertDatabaseMissing('pembelians', ['id' => $p->id]);
    }
}
