<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= base_url('/') ?>" class="brand-link">
        <img src="<?= base_url('pasien/img/Udinus.png') ?>" alt="Udinus" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Hospital</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('pasien/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Pasien</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('/pasienDashboard') ?>" class="nav-link <?= url_is('/pasienDashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                        <span class="badge badge-warning right">Pasien</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('/pasien/poli') ?>" class="nav-link <?= url_is('/pasien/poli*') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Poli</p>
                        <span class="badge badge-warning right">Pasien</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>