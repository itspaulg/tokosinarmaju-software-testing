<?php
namespace Tests\Feature;

use App\Models\Satuan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SatuanCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_satuan_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/satuans')->assertStatus(200);
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get('/satuans/create')->assertStatus(200);
    }

    public function test_authenticated_user_can_store_satuan()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/satuans', ['nama_satuan' => 'Kg']);
        $this->assertDatabaseHas('satuans', ['nama_satuan' => 'Kg']);
    }


    public function test_authenticated_user_can_view_edit_form()
    {
        $user = User::factory()->create();
        $s = Satuan::create(['nama_satuan' => 'Box']);
        $this->actingAs($user)->get("/satuans/{$s->id}/edit")->assertStatus(200);
    }

    public function test_authenticated_user_can_destroy_satuan()
    {
        $user = User::factory()->create();
        $s = Satuan::create(['nama_satuan' => 'Sak']);
        $this->actingAs($user)->delete("/satuans/{$s->id}");
        $this->assertDatabaseMissing('satuans', ['id' => $s->id]);
    }
}
