<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
        <div class="card-body">
            <a href="/create-penilaian">
            <button type="button" class="btn btn-primary">Tambah Data</button>
            </a>
            <a href="/exportword">
            <button type="button" class="btn btn-info">Cetak Data</button>
            </a>
            <hr>
            <?php if (session()->getFlashdata('succes')) : ?>
            <div class="alert alert-primary" role="alert">
                <?= session()->getFlashdata('succes') ?>
            </div>
            <?php endif; ?>
            <hr>
            <table class="table" id="example">
                <thead>
                    <tr>
                        <th scope="col">No Table</th>
                        <th scope="col">No Pegawai</th>
                        <th scope="col">Nama Pegawai</th>
                        <th scope="col">Penilaian Kerja</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Tanggal Penilaian</th>
                        <th scope="col">AKsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; 
                    foreach ($data_penilaian as $value) : ?>
                    <tr>
                        <th scope="row"><?= $no++ ?></th>
                        <td><?= $value['no_pegawai'] ?></td>
                        <td><?= $value['nama'] ?></td>
                        <td>
                            <?php if($value['penilaian_kerja'] == "sangat baik"){
                                echo '<span class="badge bg-success">Sangat Baik</span>';
                            } else if ($value['penilaian_kerja'] == "cukup"){
                                echo '<span class="badge bg-info text-dark">Cukup</span>';
                            } else {
                                echo '<span class="badge bg-danger">Buruk</span>';
                            }
                            ?>
                            <td><?= $value['keterangan'] ?></td>
                            <td><?= $value['tgl_penilaian'] ?></td>
                        </td>
                        <td>
                        <!--FUNGSI UBAH DAN HAPUS PENILAIAN -->
                            <a href="/penilaian-edit/<?= $value['id_tbl_penilaian'] ?>"><button type="button" class="btn btn-info">Ubah</button></a>
                            <?php if (has_permission("data-pegawai")):?>
                            <a href="/penilaian-hapus/<?= $value['id_tbl_penilaian'] ?>"><button type="button" class="btn btn-danger" onclick="return confirm('Apakah Anda Yakin Menghapus Data Ini?')">Hapus</button></a>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endsection('content'); ?>