<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url('/') ?>" class="brand-link">
        <img src="<?= base_url('admin/img/Udinus.png') ?>" alt="Udinus" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Hospital</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('admin/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Dokter</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('/dokDashboard') ?>" class="nav-link <?= url_is('/dokDashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/dokter/jadwal') ?>" class="nav-link <?= url_is('/dokter/jadwal') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-calendar-check"></i>
                        <p>Jadwal Periksa</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/dokter/memeriksa') ?>" class="nav-link <?= url_is('/dokter/memeriksa') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-stethoscope"></i>
                        <p>Memeriksa Pasien</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/dokter/riwayat') ?>" class="nav-link <?= url_is('/dokter/riwayat') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Pasien</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/dokter/profil') ?>" class="nav-link <?= url_is('/dokter/profil') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profil</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
