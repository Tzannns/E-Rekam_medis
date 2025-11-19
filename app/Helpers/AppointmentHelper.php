<?php

namespace App\Helpers;

use App\Models\Appointment;

class AppointmentHelper
{
    /**
     * Get active queue count for a specific jadwal
     */
    public static function getActiveQueueCount(int $jadwalId): int
    {
        return Appointment::where('jadwal_id', $jadwalId)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->count();
    }

    /**
     * Get queue position for a specific appointment
     */
    public static function getQueuePosition(Appointment $appointment): ?int
    {
        if (! $appointment->jadwal_id) {
            return null;
        }

        return Appointment::where('jadwal_id', $appointment->jadwal_id)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->where('nomor_antrian', '<=', $appointment->nomor_antrian)
            ->count();
    }

    /**
     * Check if patient can take appointment for specific jadwal
     */
    public static function canTakeAppointment(int $pasienId, int $jadwalId): bool
    {
        $existingAppointment = Appointment::where('pasien_id', $pasienId)
            ->where('jadwal_id', $jadwalId)
            ->whereIn('status', ['Menunggu', 'Diproses', 'Disetujui'])
            ->exists();

        return ! $existingAppointment;
    }

    /**
     * Get status badge color
     */
    public static function getStatusBadgeClass(string $status): string
    {
        return match ($status) {
            'Disetujui' => 'bg-green-100 text-green-800',
            'Diproses' => 'bg-blue-100 text-blue-800',
            'Menunggu' => 'bg-yellow-100 text-yellow-800',
            'Dibatalkan' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Check if appointment can be cancelled
     */
    public static function canBeCancelled(Appointment $appointment): bool
    {
        return in_array($appointment->status, ['Menunggu', 'Diproses']);
    }

    /**
     * Get max queue limit per jadwal
     */
    public static function getMaxQueueLimit(): int
    {
        return 30;
    }

    /**
     * Check if jadwal is full
     */
    public static function isJadwalFull(int $jadwalId): bool
    {
        $currentQueue = self::getActiveQueueCount($jadwalId);

        return $currentQueue >= self::getMaxQueueLimit();
    }
}
