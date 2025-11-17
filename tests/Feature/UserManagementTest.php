<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        $roles = [
            'Admin' => Role::create(['name' => 'Admin']),
            'Dokter' => Role::create(['name' => 'Dokter']),
            'Petugas' => Role::create(['name' => 'Petugas']),
            'Pasien' => Role::create(['name' => 'Pasien']),
        ];

        // Create permission
        Permission::create(['name' => 'users.view']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.delete']);

        // Give permissions to Admin role
        $adminRole = $roles['Admin'];
        $adminRole->givePermissionTo(['users.view', 'users.create', 'users.edit', 'users.delete']);
    }

    public function test_can_view_user_management_index(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)
            ->get(route('admin.user-management.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_dokter_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)
            ->post(route('admin.user-management.store'), [
                'name' => 'Dr. Sekar',
                'email' => 'sekar@hospital.com',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
                'role' => 'Dokter',
                'nip' => 'DOK002',
                'spesialisasi' => 'Bedah',
                'no_telp' => '081234567892',
            ]);

        $response->assertRedirect(route('admin.user-management.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Dr. Sekar',
            'email' => 'sekar@hospital.com',
        ]);
        $this->assertDatabaseHas('dokter', [
            'nip' => 'DOK002',
            'spesialisasi' => 'Bedah',
        ]);
    }

    public function test_can_create_pasien_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)
            ->post(route('admin.user-management.store'), [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
                'role' => 'Pasien',
                'nik' => '3201010101900002',
                'tanggal_lahir' => '1990-01-02',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Merdeka No. 10',
                'no_telp' => '081234567893',
            ]);

        $response->assertRedirect(route('admin.user-management.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
        ]);
        $this->assertDatabaseHas('pasien', [
            'nik' => '3201010101900002',
        ]);
    }

    public function test_can_update_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user = User::factory()->create(['name' => 'Old Name']);
        $user->assignRole('Dokter');
        Dokter::factory()->create([
            'user_id' => $user->id,
            'nip' => 'DOK001',
            'spesialisasi' => 'Umum',
        ]);

        $response = $this->actingAs($admin)
            ->put(route('admin.user-management.update', $user), [
                'name' => 'New Name',
                'email' => $user->email,
                'nip' => 'DOK001-UPDATED',
                'spesialisasi' => 'Bedah',
                'no_telp' => '081234567890',
            ]);

        $response->assertRedirect(route('admin.user-management.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_delete_user(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $user = User::factory()->create();
        $user->assignRole('Pasien');

        $response = $this->actingAs($admin)
            ->delete(route('admin.user-management.destroy', $user));

        $response->assertRedirect(route('admin.user-management.index'));
        $this->assertModelMissing($user);
    }

    public function test_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this->actingAs($admin)
            ->delete(route('admin.user-management.destroy', $admin));

        $response->assertSessionHas('warning');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_email_must_be_unique(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->actingAs($admin)
            ->post(route('admin.user-management.store'), [
                'name' => 'Another User',
                'email' => 'existing@example.com',
                'password' => 'Password123',
                'password_confirmation' => 'Password123',
                'role' => 'Admin',
            ]);

        $response->assertSessionHasErrors('email');
    }
}
