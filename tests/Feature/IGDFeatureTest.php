<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\IGD;
use App\Models\Pasien;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IGDFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private Pasien $pasien;

    private Dokter $dokter;

    protected function setUp(): void
    {
        parent::setUp();

        // Run role and permission seeders
        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        // Create admin user
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('Admin');

        // Create pasien
        $pasienUser = User::factory()->create(['name' => 'Pasien Test']);
        $this->pasien = Pasien::factory()->for($pasienUser, 'user')->create();

        // Create dokter
        $dokterUser = User::factory()->create(['name' => 'Dokter Test']);
        $this->dokter = Dokter::factory()->for($dokterUser, 'user')->create();
    }

    public function test_admin_can_view_igd_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.igd.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.igd.index');
    }

    public function test_admin_can_create_igd(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.igd.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.igd.create');
    }

    public function test_admin_can_store_igd(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d H:i'),
            'keluhan_utama' => 'Demam tinggi dan pusing',
            'triase_level' => 'Kuning',
            'status' => 'Menunggu',
            'catatan' => 'Pasien perlu observasi',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.igd.store'), $data);

        $this->assertDatabaseHas('igd', [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'triase_level' => 'Kuning',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_view_igd_detail(): void
    {
        $igd = IGD::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.igd.show', $igd));

        $response->assertStatus(200);
        $response->assertViewIs('admin.igd.show');
        $response->assertViewHas('igd', $igd);
    }

    public function test_admin_can_edit_igd(): void
    {
        $igd = IGD::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.igd.edit', $igd));

        $response->assertStatus(200);
        $response->assertViewIs('admin.igd.edit');
        $response->assertViewHas('igd', $igd);
    }

    public function test_admin_can_update_igd(): void
    {
        $igd = IGD::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d H:i'),
            'tanggal_keluar' => now()->addHours(2)->format('Y-m-d H:i'),
            'keluhan_utama' => 'Keluhan diperbarui',
            'triase_level' => 'Merah',
            'status' => 'Selesai',
            'catatan' => 'Catatan diperbarui',
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.igd.update', $igd), $data);

        $this->assertDatabaseHas('igd', [
            'id' => $igd->id,
            'triase_level' => 'Merah',
            'status' => 'Selesai',
            'keluhan_utama' => 'Keluhan diperbarui',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_delete_igd(): void
    {
        $igd = IGD::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->delete(route('admin.igd.destroy', $igd));

        $this->assertDatabaseMissing('igd', ['id' => $igd->id]);
        $response->assertRedirect(route('admin.igd.index'));
    }

    public function test_validation_requires_pasien_id(): void
    {
        $data = [
            'pasien_id' => '',
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d H:i'),
            'keluhan_utama' => 'Demam',
            'triase_level' => 'Hijau',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.igd.store'), $data);

        $response->assertSessionHasErrors('pasien_id');
    }

    public function test_validation_requires_keluhan_utama(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d H:i'),
            'keluhan_utama' => '',
            'triase_level' => 'Hijau',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.igd.store'), $data);

        $response->assertSessionHasErrors('keluhan_utama');
    }

    public function test_validation_requires_valid_triase_level(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d H:i'),
            'keluhan_utama' => 'Demam',
            'triase_level' => 'Invalid',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.igd.store'), $data);

        $response->assertSessionHasErrors('triase_level');
    }
}
