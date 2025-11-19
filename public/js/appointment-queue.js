// Appointment form - simple redirect on dropdown change
(function () {
    "use strict";

    function init() {
        const poli = document.getElementById("poli_id");
        const tanggal = document.getElementById("tanggal_usulan");
        const jadwal = document.getElementById("jadwal_id");

        if (!poli || !tanggal || !jadwal) {
            return;
        }

        function navigate() {
            const p = poli.value;
            const t = tanggal.value;
            const j = jadwal.value;

            const url = new URL(window.location.href);

            // Clear all params first
            url.search = "";

            // Set current values
            if (p) url.searchParams.set("poli_id", p);
            if (t) url.searchParams.set("tanggal_usulan", t);
            if (j) url.searchParams.set("jadwal_id", j);

            window.location.href = url.toString();
        }

        // Event listeners
        poli.addEventListener("change", navigate);
        tanggal.addEventListener("change", navigate);
        jadwal.addEventListener("change", navigate);

        // Auto-refresh queue setiap 30 detik jika ada jadwal terpilih
        const urlParams = new URLSearchParams(window.location.search);
        const selectedJadwalId = urlParams.get("jadwal_id");
        if (selectedJadwalId) {
            setInterval(function () {
                window.location.reload();
            }, 30000);
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
