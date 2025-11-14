<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Poli;
use App\Models\RawatJalan;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RawatJalanFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private Pasien $pasien;

    private Dokter $dokter;

    private Poli $poli;

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

        // Create poli
        $this->poli = Poli::factory()->create();
    }

    public function test_admin_can_view_rawat_jalan_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-jalan.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-jalan.index');
    }

    public function test_admin_can_create_rawat_jalan(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-jalan.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-jalan.create');
    }

    public function test_admin_can_store_rawat_jalan(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d H:i'),
            'keluhan' => 'Demam tinggi dan pusing',
            'status' => 'Menunggu',
            'catatan' => 'Pasien perlu observasi',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-jalan.store'), $data);

        $this->assertDatabaseHas('rawat_jalan', [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'status' => 'Menunggu',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_view_rawat_jalan_detail(): void
    {
        $rawatJalan = RawatJalan::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->for($this->poli, 'poli')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-jalan.show', $rawatJalan));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-jalan.show');
        $response->assertViewHas('rawatJalan', $rawatJalan);
    }

    public function test_admin_can_edit_rawat_jalan(): void
    {
        $rawatJalan = RawatJalan::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->for($this->poli, 'poli')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-jalan.edit', $rawatJalan));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-jalan.edit');
        $response->assertViewHas('rawatJalan', $rawatJalan);
    }

    public function test_admin_can_update_rawat_jalan(): void
    {
        $rawatJalan = RawatJalan::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->for($this->poli, 'poli')
            ->create();

        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d H:i'),
            'keluhan' => 'Keluhan diperbarui',
            'diagnosa' => 'Diagnosa baru',
            'status' => 'Selesai',
            'catatan' => 'Catatan diperbarui',
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.rawat-jalan.update', $rawatJalan), $data);

        $this->assertDatabaseHas('rawat_jalan', [
            'id' => $rawatJalan->id,
            'status' => 'Selesai',
            'keluhan' => 'Keluhan diperbarui',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_delete_rawat_jalan(): void
    {
        $rawatJalan = RawatJalan::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->for($this->poli, 'poli')
            ->create();

        $response = $this->actingAs($this->adminUser)->delete(route('admin.rawat-jalan.destroy', $rawatJalan));

        $this->assertDatabaseMissing('rawat_jalan', ['id' => $rawatJalan->id]);
        $response->assertRedirect(route('admin.rawat-jalan.index'));
    }

    public function test_validation_requires_pasien_id(): void
    {
        $data = [
            'pasien_id' => '',
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d H:i'),
            'keluhan' => 'Demam',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-jalan.store'), $data);

        $response->assertSessionHasErrors('pasien_id');
    }

    public function test_validation_requires_keluhan(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d H:i'),
            'keluhan' => '',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-jalan.store'), $data);

        $response->assertSessionHasErrors('keluhan');
    }

    public function test_validation_requires_valid_status(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'poli_id' => $this->poli->id,
            'tanggal_kunjungan' => now()->format('Y-m-d H:i'),
            'keluhan' => 'Demam',
            'status' => 'Invalid',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-jalan.store'), $data);

        $response->assertSessionHasErrors('status');
    }
}
