<div class="container py-4">
    <?php if (session('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <h3 class="mb-4">Profil Dokter</h3>

    <form action="/dokter/profil/update" method="POST">
        <?= csrf_field() ?>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-primary mb-4">
                            <i class="bi bi-person me-2"></i>
                            Informasi Pribadi
                        </h5>

                        <div class="mb-4">
                            <label for="nama_dokter" class="form-label text-muted">Nama Dokter</label>
                            <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" 
                                   value="<?= old('nama_dokter', $dokter['nama_dokter']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label text-muted">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" 
                                      rows="3" required><?= old('alamat', $dokter['alamat']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="text-primary mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Informasi Kontak
                        </h5>

                        <div class="mb-4">
                            <label for="no_hp" class="form-label text-muted">Nomor HP</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" 
                                   value="<?= old('no_hp', $dokter['no_hp']) ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4 gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-2"></i>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<style>
.card {
    border-radius: 8px;
    border: 1px solid rgba(0,0,0,.1);
}
.card-body {
    padding: 1.5rem;
}
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
}
.form-control {
    padding: 0.6rem 1rem;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}
.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
}
.btn {
    border-radius: 6px;
    font-weight: 500;
}
.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}
h5 {
    font-size: 1.1rem;
    font-weight: 600;
}
.alert {
    border-radius: 8px;
    margin-bottom: 1.5rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>