<?php
namespace Tests\Unit;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class TransaksiTest extends TestCase {
    use RefreshDatabase;
    public function test_transaksi_can_be_created_with_pelanggan() {
        $pel = Pelanggan::create(['nama_pelanggan' => 'Pak Budi']);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-001', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 50000, 'status' => 'tunai',
        ]);
        $this->assertDatabaseHas('transaksis', ['no_transaksi' => 'TR-001']);
        $this->assertEquals('Pak Budi', $t->pelanggan->nama_pelanggan);
    }
    public function test_transaksi_has_many_details() {
        $pel = Pelanggan::create(['nama_pelanggan' => 'Bu Ani']);
        $sup = Supplier::create(['nama_supplier' => 'S', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'K']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        $b = Barang::create([
            'nama_barang' => 'Item', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1500,
            'harga_grosir_2' => 1400, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1200,
            'isi_stok' => 100,
        ]);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-002', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 7500, 'status' => 'tunai',
        ]);
        TransaksiDetail::create([
            'transaksi_id' => $t->id, 'barang_id' => $b->id,
            'qty' => 5, 'harga_jual' => 1500, 'subtotal' => 7500,
        ]);
        $this->assertCount(1, $t->details);
    }
}
