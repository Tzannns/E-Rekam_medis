<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    use HasFactory;

    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
        'modul',
        'aksi',
        'detail',
        'ip_address',
        'user_agent',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity
     */
    public static function log($activity, $module = null, $action = null, $details = null, $ipAddress = null, $userAgent = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'aktivitas' => $activity,
            'modul' => $module,
            'aksi' => $action,
            'detail' => $details,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
            'waktu' => now(),
        ]);
    }

    /**
     * Get activities by module
     */
    public static function getByModule($module, $limit = 50)
    {
        return self::with('user')
            ->where('modul', $module)
            ->orderBy('waktu', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get activities by user
     */
    public static function getByUser($userId, $limit = 50)
    {
        return self::with('user')
            ->where('user_id', $userId)
            ->orderBy('waktu', 'desc')
            ->limit($limit)
            ->get();
    }
}