<?php
namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_supplier_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/suppliers')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/suppliers/create')->assertStatus(200);
    }


    public function test_authenticated_user_can_view_edit_form()
    {
        $user = User::factory()->create();
        $s = Supplier::create(['nama_supplier' => 'PT Edit', 'tipe_supplier' => 'baru']);
        $this->actingAs($user)->get("/suppliers/{$s->id}/edit")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_supplier()
    {
        $user = User::factory()->create();
        $s = Supplier::create(['nama_supplier' => 'PT Hapus', 'tipe_supplier' => 'baru']);
        $this->actingAs($user)->delete("/suppliers/{$s->id}");
        $this->assertDatabaseMissing('suppliers', ['id' => $s->id]);
    }
}
