<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

    <div class="card">
        <div class="card-body">
        
            <hr>
            <form action="/create-penilaian" method="POST">
                <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">No Pegawai</label>
                <select class="form-control" name="no_pegawai" id="pegawai">
                    <?php foreach ($penilaian as $value) : ?>
                        <option value="<?= $value['no_pegawai'] ?>">
                            <?= old('no_pegawai') == $value['no_pegawai'] ? 'selected' : ''?>>
                            <?= $value['no_pegawai']?> ===== <?= $value['nama']?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>    
            <div class="mb-3">
                <label class="form-label">Penilaian Kerja</label>
                <select name="penilaian_kerja" class="form-control">
                    <option selected>Pilih Penilaian</option>
                    <option value="sangat baik">Sangat Baik</option>
                    <option value="cukup">Cukup</option>
                    <option value="buruk">Buruk</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" name="keterangan">
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Penilaian</label>
                <input type="date" class="form-control" name="tgl_penilaian">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Data</button>
            </form>
        </div>
    </div>

    <?= $this->endsection('content'); ?>
