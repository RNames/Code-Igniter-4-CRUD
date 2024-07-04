<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\Mahasiswa_model;

class Mahasiswa extends Controller
{
    public function index()
    {
        $model = new Mahasiswa_model;
        $data['title'] = 'Data Mahasiswa';
        $data['getMahasiswa'] = $model->getMahasiswa();
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

        // Handling Foto Diri upload
        $fotoDiri = $this->request->getFile('foto_diri');
        if ($fotoDiri && $fotoDiri->isValid()) {
            $newFotoDiriName = $fotoDiri->getRandomName();
            $fotoDiri->move('uploads', $newFotoDiriName); // Save to public/uploads
            $data['foto_diri'] = $newFotoDiriName;
        }

        // Handling Foto KTP upload
        $fotoKtp = $this->request->getFile('foto_ktp');
        if ($fotoKtp && $fotoKtp->isValid()) {
            $newFotoKtpName = $fotoKtp->getRandomName();
            $fotoKtp->move('uploads', $newFotoKtpName); // Save to public/uploads
            $data['foto_ktp'] = $newFotoKtpName;
        }

        $model->saveMahasiswa($data);
        $session = session();
        $session->setFlashdata('message', 'Sukses Tambah Data Mahasiswa');
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
        $model = new Mahasiswa_model();
        $id = $this->request->getPost('id_mahasiswa');

        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_mahasiswa' => $this->request->getPost('nama'),
        ];

        // Handling Foto Diri upload
        $fotoDiri = $this->request->getFile('foto_diri');
        if ($fotoDiri && $fotoDiri->isValid()) {
            $newFotoDiriName = $fotoDiri->getRandomName();
            $fotoDiri->move('uploads', $newFotoDiriName); // Save to public/uploads
            $data['foto_diri'] = $newFotoDiriName;
        }

        // Handling Foto KTP upload
        $fotoKtp = $this->request->getFile('foto_ktp');
        if ($fotoKtp && $fotoKtp->isValid()) {
            $newFotoKtpName = $fotoKtp->getRandomName();
            $fotoKtp->move('uploads', $newFotoKtpName); // Save to public/uploads
            $data['foto_ktp'] = $newFotoKtpName;
        }

        $model->editMahasiswa($data, $id);
        $session = session();
        $session->setFlashdata('message', 'Sukses Edit Data Mahasiswa');
        return redirect()->to(base_url('mahasiswa'));
    }

    public function hapus($id)
    {
        $model = new Mahasiswa_model;
        $getMahasiswa = $model->getMahasiswa($id);
        if ($getMahasiswa) {
            // Delete files if they exist
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
