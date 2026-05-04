<?php
namespace Tests\Feature;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarangCrudTest extends TestCase
{
    use RefreshDatabase;

    private function seedDeps(): array
    {
        $sup = Supplier::create(['nama_supplier' => 'PT Maju', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'Makanan']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        return [$sup, $kat, $sat];
    }

    public function test_authenticated_user_can_view_barang_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/barangs')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/barangs/create')->assertStatus(200);
    }

    public function test_authenticated_user_can_store_barang()
    {
        $user = User::factory()->create();
        [$sup, $kat, $sat] = $this->seedDeps();

        $this->actingAs($user)->post('/barangs', [
            'nama_barang' => 'Indomie Goreng',
            'supplier_id' => $sup->id,
            'kategori_id' => $kat->id,
            'satuan_id' => $sat->id,
            'harga_beli' => 2500,
            'harga_grosir_1' => 2700,
            'harga_grosir_2' => 2800,
            'harga_grosir_3' => 2900,
            'harga_grosir_4' => 3000,
            'isi_stok' => 100,
        ]);

        $this->assertDatabaseHas('barangs', ['nama_barang' => 'Indomie Goreng']);
    }

    public function test_authenticated_user_can_view_show_barang()
    {
        $user = User::factory()->create();
        [$sup, $kat, $sat] = $this->seedDeps();
        $b = Barang::create([
            'nama_barang' => 'Item', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1100,
            'harga_grosir_2' => 1200, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1400,
            'isi_stok' => 50,
        ]);
        $this->actingAs($user)->get("/barangs/{$b->id}")->assertStatus(200);
    }

    public function test_authenticated_user_can_view_edit_form()
    {
        $user = User::factory()->create();
        [$sup, $kat, $sat] = $this->seedDeps();
        $b = Barang::create([
            'nama_barang' => 'Item Edit', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1100,
            'harga_grosir_2' => 1200, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1400,
            'isi_stok' => 50,
        ]);
        $this->actingAs($user)->get("/barangs/{$b->id}/edit")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_barang()
    {
        $user = User::factory()->create();
        [$sup, $kat, $sat] = $this->seedDeps();
        $b = Barang::create([
            'nama_barang' => 'Item Hapus', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1100,
            'harga_grosir_2' => 1200, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1400,
            'isi_stok' => 50,
        ]);
        $this->actingAs($user)->delete("/barangs/{$b->id}");
        $this->assertDatabaseMissing('barangs', ['id' => $b->id]);
    }
}
