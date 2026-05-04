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

class DetailPembelianTest extends TestCase
{
    use RefreshDatabase;

    public function test_detail_pembelian_can_be_created()
    {
        $sup = Supplier::create(['nama_supplier' => 'PT D', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'A']);
        $sat = Satuan::create(['nama_satuan' => 'Pcs']);
        $b = Barang::create([
            'nama_barang' => 'Item D', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 1500, 'harga_grosir_1' => 1700,
            'harga_grosir_2' => 1800, 'harga_grosir_3' => 1900, 'harga_grosir_4' => 2000,
            'isi_stok' => 30,
        ]);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-D01', 'tanggal' => '2025-05-01', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 15000, 'bayar' => 15000,
        ]);
        $detail = DetailPembelian::create([
            'pembelian_id' => $p->id, 'barang_id' => $b->id,
            'qty' => 10, 'harga_beli' => 1500, 'jumlah' => 15000,
        ]);

        $this->assertDatabaseHas('detail_pembelians', ['pembelian_id' => $p->id, 'qty' => 10]);
        $this->assertEquals(15000, $detail->jumlah);
    }

    public function test_detail_pembelian_belongs_to_pembelian_and_barang()
    {
        $sup = Supplier::create(['nama_supplier' => 'PT E', 'tipe_supplier' => 'baru']);
        $kat = Kategori::create(['nama_kategori' => 'B']);
        $sat = Satuan::create(['nama_satuan' => 'Box']);
        $b = Barang::create([
            'nama_barang' => 'Item E', 'supplier_id' => $sup->id, 'kategori_id' => $kat->id,
            'satuan_id' => $sat->id, 'harga_beli' => 2000, 'harga_grosir_1' => 2100,
            'harga_grosir_2' => 2200, 'harga_grosir_3' => 2300, 'harga_grosir_4' => 2400,
            'isi_stok' => 20,
        ]);
        $p = Pembelian::create([
            'no_transaksi' => 'PB-E01', 'tanggal' => '2025-05-02', 'status' => 'tunai',
            'supplier_id' => $sup->id, 'total' => 4000, 'bayar' => 4000,
        ]);
        $detail = DetailPembelian::create([
            'pembelian_id' => $p->id, 'barang_id' => $b->id,
            'qty' => 2, 'harga_beli' => 2000, 'jumlah' => 4000,
        ]);

        $this->assertEquals('PB-E01', $detail->pembelian->no_transaksi);
        $this->assertEquals('Item E', $detail->barang->nama_barang);
    }
}
