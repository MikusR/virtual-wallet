<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_view_a_login_form()
    {
        $user =
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('login');
    }

    public function test_user_can_view_a_register_form()
    {
        $response = $this->get('/register');
        $response->assertSuccessful();
        $response->assertViewIs('register.create');
    }

    public function test_user_cannot_view_a_login_form_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/');
    }

    public function test_user_cannot_view_a_register_form_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/');
    }

    public function test_user_can_log_out_when_authenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->post('/logout');
        $response->assertSessionHas('success', 'User logged out');
        $response->assertRedirect('/');
    }

    public function test_user_can_not_log_in_with_wrong_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('REalPassword'),
        ]);

        $response = $this->from('/login')->post('/login', [
            'email'    => $user->email,
            'password' => 'test-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');

        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertGuest();
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'testPassword'),
        ]);

        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/wallets');
        
        $this->assertAuthenticatedAs($user);
    }
}
