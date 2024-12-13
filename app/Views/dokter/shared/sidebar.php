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
                <a href="#" class="d-block">Admin</a>
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
                    <a href="<?= base_url('/jadwal') ?>" class="nav-link <?= url_is('/jadwal') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Jadwal Periksa</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/memeriksa') ?>" class="nav-link <?= url_is('/memeriksa') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Memeriksa Pasien</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/riwayatPasien') ?>" class="nav-link <?= url_is('/riwayatPasien') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>Riwayat Pasien</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/dokDashboard') ?>" class="nav-link <?= url_is('obat') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tree"></i>
                        <p>Profil</p>
						<span class="badge badge-success right">Dokter</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
