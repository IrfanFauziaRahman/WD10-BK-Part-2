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
                    <a href="<?= base_url('/adminDashboard') ?>" class="nav-link <?= url_is('/adminDashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
						<span class="badge badge-primary right">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/admin/dokter') ?>" class="nav-link <?= url_is('/admin/dokter') ? 'active' : '' ?>">
                        <i class="nav-icon 	fas fa-stethoscope"></i>
                        <p>Dokter</p>
						<span class="badge badge-primary right">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/admin/pasien') ?>" class="nav-link <?= url_is('/admin/pasien') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-user-injured"></i>
                        <p>Pasien</p>
						<span class="badge badge-primary right">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/admin/poli') ?>" class="nav-link <?= url_is('/admin/poli') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-hospital"></i>
                        <p>Poli</p>
						<span class="badge badge-primary right">Admin</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/admin/obat') ?>" class="nav-link <?= url_is('/admin/obat') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-pills"></i>
                        <p>Obat</p>
						<span class="badge badge-primary right">Admin</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
