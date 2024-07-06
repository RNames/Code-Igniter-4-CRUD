<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Mahasiswa_model; // Make sure to include your model class

class Mahasiswa extends Controller
{
    protected $mahasiswa_model; // Define a property for the model

    public function __construct()
    {
        $this->mahasiswa_model = new Mahasiswa_model(); // Load the model in the constructor
    }

    public function index()
    {
        $data['title'] = 'Data Mahasiswa';
        $data['getMahasiswa'] = $this->mahasiswa_model->getMahasiswa(); // Use $this->mahasiswa_model to access model methods
        echo view('header_view', $data);
        echo view('mahasiswa_view', $data);
        echo view('footer_view', $data);
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Data Mahasiswa';
        echo view('header_view', $data);
        echo view('tambah_view', $data);
        echo view('footer_view', $data);
    }

    public function add()
    {
        $model = new Mahasiswa_model();
        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_mahasiswa' => $this->request->getPost('nama'),
        ];

        // Handling cropped Foto Diri upload
        $croppedFotoDiri = $this->request->getPost('cropped_foto_diri');
        if ($croppedFotoDiri) {
            $croppedFotoDiri = str_replace('data:image/jpeg;base64,', '', $croppedFotoDiri);
            $croppedFotoDiri = base64_decode($croppedFotoDiri);
            $newFotoDiriName = uniqid() . '.jpg';
            file_put_contents('uploads/' . $newFotoDiriName, $croppedFotoDiri);
            $data['foto_diri'] = $newFotoDiriName;
        } else {
            echo "cropped_foto_diri not set";
        }

        // Handling cropped Foto KTP upload
        $croppedFotoKtp = $this->request->getPost('cropped_foto_ktp');
        if ($croppedFotoKtp) {
            $croppedFotoKtp = str_replace('data:image/jpeg;base64,', '', $croppedFotoKtp);
            $croppedFotoKtp = base64_decode($croppedFotoKtp);
            $newFotoKtpName = uniqid() . '.jpg';
            file_put_contents('uploads/' . $newFotoKtpName, $croppedFotoKtp);
            $data['foto_ktp'] = $newFotoKtpName;
        } else {
            echo "cropped_foto_ktp not set";
        }

        $model->saveMahasiswa($data);
        return redirect()->to(base_url('mahasiswa'));
    }

    public function edit($id)
    {
        $model = new Mahasiswa_model;
        $getMahasiswa = $model->getMahasiswa($id);
        
        if ($getMahasiswa) {
            $data['mahasiswa'] = $getMahasiswa;
            $data['title'] = 'Edit ' . $getMahasiswa['nama_mahasiswa'];

            echo view('header_view', $data);
            echo view('edit_view', $data);
            echo view('footer_view', $data);
        } else {
            $session = session();
            $session->setFlashdata('message', 'ID mahasiswa ' . $id . ' Tidak ditemukan');
            return redirect()->to(base_url('mahasiswa'));
        }
    }


 public function update()
    {
        $id = $this->request->getPost('id_mahasiswa');
        $nim = $this->request->getPost('nim');
        $nama = $this->request->getPost('nama');
        
        // Existing images
        $existing_foto_diri = $this->request->getPost('existing_foto_diri');
        $existing_foto_ktp = $this->request->getPost('existing_foto_ktp');
        
        // Cropped images
        $cropped_foto_diri = $this->request->getPost('cropped_foto_diri');
        $cropped_foto_ktp = $this->request->getPost('cropped_foto_ktp');
        
        // Use new cropped image if provided, otherwise use existing image
        $foto_diri = $cropped_foto_diri ? $this->save_image($cropped_foto_diri) : $existing_foto_diri;
        $foto_ktp = $cropped_foto_ktp ? $this->save_image($cropped_foto_ktp) : $existing_foto_ktp;
        
        // Update database with new data
        $data = [
            'nim' => $nim,
            'nama_mahasiswa' => $nama,
            'foto_diri' => $foto_diri,
            'foto_ktp' => $foto_ktp,
        ];
        
        $this->mahasiswa_model->update($id, $data); // Use $this->mahasiswa_model to call model methods
        return redirect()->to(base_url('mahasiswa'));
    }

    // Utility method to save base64 image to file
    private function save_image($image_data)
    {
        // Decode the base64 encoded image
        $image_parts = explode(";base64,", $image_data);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file_name = uniqid() . '.jpg';
        $file = 'uploads/' . $file_name;
        file_put_contents($file, $image_base64);
        return $file_name;
    }


    public function hapus($id)
    {
        $model = new Mahasiswa_model;
        $getMahasiswa = $model->getMahasiswa($id);
        if ($getMahasiswa) {
            if ($getMahasiswa['foto_diri'] && file_exists('uploads/' . $getMahasiswa['foto_diri'])) {
                unlink('uploads/' . $getMahasiswa['foto_diri']);
            }
            if ($getMahasiswa['foto_ktp'] && file_exists('uploads/' . $getMahasiswa['foto_ktp'])) {
                unlink('uploads/' . $getMahasiswa['foto_ktp']);
            }

            $model->hapusMahasiswa($id);
            $session = session();
            $session->setFlashdata('message', 'Hapus Data Mahasiswa Sukses');
            return redirect()->to(base_url('mahasiswa'));
        } else {
            $session = session();
            $session->setFlashdata('message', 'Hapus Gagal !, ID mahasiswa ' . $id . ' Tidak ditemukan');
            return redirect()->to(base_url('mahasiswa'));
        }
    }
}
