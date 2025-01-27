<?php

use App\Models\ProvisionedUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProvisionedUserControllerTest extends TestCase
{
    use RefreshDatabase;

    private Authenticatable $user;

    public function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_with_auth_index()
    {
        Sanctum::actingAs($this->user, ['*']);

        $provisionedUsers = ProvisionedUser::factory()->count(10)->create();

        $response = $this->json('GET', '/provisioned-users');

        $localProvisionedUsers = $provisionedUsers->map(function(ProvisionedUser $user) {
            return $user->only(['id', 'first_name', 'middle_name', 'last_name', 'email']);
        })->sortBy('id')->values();

        $response
            ->assertOk()
            ->assertJson(["data" => $localProvisionedUsers->toArray()]);
    }

    public function test_index_with_auth_no_users()
    {
        Sanctum::actingAs($this->user, ['*']);

        $response = $this->json('GET', '/provisioned-users');

        $response->assertStatus(200);
        $response->assertJson(["data" => []]);
    }

    public function test_index_no_auth()
    {
        $response = $this->json('GET', '/provisioned-users');

        $response->assertStatus(401);
    }
}
