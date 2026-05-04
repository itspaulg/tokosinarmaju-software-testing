<?php
namespace Tests\Unit;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class SupplierTest extends TestCase {
    use RefreshDatabase;
    public function test_supplier_can_be_created_with_required_fields() {
        Supplier::create(['nama_supplier' => 'PT Sinar Jaya', 'tipe_supplier' => 'baru']);
        $this->assertDatabaseHas('suppliers', ['nama_supplier' => 'PT Sinar Jaya']);
    }
    public function test_supplier_can_have_tipe_reguler() {
        $s = Supplier::create(['nama_supplier' => 'CV Maju', 'tipe_supplier' => 'reguler']);
        $this->assertEquals('reguler', $s->tipe_supplier);
    }
    public function test_supplier_can_be_created_with_full_attributes() {
        $s = Supplier::create([
            'nama_supplier' => 'Toko Sumber', 'no_telp' => '081234567890',
            'alamat' => 'Jl. Sudirman 1', 'tipe_supplier' => 'reguler',
            'email' => 'sumber@example.com',
        ]);
        $this->assertEquals('081234567890', $s->no_telp);
    }
}
