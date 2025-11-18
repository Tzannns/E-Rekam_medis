<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pengingat Jadwal Periksa',
            'message' => "Anda memiliki jadwal periksa besok di {$this->appointment->poli->nama_poli} pukul {$this->appointment->jam_usulan}. Nomor antrian: {$this->appointment->nomor_antrian}. Harap datang tepat waktu.",
            'appointment_id' => $this->appointment->id,
            'nomor_antrian' => $this->appointment->nomor_antrian,
            'icon' => 'bell',
            'color' => 'yellow',
            'url' => route('pasien.appointment.index'),
        ];
    }
}
