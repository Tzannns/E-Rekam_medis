<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentCreated extends Notification
{
    use Queueable;

    public function __construct(public Appointment $appointment) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $jadwal = $this->appointment->jadwal;
        
        return [
            'title' => 'Antrian Berhasil Diambil',
            'message' => "Anda berhasil mengambil antrian di {$this->appointment->poli->nama_poli} dengan nomor antrian {$this->appointment->nomor_antrian}. Tanggal: {$this->appointment->tanggal_usulan->format('d/m/Y')} pukul {$this->appointment->jam_usulan}.",
            'appointment_id' => $this->appointment->id,
            'nomor_antrian' => $this->appointment->nomor_antrian,
            'icon' => 'check-circle',
            'color' => 'green',
            'url' => route('pasien.appointment.index'),
        ];
    }
}
