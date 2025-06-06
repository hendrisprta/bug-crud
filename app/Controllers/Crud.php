<?php

namespace App\Controllers;
use App\Models\CrudModel;
use App\Models\DepartemenModel;

define('_TITLE','CRUD');

class Crud extends BaseController
{
    private $crud_model, $departemen_model;
    private $_defaulting;
    public function __construct()
    {
        $this->crud_model = new CrudModel();
        $this->departemen_model = new DepartemenModel();
        $this->_defaulting = "default.png";
    }
    public function index()
    {
        $data_crud = $this->crud_model->getPegawai();

        $data = [
            'title' => _TITLE,
            'data_crud' => $data_crud
        ];

        return view('crud/index', $data);
    }
//FUNGSI CREATE
    public function create()
    {
        $data = [
            'title' => _TITLE,
            //Untuk memanggil dari tbl departemen
            'departemen' => $this->departemen_model->orderby('nama_departemen')->findAll(),
            'validation' => \Config\Services::validation()
        ];
    
        return view('crud/create', $data);
    }
    


    //FUNGSI SAVE NOTIF
    public function save()
    {
        //VALIDASI 
        if (!$this->validate([
            'no_pegawai' => [
                'rules' => 'required|is_unique[tbl_pegawai.no_pegawai]',
                'label' => 'No Pegawai',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} Sudah Ada',
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'label' => 'Nama',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto',
                'errors' =>[
                    'max_size' => '{field} Tidak boleh lebih dari 1MB',
                    'is_image' => '{field} File Bukan Gambar',
                    'mime_in' => '{field} File Bukan Gambar',
                ]
            ]
        ])) {
            return redirect()->to('/create-crud')->withInput();
        }
        //MINTAK FILE FOTO
        $file_foto = $this->request->getFile('foto');
        if ($file_foto->getError() === 4){
            $nama_file = $this->_defaulting;
        }else{
            $nama_file = $file_foto->getRandomName();
            $file_foto->move('img',$nama_file);
        }
        $this->crud_model->save([
            'no_pegawai' => $this->request->getVar('no_pegawai'),
            'nama' => $this->request->getVar('nama'),
            'id_departemen' => $this->request->getVar('id_departemen'),
            'foto' => $nama_file
        ]);
        session()->setFlashdata('succes','Data Berhasil Di Tambahkan');
        return redirect()->to('/crud');
    }
//END CREATE 

//FUNGSI EDIT
    public function edit($id)
    {
        $data_crud = $this->crud_model->where(['id_tbl_pegawai' => $id])->first();

        $data = [
            'title' => _TITLE,
            'result' => $data_crud,
            //Untuk memanggil dari tbl departemen
            'departemen' => $this->departemen_model->orderby('nama_departemen')->findAll(),
            'validation' => \Config\Services::validation()
        ];
        return view('crud/edit',$data);
    }

    //FUNGSI EDIT
    public function update($id)
    {
        //VALIDASI EDIT
        $no_lama = $this->request->getVar('no_lama');
        $dataNoLama = $this->crud_model->where(['id_tbl_pegawai'=>$id])->first();
        /*
        Jika no_pegawai yang baru dikirim dari form sama dengan yang lama, 
        maka aturan validasinya cukup 'required' saja (karena tidak ada perubahan, jadi tidak perlu cek unik).
        Tapi kalau berubah, maka harus validasi apakah no_pegawai yang baru unik 
        di tabel tbl_pegawai, dengan aturan 'required|is_unique[tbl_pegawai.no_pegawai]'
        . Bahasa mudah anggap username ig
        */
        if ($dataNoLama['no_pegawai'] == $this->request->getVar('no_pegawai')) {
            $rule_title = 'required';
        } else{
            $rule_title = 'required|is_unique[tbl_pegawai.no_pegawai]';
        }
        if (!$this->validate([
            'no_pegawai' => [
                'rules' => $rule_title,
                'label' => 'No Pegawai',
                'errors' => [
                    'required' => '{field} harus diisi',
                    'is_unique' => '{field} Sudah Ada',
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'label' => 'Nama',
                'errors' => [
                    'required' => '{field} harus diisi',
                ]
            ],
            'foto' => [
                'rules' => 'max_size[foto,1024]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'label' => 'Foto',
                'errors' =>[
                    'max-size' => '{field} Tidak boleh lebih dari 1MB',
                    'is_image' => '{field} File Bukan Gambar',
                    'mime_in' => '{field} File Bukan Gambar',
                ]
            ]
        ])) {
            return redirect()->to('/crud-edit/' . $no_lama)->withInput();
        }

        //EDIT FILE FOTO
        $file_foto = $this->request->getFile('foto');
        if ($file_foto->getError() === 4){
            $nama_file = $this->request->getVar('foto_lama');
        }else{
            $nama_file = $file_foto->getRandomName();
            $file_foto->move('img',$nama_file);

            $file_foto_lama = $dataNoLama['foto'];

            if($file_foto_lama != $this->_defaulting){
                unlink('img/'.$file_foto_lama);
            }
        }

        $this->crud_model->save([
            'id_tbl_pegawai' => $id,
            'no_pegawai' => $this->request->getVar('no_pegawai'),
            'nama' => $this->request->getVar('nama'),
            'id_departemen' => $this->request->getVar('id_departemen'),
            'foto'=> $nama_file
        ]);
        session()->setFlashdata('succes','Data Berhasil Diubah');
        return redirect()->to('/crud');
    }

    public function delete($id)
    {
        
        $dataNoLama = $this->crud_model->where(['id_tbl_pegawai'=>$id])->first();

        $file_foto_lama = $dataNoLama['foto'];

        $this->crud_model->delete($id);
        session()->setFlashdata('success','Data Berhasil Dihapus');
        
        if($file_foto_lama != $this->_defaulting){
            unlink('img/'.$file_foto_lama);
        }
        
        return redirect()->to('/crud');
    }
}