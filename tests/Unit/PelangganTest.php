<?php
namespace Tests\Unit;
use App\Models\Pelanggan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class PelangganTest extends TestCase {
    use RefreshDatabase;
    public function test_pelanggan_can_be_created() {
        Pelanggan::create(['nama_pelanggan' => 'Budi', 'tipe_pelanggan' => 'baru']);
        $this->assertDatabaseHas('pelanggans', ['nama_pelanggan' => 'Budi']);
    }
    public function test_pelanggan_default_tipe_is_baru() {
        $p = Pelanggan::create(['nama_pelanggan' => 'Ali']);
        $p->refresh();
        $this->assertEquals('baru', $p->tipe_pelanggan);
    }
    public function test_pelanggan_default_status_is_aktif() {
        $p = Pelanggan::create(['nama_pelanggan' => 'Siti']);
        $p->refresh();
        $this->assertEquals('aktif', $p->status);
    }
}
