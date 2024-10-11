<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
    }

    public function test_list_users()
    {
        User::factory()->count(3)->create();
        $users = $this->userService->listUsers();
        $this->assertCount(3, $users);
    }

    public function test_create_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ];
        $user = $this->userService->createUser($userData);
        $this->assertEquals('John Doe', $user->name);
    }

// Add more tests for update, soft delete, restore, etc.
}

?>
