<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CrudModel;
use App\Models\PenilaianModel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;

//chatgpt
use PhpOffice\PhpWord\IOFactory;

define('_TITLE','Penilaian');

class Penilaian extends BaseController
{
    private $crud_model, $penilaian_model;
    public function __construct()
    {
        $this->crud_model = new CrudModel();
        $this->penilaian_model = new PenilaianModel();
    }
    public function index()
    {
        $data_penilaian = $this->penilaian_model->getDataPegawai();

        $data = [
            'title' => _TITLE,
            'data_penilaian' => $data_penilaian
        ];

        return view('penilaian/index', $data);
    }
//FUNGSI CREATE
    public function create()
    {
        $data = [
            'title' => _TITLE,
            'penilaian' => $this->crud_model->orderby('no_pegawai')->findAll(),
        ];
    
        return view('penilaian/create', $data);
    }
    


    //FUNGSI SAVE NOTIF
    public function save()
    {
        $this->penilaian_model->save([
            'no_pegawai' => $this->request->getVar('no_pegawai'),
            'penilaian_kerja' => $this->request->getVar('penilaian_kerja'),
            'keterangan' => $this->request->getVar('keterangan'),
            'tgl_penilaian' => $this->request->getVar('tgl_penilaian')
        ]);
        session()->setFlashdata('succes','Data Berhasil Di Tambahkan');
        return redirect()->to('/penilaian');
    }
//END CREATE 

//FUNGSI EDIT 
    public function edit($id)
    {
        $data_penilaian = $this->penilaian_model->where(['id_tbl_penilaian' => $id])->first();

        $data = [
            'title' => _TITLE,
            'result' => $data_penilaian,
            'penilaian' => $this->crud_model->orderBy('no_pegawai')->findAll()
        ];
        return view('penilaian/edit',$data);
    }


    //FUNGSI SAVE EDIT
    public function update($id)
    {
        $this->penilaian_model->save([
            'id_tbl_penilaian' => $id,
            'no_pegawai' => $this->request->getVar('no_pegawai'),
            'penilaian_kerja' => $this->request->getVar('penilaian_kerja'),
            'keterangan' => $this->request->getVar('keterangan')
        ]);
        session()->setFlashdata('succes','Data Berhasil Diubah');
        return redirect()->to('/penilaian');
    }

    public function delete($id)
    {
        $this->penilaian_model->delete($id);

        session()->setFlashdata('success','Data Berhasil Dihapus');
        return redirect()->to('/penilaian');
    }
    public function exportWord()
    {
        $phpword = new PhpWord();
        $phpword->addTitleStyle(1,['size' =>20, 'bold' => true], ['alignment' => 'center']);
        $section = $phpword->addSection(['orientation' => 'landscape']);
        $section->addImage('img/' . 'logo.png',[
            'width' => 100,
            'positioning' => 'relative',
            'poVertical' => 'top'
        ]);
        $section->addTitle("Laporan Data Penilaian Karyawan");
        $section->addText("PT Hendri CRUD", ['size' => 20], ['alignment' => 'center']);
        $section->addText("Jalan Langsat No 999, Kasongan, Yogyakarta", ['size' => 12], ['alignment' => 'center']);
        $section->addShape(
            'line',
            [
                'points' => '1,1 920,0',
                'outline' => [
                    'color' => '#212529',
                    'line' => 'thickThin',
                    'weight' => 3,
                ]
            ]
        );
        $table = $section->addTable(['bordersize' => 3]);
        $table->addRow();
        $table->addCell(1000)->addText('No');
        $table->addCell(5000)->addText('No Pegawai');
        $table->addCell(5000)->addText('Nama Pegawai');

        $table->addCell(5000)->addText('Penilaian Kerja');
        $table->addCell(5000)->addText('Keterangan');
        $table->addCell(5000)->addText('Tanggal Penilaian');

        $data_penilaian = $this->penilaian_model->getDataPegawai();
        $no = 1;

        foreach ($data_penilaian as $item){
            $table->addRow();
            $table->addCell()->addText($no++);
            $table->addCell()->addText($item['no_pegawai']);
            $table->addCell()->addText($item['nama']);
            $table->addCell()->addText($item['penilaian_kerja']);
            $table->addCell()->addText($item['keterangan']);
            $table->addCell()->addText($item['tgl_penilaian']);
        }
        $section->addTextBreak();
        $table = $section->addTable(['borderSize' => 0]);
        $table->addRow();
        $table->addCell(9000)->addText('');
        $table->addCell(5000)->addText('Direktur Hendri CRUD',['size' => 12], ['alignment' => 'center']);
        $section->addTextBreak(3);
        $table = $section->addTable(['borderSize' => 0]);
        $table->addRow();
        $table->addCell(9000)->addText('');
        $table->addCell(5000)->addText('Sagita Agustina',['size' => 12], ['alignment' => 'center']);

        /* $writer = new Word2007($phpword);
        $filename = "Data-penilaian-karyawan.docx";
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename". $filename);
        header("Cache-Control: max-age=0");

        $writer->save("php://output");
        */
        //chatgpt 
           $filename = "Data-penilaian-karyawan.docx";
    // Gunakan IOFactory dan header yang benar untuk .docx
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");
        header("Expires: 0");
        header("Pragma: public");

        $writer = IOFactory::createWriter($phpword, 'Word2007');
        $writer->save("php://output");
        exit;
    }
}