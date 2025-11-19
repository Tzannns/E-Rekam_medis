<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAppointmentForAdmin extends Notification
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
            'title' => 'Antrian Baru Diterima',
            'message' => "Pasien {$this->appointment->pasien->user->name} mengambil antrian di {$this->appointment->poli->nama_poli}. Nomor antrian: {$this->appointment->nomor_antrian}.",
            'appointment_id' => $this->appointment->id,
            'nomor_antrian' => $this->appointment->nomor_antrian,
            'icon' => 'bell',
            'color' => 'blue',
            'url' => route('admin.appointment.index'),
        ];
    }
}
