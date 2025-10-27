<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationRoleTest extends TestCase
{
  use RefreshDatabase;

  public function test_staff_registration_creates_inactive_user_and_staff_record()
  {
    $response = $this->post('/register', [
      'name' => 'Staff User',
      'email' => 'staff@example.com',
      'password' => 'password',
      'password_confirmation' => 'password',
      'role' => 'staff',
    ]);

    $this->assertDatabaseHas('users', ['email' => 'staff@example.com', 'role' => 'staff']);
    $user = User::where('email', 'staff@example.com')->first();
    $this->assertFalse($user->is_active);
    $this->assertDatabaseHas('staff', ['user_id' => $user->id]);
  }

  public function test_inactive_staff_cannot_login()
  {
    $user = User::factory()->create(['email' => 's2@example.com', 'password' => bcrypt('password'), 'role' => 'staff', 'is_active' => false]);

    $response = $this->post('/login', ['email' => 's2@example.com', 'password' => 'password']);
    $response->assertSessionHasErrors();
    $this->assertGuest();
  }

  public function test_regular_user_can_login_and_sees_dashboard()
  {
    $user = User::factory()->create(['email' => 'u1@example.com', 'password' => bcrypt('password'), 'role' => 'user']);
    $response = $this->post('/login', ['email' => 'u1@example.com', 'password' => 'password']);
    $this->assertAuthenticatedAs($user);
    $response = $this->get('/dashboard');
    $response->assertStatus(200);
  }
}
