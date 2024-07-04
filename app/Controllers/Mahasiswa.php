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
        $model = new Mahasiswa_model();
        $id = $this->request->getPost('id_mahasiswa');

        $data = [
            'nim' => $this->request->getPost('nim'),
            'nama_mahasiswa' => $this->request->getPost('nama'),
            'foto_diri' => $this->request->getPost('croppedFotoDiri'), // Using cropped data
            'foto_ktp' => $this->request->getPost('croppedFotoKtp'),   // Using cropped data
        ];

        $model->editMahasiswa($data, $id);
        return redirect()->to(base_url('mahasiswa'));
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
