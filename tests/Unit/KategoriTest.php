<?php
namespace Tests\Unit;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class KategoriTest extends TestCase {
    use RefreshDatabase;
    public function test_kategori_can_be_created() {
        $k = Kategori::create(['nama_kategori' => 'Makanan']);
        $this->assertDatabaseHas('kategoris', ['nama_kategori' => 'Makanan']);
        $this->assertEquals('Makanan', $k->nama_kategori);
    }
    public function test_kategori_has_correct_fillable_attributes() {
        $this->assertEquals(['nama_kategori'], (new Kategori())->getFillable());
    }
}
