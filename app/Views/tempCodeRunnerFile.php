<?php
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