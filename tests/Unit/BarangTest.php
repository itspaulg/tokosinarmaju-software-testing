<?php
namespace Tests\Unit;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class BarangTest extends TestCase {
    use RefreshDatabase;
    private function makeBarang(): Barang {
        $sup = Supplier::create(['nama_supplier' => 'S1', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'K1']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        return Barang::create([
            'nama_barang' => 'Indomie', 'supplier_id' => $sup->id,
            'kategori_id' => $kat->id, 'satuan_id' => $sat->id,
            'harga_beli' => 2500, 'harga_grosir_1' => 2700, 'harga_grosir_2' => 2800,
            'harga_grosir_3' => 2900, 'harga_grosir_4' => 3000, 'isi_stok' => 100,
        ]);
    }
    public function test_barang_can_be_created() {
        $b = $this->makeBarang();
        $this->assertDatabaseHas('barangs', ['nama_barang' => 'Indomie']);
        $this->assertEquals(2500, $b->harga_beli);
    }
    public function test_barang_belongs_to_supplier() {
        $b = $this->makeBarang();
        $this->assertEquals('S1', $b->supplier->nama_supplier);
    }
    public function test_barang_belongs_to_kategori_and_satuan() {
        $b = $this->makeBarang();
        $this->assertEquals('K1', $b->kategori->nama_kategori);
        $this->assertEquals('Pcs', $b->satuan->nama_satuan);
    }
}
