<div class="container pt-5">
    <a href="<?= base_url('mahasiswa/tambah'); ?>" class="btn btn-success mb-2">Tambah Data</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Data Mahasiswa</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Foto Diri</th>
                            <th>Foto Ktp</th>
                            <th>Aksi</th>
                        </tr> 
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach($getMahasiswa as $isi): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $isi['nim']; ?></td>
                                <td><?= $isi['nama_mahasiswa']; ?></td>
                                <td><img src="<?= base_url('uploads/' . $isi['foto_diri']); ?>" alt="Foto Diri" width="100"></td>
                                <td><img src="<?= base_url('uploads/' . $isi['foto_ktp']); ?>" alt="Foto KTP" width="100"></td>
                                <td>
                                    <a href="<?= base_url('mahasiswa/edit/' . $isi['id_mahasiswa']); ?>" class="btn btn-success">Edit</a>
                                    <a href="<?= base_url('mahasiswa/hapus/' . $isi['id_mahasiswa']); ?>" 
                                    onclick="javascript:return confirm('Apakah ingin menghapus data mahasiswa ?')"
                                    class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody> 
                </table>
            </div>
        </div>
    </div>
</div>
