<?php
namespace Tests\Unit;
use App\Models\Satuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class SatuanTest extends TestCase {
    use RefreshDatabase;
    public function test_satuan_can_be_created() {
        $s = Satuan::create(['nama_satuan' => 'Pcs']);
        $this->assertDatabaseHas('satuans', ['nama_satuan' => 'Pcs']);
        $this->assertEquals('Pcs', $s->nama_satuan);
    }
    public function test_satuan_has_correct_fillable_attributes() {
        $this->assertEquals(['nama_satuan'], (new Satuan())->getFillable());
    }
}
