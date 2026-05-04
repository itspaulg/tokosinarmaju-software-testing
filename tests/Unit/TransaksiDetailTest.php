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

class TransaksiDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaksi_detail_can_be_created()
    {
        $pel = Pelanggan::create(['nama_pelanggan' => 'Pak C']);
        $sup = Supplier::create(['nama_supplier' => 'PT C', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'C']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        $b = Barang::create([
            'nama_barang' => 'Item C', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1000, 'harga_grosir_1' => 1500,
            'harga_grosir_2' => 1400, 'harga_grosir_3' => 1300, 'harga_grosir_4' => 1200,
            'isi_stok' => 50,
        ]);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-C01', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 7500, 'status' => 'tunai',
        ]);
        $detail = TransaksiDetail::create([
            'transaksi_id' => $t->id, 'barang_id' => $b->id,
            'qty' => 5, 'harga_jual' => 1500, 'subtotal' => 7500,
        ]);

        $this->assertDatabaseHas('transaksi_details', ['transaksi_id' => $t->id, 'qty' => 5]);
        $this->assertEquals(7500, $detail->subtotal);
    }

    public function test_transaksi_detail_belongs_to_transaksi_and_barang()
    {
        $pel = Pelanggan::create(['nama_pelanggan' => 'Pak F']);
        $sup = Supplier::create(['nama_supplier' => 'PT F', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'F']);
        $sat = Satuan::create(['nama_satuan' => 'Kg']);
        $b = Barang::create([
            'nama_barang' => 'Item F', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 3000, 'harga_grosir_1' => 3500,
            'harga_grosir_2' => 3400, 'harga_grosir_3' => 3300, 'harga_grosir_4' => 3200,
            'isi_stok' => 25,
        ]);
        $t = Transaksi::create([
            'no_transaksi' => 'TR-F01', 'tanggal' => '2025-05-04', 'tempo' => '2025-05-04',
            'pelanggan_id' => $pel->id, 'total' => 10500, 'status' => 'tunai',
        ]);
        $detail = TransaksiDetail::create([
            'transaksi_id' => $t->id, 'barang_id' => $b->id,
            'qty' => 3, 'harga_jual' => 3500, 'subtotal' => 10500,
        ]);

        $this->assertEquals('TR-F01', $detail->transaksi->no_transaksi);
        $this->assertEquals('Item F', $detail->barang->nama_barang);
    }
}
