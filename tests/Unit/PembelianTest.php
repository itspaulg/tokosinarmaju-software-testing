<?php
namespace Tests\Unit;
use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\Kategori;
use App\Models\Pembelian;
use App\Models\Satuan;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class PembelianTest extends TestCase {
    use RefreshDatabase;
    public function test_pembelian_can_be_created_with_supplier() {
        $sup = Supplier::create(['nama_supplier' => 'PT A', 'tipe_supplier' => 'baru']);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-001', 'tanggal' => '2025-05-01', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 100000, 'bayar' => 100000,
        ]);
        $this->assertDatabaseHas('pembelians', ['no_transaksi' => 'PB-001']);
        $this->assertEquals($sup->id, $p->supplier_id);
    }
    public function test_pembelian_has_many_details() {
        $sup = Supplier::create(['nama_supplier' => 'PT B', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'X']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        $b = Barang::create([
            'nama_barang' => 'Item', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1100,
            'harga_grosir_2' => 1200, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1400,
            'isi_stok' => 50,
        ]);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-002', 'tanggal' => '2025-05-02', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 5000, 'bayar' => 5000,
        ]);
        DetailPembelian::create([
            'pembelian_id' => $p->id, 'barang_id' => $b->id,
            'qty' => 5, 'harga_beli' => 1000, 'jumlah' => 5000,
        ]);
        $this->assertCount(1, $p->details);
    }
}
