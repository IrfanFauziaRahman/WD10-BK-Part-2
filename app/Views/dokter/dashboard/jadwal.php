<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">   
        <ol class="breadcrumb" style="justify-content: flex-end;">
            <li class="breadcrumb-item"><a href="/dokDashboard">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Jadwal Periksa</li>
        </ol>
    </nav>
    <!-- Table -->
    <div class="card">
        <!-- Title and Add Button -->
    <div class="d-flex justify-content-between align-items-center">
        <h3 class=" mt-3 ml-3">Daftar Jadwal Periksa</h3>
        <a href="#" class="btn btn-primary mt-3 mr-4">+ Tambah Jadwal Periksa</a>
    </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Nama Dokter</th>
                        <th>Hari</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Adi</td>
                        <td>Selasa</td>
                        <td>07:00</td>
                        <td>09:00</td>
                        <td><span class="badge bg-success">Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Adi</td>
                        <td>Rabu</td>
                        <td>08:30</td>
                        <td>10:20</td>
                        <td><span class="badge bg-secondary">Tidak Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Adi</td>
                        <td>Kamis</td>
                        <td>10:00</td>
                        <td>14:00</td>
                        <td><span class="badge bg-secondary">Tidak Aktif</span></td>
                        <td>
                            <a href="#" class="btn btn-sm btn-primary">Edit</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
