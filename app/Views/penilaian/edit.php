<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

    <div class="card">
        <div class="card-body">
        
            <hr>
            <form action="/penilaian-edit/<?= $result['id_tbl_penilaian']?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

            <div class="col-sm-12">
                <label class="form-label">Penilaian</label>
                <select class="form-control" name="no_pegawai">
                    <?php foreach ($penilaian as $value) : ?>
                        <option value="<?= $value['no_pegawai'] ?>"
                            <?= old('no_pegawai', $result['no_pegawai']) == $value['no_pegawai'] ? 'selected' : ''?>>
                            <?= $value['no_pegawai']?> ===== <?= $value['nama']?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>    
            <div class="mb-3">
                <label class="form-label">Penilaian Kerja</label>
                <div class="col-sm--12">
                <select name="penilaian_kerja" class="form-control">
                    <option value="<?= $result['penilaian_kerja']?>"> <?= $result['penilaian_kerja'] ?></option>
                    <option value="sangat baik">Sangat Baik</option>
                    <option value="cukup">Cukup</option>
                    <option value="buruk">Buruk</option>
                </select>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan" value="<?=old('keterangan', $result['keterangan'])?>">
            </div>
            <!--
            <div class="mb-3">
                <label class="form-label">Tanggal Penilaian</label>
                <input type="date" class="form-control" name="tgl_penilaian">
            </div> -->
            <button type="submit" class="btn btn-primary">Edit Data</button>
            </form>
            <hr>
            <a href="/penilaian">
                <button class="btn btn-warning">Kembali</button>
            </a>
        </div>
    </div>

    <?= $this->endsection('content'); ?>
