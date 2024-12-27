<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Poliklinik BK</title>
    <link href="<?= base_url('assets/css/adminlte.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <!-- Flash Message -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Register Form -->
                        <form action="<?= base_url('/auth/registerAction') ?>" method="post" class="mb-4">
                        <?= csrf_field() ?>
                            <div class="col-md-12 mb-3">
                                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                <input type="text" id="nama_pasien" name="nama_pasien" class="form-control" placeholder="Nama Pasien" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="no_ktp" class="form-label">Nomor KTP</label>
                                <input type="number" id="no_ktp" name="no_ktp" class="form-control" placeholder="Nomor KTP" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="Nomor HP" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>

                    </div>
                    <div class="card-footer text-center">
                        <small>Sudah punya akun? <a href="<?= base_url('/login') ?>" class="text-decoration-none">Sign in</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/adminlte.bundle.min.js') ?>"></script>
</body>

</html>