<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:migrate-sqlite-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from SQLite to MySQL database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sqlitePath = database_path('database.sqlite');

        if (!file_exists($sqlitePath)) {
            $this->error('File SQLite tidak ditemukan: ' . $sqlitePath);
            return Command::FAILURE;
        }

        $this->info('Memulai migrasi data dari SQLite ke MySQL...');

        try {
            // Connect to SQLite
            $sqlite = new PDO('sqlite:' . $sqlitePath);
            $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Get all tables except system tables
            $tables = $sqlite->query(
                "SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name"
            )->fetchAll(PDO::FETCH_COLUMN);

            // Define table order for migration (respecting foreign keys)
            $tableOrder = [
                'users',
                'roles',
                'permissions',
                'role_has_permissions',
                'model_has_roles',
                'model_has_permissions',
                'dokter',
                'pasien',
                'rekam_medis',
                'jadwal',
                'password_reset_tokens',
                'sessions',
                'cache',
                'cache_locks',
                'jobs',
                'job_batches',
                'failed_jobs',
            ];

            // Filter tables that exist in SQLite
            $tablesToMigrate = array_intersect($tableOrder, $tables);

            $this->info('Tabel yang akan dimigrasikan: ' . implode(', ', $tablesToMigrate));

            // Start transaction
            DB::beginTransaction();

            try {
                foreach ($tablesToMigrate as $table) {
                    $this->migrateTable($sqlite, $table);
                }

                DB::commit();
                $this->info('Migrasi data berhasil!');
                return Command::SUCCESS;

            } catch (\Exception $e) {
                DB::rollBack();
                $this->error('Error saat migrasi: ' . $e->getMessage());
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Migrate a single table from SQLite to MySQL
     */
    protected function migrateTable(PDO $sqlite, string $table): void
    {
        $this->info("Memigrasikan tabel: $table");

        // Get data from SQLite
        $rows = $sqlite->query("SELECT * FROM $table")->fetchAll(PDO::FETCH_ASSOC);

        if (empty($rows)) {
            $this->line("  Tabel $table kosong, dilewati.");
            return;
        }

        $this->line("  Ditemukan " . count($rows) . " baris data.");

        // Get column names
        $columns = array_keys($rows[0]);

        // Insert data into MySQL
        $inserted = 0;
        $skipped = 0;

        foreach ($rows as $row) {
            try {
                // Prepare data (handle boolean and null values)
                $data = [];
                foreach ($row as $key => $value) {
                    if ($value === null) {
                        $data[$key] = null;
                    } elseif (is_numeric($value)) {
                        $data[$key] = $value;
                    } else {
                        $data[$key] = $value;
                    }
                }

                // Handle different table types
                $exists = false;
                $shouldUpdate = false;

                // For tables with composite primary keys (model_has_roles, model_has_permissions, role_has_permissions)
                if (in_array($table, ['model_has_roles', 'model_has_permissions', 'role_has_permissions'])) {
                    $query = DB::table($table);
                    foreach ($data as $key => $value) {
                        $query->where($key, $value);
                    }
                    $exists = $query->exists();
                } elseif (isset($row['id'])) {
                    // Tables with single id primary key
                    $exists = DB::table($table)->where('id', $row['id'])->exists();
                    $shouldUpdate = true;
                } elseif (isset($row['email'])) {
                    // For users table, check by email
                    $existing = DB::table($table)->where('email', $row['email'])->first();
                    if ($existing) {
                        $exists = true;
                        $shouldUpdate = true;
                        $data['id'] = $existing->id; // Keep existing ID
                    }
                }

                if ($exists) {
                    if ($shouldUpdate && isset($data['id'])) {
                        // Update existing record (for users, roles, etc.)
                        $id = $data['id'];
                        unset($data['id']); // Remove id from update data
                        DB::table($table)->where('id', $id)->update($data);
                        $inserted++;
                    } else {
                        // Skip if it's a composite key table and already exists
                        $skipped++;
                    }
                } else {
                    // Insert new record
                    DB::table($table)->insert($data);
                    $inserted++;
                }

            } catch (\Exception $e) {
                $this->warn("  Error pada baris: " . $e->getMessage());
                // Continue with next row
            }
        }

        $this->line("  Selesai: $inserted inserted, $skipped skipped.");
    }
}