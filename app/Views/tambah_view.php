<div class="container p-5">
    <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Tambah Data Mahasiswa</h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('mahasiswa/add'); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nim">Nim</label>
                    <input type="number" name="nim" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Mahasiswa</label>
                    <input type="text" name="nama" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="foto_diri">Foto Diri</label>
                    <input type="file" name="foto_diri" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="foto_ktp">Foto KTP</label>
                    <input type="file" name="foto_ktp" required class="form-control">
                </div>
                <button class="btn btn-success">Tambah Data</button>
            </form>
        </div>
    </div>
</div>
