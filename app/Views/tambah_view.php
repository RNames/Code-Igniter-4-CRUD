<div class="container p-5">
    <a href="<?= base_url('mahasiswa'); ?>" class="btn btn-secondary mb-2">Kembali</a>
    <div class="card">
        <div class="card-header bg-info text-white">
            <h4 class="card-title">Tambah Data Mahasiswa</h4>
        </div>
        <div class="card-body">
            <form id="mahasiswaForm" method="post" action="<?= base_url('mahasiswa/add'); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
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
                    <input type="file" name="foto_diri" accept="image/*" required class="form-control" id="fotoDiriInput">
                    <input type="hidden" name="cropped_foto_diri" id="croppedFotoDiri">
                    <small class="form-text text-muted">Klik tombol 'Selanjutnya' untuk crop foto.</small>
                </div>
                <div class="form-group">
                    <label for="foto_ktp">Foto KTP</label>
                    <input type="file" name="foto_ktp" accept="image/*" required class="form-control" id="fotoKtpInput">
                    <input type="hidden" name="cropped_foto_ktp" id="croppedFotoKtp">
                    <small class="form-text text-muted">Klik tombol 'Selanjutnya' untuk crop foto.</small>
                </div>
                <button class="btn btn-success" type="button" onclick="validateFormAndOpenModal()">Selanjutnya</button>
            </form>
        </div>
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document"> <!-- Changed modal-lg to modal-xl for extra large size -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Foto Diri</h5>
                        <div>
                            <img id="cropperFotoDiri" src="#" alt="Foto Diri" style="max-width: 100%; height: 600px;"> <!-- Increased height -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Foto KTP</h5>
                        <div>
                            <img id="cropperFotoKtp" src="#" alt="Foto KTP" style="max-width: 100%; height: 600px;"> <!-- Increased height -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="cropImages()">Crop & Save</button>
            </div>
        </div>
    </div>
</div>

<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    let cropperDiri, cropperKtp;

    function handleFileInput(input, cropperVarName) {
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const cropperOptions = {
                    aspectRatio: NaN,
                    viewMode: 1,
                    movable: true,
                    zoomable: true,
                    scalable: true,
                    rotatable: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true
                };
                if (cropperVarName === 'cropperDiri') {
                    cropperDiri = new Cropper(document.getElementById('cropperFotoDiri'), cropperOptions);
                    cropperDiri.replace(e.target.result);
                } else if (cropperVarName === 'cropperKtp') {
                    cropperKtp = new Cropper(document.getElementById('cropperFotoKtp'), cropperOptions);
                    cropperKtp.replace(e.target.result);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    document.getElementById('fotoDiriInput').addEventListener('change', function () {
        handleFileInput(this, 'cropperDiri');
    });

    document.getElementById('fotoKtpInput').addEventListener('change', function () {
        handleFileInput(this, 'cropperKtp');
    });

    function validateFormAndOpenModal() {
        const nim = document.getElementsByName('nim')[0].value;
        const nama = document.getElementsByName('nama')[0].value;
        const fotoDiri = document.getElementsByName('foto_diri')[0].value;
        const fotoKtp = document.getElementsByName('foto_ktp')[0].value;

        if (nim && nama && fotoDiri && fotoKtp) {
            $('#cropperModal').modal('show');
        } else {
            alert('Mohon lengkapi semua data sebelum melanjutkan.');
        }
    }

    function cropImages() {
        if (cropperDiri) {
            const canvasDiri = cropperDiri.getCroppedCanvas();
            document.getElementById('croppedFotoDiri').value = canvasDiri.toDataURL('image/jpeg');
        }
        if (cropperKtp) {
            const canvasKtp = cropperKtp.getCroppedCanvas();
            document.getElementById('croppedFotoKtp').value = canvasKtp.toDataURL('image/jpeg');
        }
        document.getElementById('mahasiswaForm').submit();
    }
</script>
