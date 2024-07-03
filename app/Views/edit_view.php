<div class="container p-5">
    <a href="<?= base_url('mahasiswa');?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Edit Mahasiswa : <?= $mahasiswa['nama_mahasiswa'];?></h4>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('mahasiswa/update');?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Nim</label>
                    <input type="number" value="<?= $mahasiswa['nim'];?>" name="nim" required class="form-control">         
                </div>
                <div class="form-group">
                    <label for="">Nama Mahasiswa</label>
                    <input type="text" value="<?= $mahasiswa['nama_mahasiswa'];?>" name="nama" required class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Foto Diri</label>
                    <input type="file" name="foto_diri" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Foto KTP</label>
                    <input type="file" name="foto_ktp" class="form-control">
                </div>
                <input type="hidden" value="<?= $mahasiswa['id_mahasiswa'];?>" name="id_mahasiswa">
                <button class="btn btn-success">Edit Data</button>
            </form>
        </div>
    </div>
</div>
