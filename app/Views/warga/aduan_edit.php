<?= $this->extend('layouts'); ?>
<?= $this->section('content'); ?>
<div class="section">
    <div class="section-header">
        <h1 class="text-<?= userColor() ?>">Tambah Data Aduan</h1>
    </div>

    <div class="card card-body" id="tambahAduan">
        <form action="<?= base_url('warga/aduan/update') ?>" method="post" id="fAddAduan" enctype="multipart/form-data">
            <input type="hidden" name="nomor_aduan" id="nomor" value="<?= end($segments) ?>">
            <input type="hidden" name="foto" id="nomor" value="<?= $aduan->foto ?>">
            <div class="mb-3">
                <h6 class="font-weight-bold text-<?= userColor() ?>">Data Pelapor</h6>
                <div class="dropdown-divider"></div>
                <div class="progress load_user_input my-3" style="display:none;">
                    <div class="progress-bar-animated progress-bar-striped bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="users">Pilih Pengguna</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="<?= user()->nama ?>" readonly>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?= user()->jenis_kelamin ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tempat_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= user()->tempat_lahir ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <input type="text" class="form-control" id="agama" name="agama" value="<?= user()->agama ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= user()->tanggal_lahir ?>" readonly>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="<?= user()->pekerjaan ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nomor_hp">Nomor HP</label>
                                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?= user()->nomor_hp ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" readonly style="height: 136px;"><?= user()->alamat ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <h6 class="font-weight-bold text-<?= userColor() ?>">Detail Aduan</h6>
                <div class="dropdown-divider"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jenis_aduan">Jenis Aduan</label>
                            <select class="custom-select" id="jenis_aduan" name="jenis_aduan">
                                <option value="-">Pilih Jenis Aduan</option>
                                <option <?= $aduan->jenis == 'kehilangan' ? 'selected' : '' ?> value="kehilangan">Kehilangan</option>
                                <option <?= $aduan->jenis == 'pencurian' ? 'selected' : '' ?> value="pencurian">Pencurian</option>
                                <option <?= $aduan->jenis == 'kejadian' ? 'selected' : '' ?> value="kejadian">Kejadian</option>
                                <option <?= $aduan->jenis == 'kecelakaan' ? 'selected' : '' ?> value="kecelakaan">Kecelakaan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_kejadian">Waktu Kejadian</label>
                            <input type="datetime-local" class="form-control" id="tanggal_kejadian" value="<?= $aduan->tanggal ?>" name="tanggal_kejadian">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" id="judul" placeholder="kejadian apa yang terjadi" value="<?= $aduan->judul ?>" name="judul">
                </div>
                <div class="form-group">
                    <label for="keterangan">Keterangan</label>
                    <textarea class="form-control" id="keterangan" name="keterangan" style="height: 100px;" placeholder="Jelaskan mengenai hal yang dilaporkan"><?= $aduan->keterangan ?></textarea>
                </div>
                <div class="form-group">
                    <label for="lokasi">Lokasi Kejadian</label>
                    <textarea class="form-control" id="lokasi" name="lokasi" style="height: 100px;" placeholder="Tuliskan detail lokasi kejadian"><?= $aduan->lokasi ?></textarea>
                </div>

                <div class="form-group">
                    <label for="foto_aduan">Foto Aduan</label>
                    <input type="file" class="form-control" id="foto_aduan" name="foto_aduan">
                </div>

                <?php 
                    // if $aduan->foto is url
                    if (filter_var($aduan->foto, FILTER_VALIDATE_URL)) {
                        $foto = $aduan->foto;
                    } else {
                        $foto = base_url('foto_kejadian/' . $aduan->foto);
                    }
                ?>

                <img src="<?= $foto ?>" width="250px" class="img-fluid fotoKejadian">
            </div>
            <div class="float-right">
                <button type="submit" class="btn btn-<?= userColor() ?> shadow"><i class="fa fa-save"></i> SIMPAN</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>



<?= $this->section('topLibrary'); ?>
<style>
    .error {
        color: red !important;
        border-color: red !important;
    }
</style>

<link rel="stylesheet" href="http://localhost:8080/assets/modules/chocolat/css/chocolat.css">
<?= $this->endSection(); ?>



<?= $this->section('bottomLibrary'); ?>
<!-- validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
<script src="http://localhost:8080/assets/modules/chocolat/js/jquery.chocolat.min.js"></script>

<script>
    $(document).ready(function() {
        $.validator.addMethod("myfield", function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Username must contain only letters, numbers, or dashes.");

        $.validator.addMethod('mym', function(val, ele) {
            return this.optional(ele) || /^[a-z0-9\-\s\.\,\_\;\:\?\/\\\|\[\]\{\}\`\~\!\@\#\$\%\^\&\*\(\)\+\=\']{1,}$/i.test(val);
        }, 'this field not valid');

        $.validator.addMethod("selectEq", function(value, element, arg) {
            return arg !== value;
        }, `this field not valid`);

        const fAddAfuan_rules = {
            jenis_aduan: {
                required: true,
                selectEq: '-'
            },
            tanggal_kejadian: {
                required: true
            },
            judul: {
                required: true,
                mym: true
            },
            keterangan: {
                required: true,
                mym: true
            },
            lokasi: {
                required: true,
                mym: true
            }
        };

        // fAddAduan validation
        $('#fAddAduan').validate({
            rules: fAddAfuan_rules
        });

        // fotoKejadian on click chocolat
        $('.fotoKejadian').on('click', function() {
            $('.fotoKejadian').Chocolat();
        });
    });
</script>
<?= $this->endSection(); ?>