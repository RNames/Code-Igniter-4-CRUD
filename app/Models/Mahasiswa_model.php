<?php 
namespace App\Models;
use CodeIgniter\Model;

class Mahasiswa_model extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $allowedFields = ['nim', 'nama_mahasiswa', 'foto_diri', 'foto_ktp'];

    public function getMahasiswa($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->find($id);
        }
    }

    public function saveMahasiswa($data)
    {
        return $this->insert($data);
    }

    public function editMahasiswa($data, $id)
    {
        return $this->update($id, $data);
    }

    public function hapusMahasiswa($id)
    {
        return $this->delete($id);
    }
}
