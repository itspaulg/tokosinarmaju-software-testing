<?php
namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class AuthRedirectTest extends TestCase {
    use RefreshDatabase;
    public function test_guest_is_redirected_to_login_when_accessing_dashboard() {
        $this->get('/dashboard')->assertRedirect('/login');
    }
    public function test_guest_is_redirected_when_accessing_protected_resources() {
        $this->get('/barangs')->assertRedirect('/login');
    }
}
