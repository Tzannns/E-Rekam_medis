// Real-time queue update untuk appointment
(function() {
    'use strict';

    const poli = document.getElementById('poli_id');
    const dokter = document.getElementById('dokter_id');
    const tanggal = document.getElementById('tanggal_usulan');
    const jadwal = document.getElementById('jadwal_id');

    if (!poli || !dokter || !tanggal || !jadwal) return;

    function refreshDokter() {
        const p = poli.value;
        if (!p) return;

        const url = new URL(window.location.href);
        url.searchParams.set('poli_id', p);
        url.searchParams.delete('dokter_id');
        url.searchParams.delete('tanggal_usulan');
        url.searchParams.delete('jadwal_id');
        window.location.href = url.toString();
    }

    function refreshJadwal() {
        const p = poli.value;
        const d = dokter.value;
        const t = tanggal.value;
        if (!p || !d || !t) return;

        const url = new URL(window.location.href);
        url.searchParams.set('poli_id', p);
        url.searchParams.set('dokter_id', d);
        url.searchParams.set('tanggal_usulan', t);
        url.searchParams.delete('jadwal_id');
        window.location.href = url.toString();
    }

    function selectJadwal() {
        const p = poli.value;
        const d = dokter.value;
        const t = tanggal.value;
        const j = jadwal.value;
        if (!p || !d || !t || !j) return;

        const url = new URL(window.location.href);
        url.searchParams.set('poli_id', p);
        url.searchParams.set('dokter_id', d);
        url.searchParams.set('tanggal_usulan', t);
        url.searchParams.set('jadwal_id', j);
        window.location.href = url.toString();
    }

    poli.addEventListener('change', refreshDokter);
    dokter.addEventListener('change', refreshJadwal);
    tanggal.addEventListener('change', refreshJadwal);
    jadwal.addEventListener('change', selectJadwal);

    // Auto-refresh queue setiap 30 detik jika ada jadwal terpilih
    const selectedJadwalId = new URLSearchParams(window.location.search).get('jadwal_id');
    if (selectedJadwalId) {
        setInterval(function() {
            // Reload halaman untuk update antrian
            window.location.reload();
        }, 30000); // 30 detik
    }
})();
