<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Logout Button -->
        <li class="nav-item">
            <a href="<?= base_url('/logout') ?>" class="nav-link" onclick="return confirm('Anda yakin ingin logout?')">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->