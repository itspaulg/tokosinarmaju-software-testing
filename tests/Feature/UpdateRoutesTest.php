<?php
namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pelanggan;
use App\Models\Satuan;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_kategori()
    {
        $user = User::factory()->create();
        $k = Kategori::create(['nama_kategori' => 'OldName']);
        $this->actingAs($user)->put("/kategoris/{$k->id}", ['nama_kategori' => 'NewName']);
        $this->assertDatabaseHas('kategoris', ['id' => $k->id, 'nama_kategori' => 'NewName']);
    }


    public function test_user_can_update_supplier()
    {
        $user = User::factory()->create();
        $s = Supplier::create(['nama_supplier' => 'PT Old', 'tipe_supplier' => 'baru']);
        $this->actingAs($user)->put("/suppliers/{$s->id}", [
            'nama_supplier' => 'PT New',
            'tipe_supplier' => 'baru',
        ]);
        $this->assertDatabaseHas('suppliers', ['id' => $s->id, 'nama_supplier' => 'PT New']);
    }

    public function test_user_can_update_satuan()
    {
        $user = User::factory()->create();
        $s = Satuan::create(['nama_satuan' => 'OldUnit']);
        $this->actingAs($user)->put("/satuans/{$s->id}", ['nama_satuan' => 'NewUnit']);
        $this->assertDatabaseHas('satuans', ['id' => $s->id, 'nama_satuan' => 'NewUnit']);
    }
}
