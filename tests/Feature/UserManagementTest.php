<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Pasien $pasien;
    private Dokter $dokter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('Admin');

        $pasienUser = User::factory()->create(['name' => 'Pasien Test']);
        $this->pasien = Pasien::factory()->for($pasienUser, 'user')->create();

        $dokterUser = User::factory()->create(['name' => 'Dokter Test']);
        $this->dokter = Dokter::factory()->for($dokterUser, 'user')->create();
    }

    public function test_admin_can_view_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.user-management.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.user-management.index');
    }

    public function test_search_filters_results(): void
    {
        $special = User::factory()->create(['name' => 'UniqueSearchUser', 'email' => 'unique@example.com']);

        $response = $this->actingAs($this->adminUser)->get(route('admin.user-management.index', ['pencarian' => 'UniqueSearchUser']));

        $response->assertStatus(200);
        $response->assertSee('UniqueSearchUser');
    }

    public function test_admin_can_create_petugas_user(): void
    {
        $data = [
            'name' => 'Petugas Baru',
            'email' => 'petugas.baru@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'role' => 'Petugas',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.user-management.store'), $data);

        $this->assertDatabaseHas('users', ['email' => 'petugas.baru@example.com', 'name' => 'Petugas Baru']);
        $response->assertRedirect(route('admin.user-management.index'));
    }

    public function test_admin_can_update_user(): void
    {
        $user = User::factory()->create(['name' => 'Old Name']);
        $response = $this->actingAs($this->adminUser)->put(route('admin.user-management.update', $user), [
            'name' => 'New Name',
            'email' => $user->email,
        ]);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name']);
        $response->assertRedirect(route('admin.user-management.index'));
    }

    public function test_admin_can_delete_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)->delete(route('admin.user-management.destroy', $user));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.user-management.index'));
    }

    public function test_export_returns_pdf(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.user-management.export'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
        $this->assertStringContainsString('attachment', $response->headers->get('content-disposition'));
    }
}
