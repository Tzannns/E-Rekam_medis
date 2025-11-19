@php($settings = \App\Models\Pengaturan::first())
@php($logoPath = $settings?->logo ? storage_path('app/public/'.$settings->logo) : public_path('images/logo.png'))
<table style="width:100%; margin-bottom:12px; border:none;">
    <tr>
        <td style="width:30mm; vertical-align:middle; text-align:left; border:none; padding:0;">
            <img src="{{ $logoPath }}" alt="Logo" style="height:28mm; width:auto; display:block; object-fit:contain; image-rendering:crisp-edges;" />
        </td>
        <td style="vertical-align:middle; text-align:center; border:none; padding:0;">
            <div style="font-size:18px; font-weight:700; text-transform:uppercase;">{{ $settings->nama_instansi ?? 'POLITEKNIK UNGGULAN KALIMANTAN' }}</div>
            @if(!empty($settings?->alamat_instansi) || !empty($settings?->no_telp) || !empty($settings?->email) || !empty($settings?->website))
                <div style="font-size:11px;">
                    {{ $settings->alamat_instansi ?? 'Jl. Pangeran Hidayatullah RT. 14 Komplek Upik Futsal Benua Anyar Banjarmasin, Kalimantan Selatan 70122' }}
                </div>
                <div style="font-size:11px;">
                    Telp. {{ $settings->no_telp ?? '0511 – 4315505 & 6741131' }} | Email: {{ $settings->email ?? 'Official@polanka.ac.id' }} | Website: {{ $settings->website ?? 'polanka.ac.id' }}
                </div>
            @else
                <div style="font-size:11px;">Izin Pendirian: KEPUTUSAN MENDIKBUD NO.602/E/O/2014 Tanggal 17 Oktober 2014</div>
                <div style="font-size:11px;">Prodi D3: Farmasi, Fisioterapi, Teknik Elektromedik, Analis Kesehatan dan Rekam Medis & InfoKes</div>
            @endif
        </td>
        <td style="width:30mm; border:none; padding:0;"></td>
    </tr>
</table>
<div style="height:3px; background:#000; margin-bottom:8px;"></div>