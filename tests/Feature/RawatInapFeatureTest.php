<?php

namespace Tests\Feature;

use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\RawatInap;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RawatInapFeatureTest extends TestCase
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

    public function test_admin_can_view_rawat_inap_list(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-inap.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-inap.index');
    }

    public function test_admin_can_create_rawat_inap(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-inap.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-inap.create');
    }

    public function test_admin_can_store_rawat_inap(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d'),
            'ruang' => 'ICU',
            'no_tempat_tidur' => '101',
            'diagnosa' => 'Infeksi paru-paru',
            'status' => 'Sedang Dirawat',
            'catatan' => 'Pasien perlu monitoring ketat',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-inap.store'), $data);

        $this->assertDatabaseHas('rawat_inap', [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'ruang' => 'ICU',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_view_rawat_inap_detail(): void
    {
        $rawatInap = RawatInap::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-inap.show', $rawatInap));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-inap.show');
        $response->assertViewHas('rawatInap', $rawatInap);
    }

    public function test_admin_can_edit_rawat_inap(): void
    {
        $rawatInap = RawatInap::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->get(route('admin.rawat-inap.edit', $rawatInap));

        $response->assertStatus(200);
        $response->assertViewIs('admin.rawat-inap.edit');
        $response->assertViewHas('rawatInap', $rawatInap);
    }

    public function test_admin_can_update_rawat_inap(): void
    {
        $rawatInap = RawatInap::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d'),
            'tanggal_keluar' => now()->addDays(5)->format('Y-m-d'),
            'ruang' => 'Bedah',
            'no_tempat_tidur' => '205',
            'diagnosa' => 'Post operasi lambung',
            'status' => 'Selesai',
            'catatan' => 'Pasien diperbolehkan pulang',
        ];

        $response = $this->actingAs($this->adminUser)->put(route('admin.rawat-inap.update', $rawatInap), $data);

        $this->assertDatabaseHas('rawat_inap', [
            'id' => $rawatInap->id,
            'ruang' => 'Bedah',
            'status' => 'Selesai',
            'diagnosa' => 'Post operasi lambung',
        ]);

        $response->assertRedirect();
    }

    public function test_admin_can_delete_rawat_inap(): void
    {
        $rawatInap = RawatInap::factory()
            ->for($this->pasien, 'pasien')
            ->for($this->dokter, 'dokter')
            ->create();

        $response = $this->actingAs($this->adminUser)->delete(route('admin.rawat-inap.destroy', $rawatInap));

        $this->assertDatabaseMissing('rawat_inap', ['id' => $rawatInap->id]);
        $response->assertRedirect(route('admin.rawat-inap.index'));
    }

    public function test_validation_requires_pasien_id(): void
    {
        $data = [
            'pasien_id' => '',
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d'),
            'ruang' => 'ICU',
            'no_tempat_tidur' => '101',
            'diagnosa' => 'Demam',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-inap.store'), $data);

        $response->assertSessionHasErrors('pasien_id');
    }

    public function test_validation_requires_tanggal_masuk(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => '',
            'ruang' => 'ICU',
            'no_tempat_tidur' => '101',
            'diagnosa' => 'Demam',
            'status' => 'Menunggu',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-inap.store'), $data);

        $response->assertSessionHasErrors('tanggal_masuk');
    }

    public function test_validation_requires_valid_status(): void
    {
        $data = [
            'pasien_id' => $this->pasien->id,
            'dokter_id' => $this->dokter->id,
            'tanggal_masuk' => now()->format('Y-m-d'),
            'ruang' => 'ICU',
            'no_tempat_tidur' => '101',
            'diagnosa' => 'Demam',
            'status' => 'Invalid Status',
        ];

        $response = $this->actingAs($this->adminUser)->post(route('admin.rawat-inap.store'), $data);

        $response->assertSessionHasErrors('status');
    }
}
