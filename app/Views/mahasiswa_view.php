<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .center-img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            cursor: pointer;
            border: 2px solid #ddd; /* Add a border around the image */
            padding: 5px;
            border-radius: 5px;
        }
        .modal-body {
            text-align: center; /* Center the modal image */
        }
        #modalImage {
            display: inline-block; /* Make sure the image respects the text-align center */
        }
    </style>
</head>
<body>
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
                                    <td><img src="<?= base_url('uploads/' . $isi['foto_diri']); ?>" alt="Foto Diri" class="center-img" style="width: 100px; height: auto;"></td>
                                    <td><img src="<?= base_url('uploads/' . $isi['foto_ktp']); ?>" alt="Foto KTP" class="center-img" style="width: 150px; height: auto;"></td>
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

    <!-- Modal HTML -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Foto" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.center-img').on('click', function() {
                var src = $(this).attr('src');
                $('#modalImage').attr('src', src);
                $('#imageModal').modal('show');
            });
        });
    </script>
</body>
</html>
