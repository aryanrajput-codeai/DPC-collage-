<?php

namespace Tests\Feature;

use Database\Seeders\CollegeErpSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CollegeErpSeeder::class);
    }

    public function test_api_health_check_returns_valid_institution_info(): void
    {
        $response = $this->getJson('/api/v1/health');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'healthy',
                'institution' => 'D.P. Chaturvedi College, Seoni (MP)',
                'institution_code' => 'JS-499',
            ]);
    }

    public function test_api_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'student@dpccollege.com',
            'password' => 'invalid-password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_api_login_issues_bearer_token_and_loads_profile(): void
    {
        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'student@dpccollege.com',
            'password' => 'password',
            'device_name' => 'Android-Test-Phone',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'token',
                'token_type',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'role_slug',
                    'student_profile',
                ],
            ]);

        $token = $response->json('token');
        $this->assertNotEmpty($token);

        // Test authenticated /api/v1/auth/me
        $meResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/auth/me');

        $meResponse->assertStatus(200)
            ->assertJsonPath('user.email', 'student@dpccollege.com')
            ->assertJsonPath('user.role_slug', 'student');

        // Test student dashboard
        $dashResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/student/dashboard');

        $dashResponse->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'student' => [
                    'id',
                    'name',
                    'attendance_pct',
                    'fee_summary',
                ],
                'timetable',
                'assignments',
                'announcements',
            ]);

        // Test timetable endpoint
        $timetableResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/timetable');

        $timetableResponse->assertStatus(200)
            ->assertJsonStructure(['success', 'slots']);

        // Test notifications endpoint
        $notifResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson('/api/v1/notifications');

        $notifResponse->assertStatus(200)
            ->assertJsonStructure(['success', 'data']);

        // Test logout
        $logoutResponse = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/v1/auth/logout');

        $logoutResponse->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_pwa_manifest_and_offline_view_render(): void
    {
        $manifest = $this->get('/manifest.json');
        $manifest->assertStatus(200);

        $offline = $this->get('/offline');
        $offline->assertStatus(200)
            ->assertSee("You're Offline", false)
            ->assertSee('D.P. Chaturvedi College');
    }
}
