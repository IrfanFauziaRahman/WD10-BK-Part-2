<h3 class="mb-4 text-center">Daftar Poli</h3>
<div class="row d-flex ml-2"> <!-- Menggunakan d-flex untuk membuat elemen tetap berada di satu baris -->
    <!-- Form Daftar Poli -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                Daftar Poli
            </div>
            <div class="card-body">
                <form action="#" method="post">
                    <div class="mb-3">
                        <label for="no_rm" class="form-label">Nomor Rekam Medis</label>
                        <input type="text" id="no_rm" name="no_rm" class="form-control" value="202412-073" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="poli" class="form-label">Pilih Poli</label>
                        <select id="poli" name="poli" class="form-control" required>
                            <option value="">Open this select menu</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Anak">Poli Anak</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jadwal" class="form-label">Pilih Jadwal</label>
                        <select id="jadwal" name="jadwal" class="form-control" required>
                            <option value="">Open this select menu</option>
                            <option value="Senin, 08:00-10:00">Senin, 08:00-10:00</option>
                            <option value="Selasa, 10:00-12:00">Selasa, 10:00-12:00</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keluhan" class="form-label">Keluhan</label>
                        <textarea id="keluhan" name="keluhan" class="form-control" rows="3" placeholder="Keluhan Anda"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Daftar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Riwayat Daftar Poli -->
    <div class="col-md-8"> <!-- Menggunakan offset-md-1 agar ada jarak antara form dan tabel -->
        <div class="card">
            <div class="card-header bg-primary text-white text-center">
                Riwayat daftar poli
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 15%;">Poli</th>
                        <th style="width: 20%;">Dokter</th>
                        <th style="width: 10%;">Hari</th>
                        <th style="width: 10%;">Mulai</th>
                        <th style="width: 10%;">Selesai</th>
                        <th style="width: 10%;">Antrian</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
