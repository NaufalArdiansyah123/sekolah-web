<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin role
        Role::create(['name' => 'admin']);

        // Create admin user
        $this->admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);

        $this->admin->assignRole('admin');
    }

    /** @test */
    public function admin_can_view_profile_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.profile.index');
        $response->assertSee($this->admin->name);
        $response->assertSee($this->admin->email);
    }

    /** @test */
    public function admin_can_update_profile_information()
    {
        $newData = [
            'name' => 'Updated Name',
            'email' => 'updated@test.com',
            'phone' => '+1234567890',
            'bio' => 'Updated bio information',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), $newData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Profile updated successfully!'
        ]);

        $this->admin->refresh();
        $this->assertEquals($newData['name'], $this->admin->name);
        $this->assertEquals($newData['email'], $this->admin->email);
        $this->assertEquals($newData['phone'], $this->admin->phone);
        $this->assertEquals($newData['bio'], $this->admin->bio);

        // Check activity log
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $this->admin->id,
            'type' => 'profile_update',
            'description' => 'Profile information updated',
        ]);
    }

    /** @test */
    public function admin_can_change_password()
    {
        $passwordData = [
            'current_password' => 'password123',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.password'), $passwordData);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Password updated successfully!'
        ]);

        $this->admin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $this->admin->password));
        $this->assertNotNull($this->admin->password_changed_at);

        // Check activity log
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $this->admin->id,
            'type' => 'password_change',
            'description' => 'Password changed',
        ]);
    }

    /** @test */
    public function admin_cannot_change_password_with_wrong_current_password()
    {
        $passwordData = [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.password'), $passwordData);

        $response->assertStatus(422);
        $response->assertJson([
            'success' => false,
            'message' => 'Current password is incorrect.'
        ]);
    }

    /** @test */
    public function admin_can_upload_avatar()
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.profile.avatar'), [
                'avatar' => $file
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Avatar updated successfully!'
        ]);

        $this->admin->refresh();
        $this->assertNotNull($this->admin->avatar);
        Storage::disk('public')->assertExists($this->admin->avatar);

        // Check activity log
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $this->admin->id,
            'type' => 'avatar_update',
            'description' => 'Updated profile avatar',
        ]);
    }

    /** @test */
    public function admin_can_logout_from_other_devices()
    {
        $response = $this->actingAs($this->admin)
            ->postJson(route('admin.profile.logout-devices'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Successfully logged out from all other devices.'
        ]);

        // Check activity log
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $this->admin->id,
            'type' => 'security',
            'description' => 'Logged out from all other devices',
        ]);
    }

    /** @test */
    public function admin_can_view_activity_log()
    {
        // Create some activities
        UserActivity::log($this->admin->id, 'login', 'User logged in');
        UserActivity::log($this->admin->id, 'profile_update', 'Updated profile');

        $response = $this->actingAs($this->admin)
            ->getJson(route('admin.profile.activity'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true
        ]);

        $activities = $response->json('activities');
        $this->assertCount(2, $activities);
        $this->assertEquals('profile_update', $activities[0]['type']);
        $this->assertEquals('login', $activities[1]['type']);
    }

    /** @test */
    public function admin_can_download_data()
    {
        $response = $this->actingAs($this->admin)
            ->getJson(route('admin.profile.download-data'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'User data exported successfully!'
        ]);

        $data = $response->json('data');
        $this->assertArrayHasKey('personal_information', $data);
        $this->assertArrayHasKey('account_information', $data);
        $this->assertEquals($this->admin->name, $data['personal_information']['name']);
        $this->assertEquals($this->admin->email, $data['personal_information']['email']);
    }

    /** @test */
    public function profile_validation_works_correctly()
    {
        // Test required fields
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'name' => '',
                'email' => 'invalid-email',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email']);

        // Test unique email
        $otherUser = User::factory()->create(['email' => 'other@test.com']);

        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.update'), [
                'name' => 'Test Name',
                'email' => 'other@test.com',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function password_validation_works_correctly()
    {
        // Test weak password
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.password'), [
                'current_password' => 'password123',
                'password' => '123',
                'password_confirmation' => '123',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);

        // Test password confirmation mismatch
        $response = $this->actingAs($this->admin)
            ->putJson(route('admin.profile.password'), [
                'current_password' => 'password123',
                'password' => 'newpassword123',
                'password_confirmation' => 'differentpassword',
            ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }
}