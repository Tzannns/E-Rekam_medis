<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusUpdated extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $statusMessages = [
            'Menunggu' => 'sedang menunggu konfirmasi',
            'Diproses' => 'sedang diproses oleh petugas',
            'Disetujui' => 'telah disetujui',
            'Dibatalkan' => 'telah dibatalkan',
        ];

        $message = "Antrian Anda di {$this->appointment->poli->nama_poli} {$statusMessages[$this->newStatus]}.";

        if ($this->newStatus === 'Disetujui' && $this->appointment->dokter) {
            $message .= " Dokter: {$this->appointment->dokter->user->name}.";
        }

        if ($this->appointment->catatan_admin) {
            $message .= " Catatan: {$this->appointment->catatan_admin}";
        }

        return [
            'title' => 'Status Antrian Diupdate',
            'message' => $message,
            'appointment_id' => $this->appointment->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'icon' => $this->getIcon($this->newStatus),
            'color' => $this->getColor($this->newStatus),
            'url' => route('pasien.appointment.index'),
        ];
    }

    private function getIcon(string $status): string
    {
        return match ($status) {
            'Disetujui' => 'check-circle',
            'Diproses' => 'clock',
            'Dibatalkan' => 'x-circle',
            default => 'bell',
        };
    }

    private function getColor(string $status): string
    {
        return match ($status) {
            'Disetujui' => 'green',
            'Diproses' => 'blue',
            'Dibatalkan' => 'red',
            default => 'gray',
        };
    }
}
