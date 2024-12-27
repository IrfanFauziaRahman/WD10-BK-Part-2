<h1 class="text-left mb-4 fw-bold text-primary text-center">Dashboard Admin</h1>
<div class="row g-4 m-3">
    <!-- Total Dokter -->
    <div class="col-md-3">
        <div class="card text-white bg-primary shadow h-100 position-relative">
            <div class="card-body">
                <div>
                    <h5 class="card-title fw-bold">Total Dokter</h5>
                    <p class="card-text display-4 fw-bold"><?= $total_dokter ?></p>
                </div>
                <i class="fas fa-user-md fa-5x position-absolute icon-overlay"></i>
            </div>
        </div>
    </div>
    <!-- Total Pasien -->
    <div class="col-md-3">
        <div class="card text-white bg-success shadow h-100 position-relative">
            <div class="card-body">
                <div>
                    <h5 class="card-title fw-bold">Total Pasien</h5>
                    <p class="card-text display-4 fw-bold"><?= $total_pasien ?></p>
                </div>
                <i class="fas fa-procedures fa-5x position-absolute icon-overlay"></i>
            </div>
        </div>
    </div>
    <!-- Total Poli -->
    <div class="col-md-3">
        <div class="card text-white bg-warning shadow h-100 position-relative">
            <div class="card-body">
                <div>
                    <h5 class="card-title fw-bold">Total Poli</h5>
                    <p class="card-text display-4 fw-bold"><?= $total_poli ?></p>
                </div>
                <i class="fas fa-hospital-alt fa-5x position-absolute icon-overlay"></i>
            </div>
        </div>
    </div>
    <!-- Total Obat -->
    <div class="col-md-3">
        <div class="card text-white bg-danger shadow h-100 position-relative">
            <div class="card-body">
                <div>
                    <h5 class="card-title fw-bold">Total Obat</h5>
                    <p class="card-text display-4 fw-bold"><?= $total_obat ?></p>
                </div>
                <i class="fas fa-pills fa-5x position-absolute icon-overlay"></i>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-overlay {
        top: 20px; /* Geser sedikit ke bawah */
        right: 20px; /* Geser sedikit ke kiri */
        opacity: 1;
        color: white;
        transform: translate(-10%, 10%); /* Penyesuaian lebih halus */
    }
    .position-absolute {
        position: absolute;
    }
</style>
