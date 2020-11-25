<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Petugas Saksi</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Petugas Saksi</a></li>
                <li class="breadcrumb-item active">Tambah Petugas Saksi</li>
            </ol>        
            <a href="<?php echo site_url('pemilihan/daftar_petugas_saksi/' . $pemilihan[0]->id_pemilihan . ''); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Petugas Saksi</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="tab-content">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Pemilihan</strong>
                                <br>
                                <p class="text-muted">
                                    <?php if ($pemilihan[0]->id_kategori_pemilihan == 1) { ?>
                                        PRESIDEN
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 2) { ?>
                                        DPR RI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 3) { ?>
                                        GURBERNUR
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 4) { ?>
                                        WALIKOTA
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 5) { ?>
                                        BUPATI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 6) { ?>
                                        DPRD PROVINSI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 7) { ?>
                                        DPRD KABUPATEN/KOTA
                                    <?php } ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Periode</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->tahun_pemilihan); ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_calon); ?></p>
                            </div>       
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Wakil Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_wakil_calon); ?></p>
                            </div>                                    
                        </div>                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Tambah Petugas Saksi</h4>
                <h6 class="card-subtitle">Tambah Petugas Saksi terkait nama, petugas saksi dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/kirim_petugas_saksi/' . $pemilihan[0]->id_pemilihan); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">
                        <div class="form-group col-md-3 m-t-5" >
                            <label>Kategori Pemilihan<span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kategori_petugas" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <option value="1" >SAKSI BARU</option> 
                                    <option value="2" selected>SAKSI DARI ANGGOTA</option>      
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-4 m-t-5" id="saksi_baru_ktp">
                            <label>Nomor KTP Petugas <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <div class="input-group">                            
                                    <input type="text" name="nomor_ktp_saksi" class="form-control" data-mask="9999999999999999" placeholder="Isikan nomor ktp petugas" >
                                    <div class="input-group-append">
                                        <span class="input-group-text">Angka</span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-5 m-t-5" id="saksi_baru_nama">
                            <label>Nama Saksi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="text" name="nama_saksi" class="form-control" placeholder="Isikan nama saksi" >
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12" id="saksi_anggota">
                            <label>Pilih Anggota Saksi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="anggota_saksi[]" class="select2 form-control select2-multiple" multiple="multiple" style="width: 100%; height:36px;" id="anggota" >
                                    <option value="">Pilih Anggota</option>
                                </select>
                            </fieldset>
                        </div>                                     
                    </div>
                    <div class="col-md-12 row" id="saksi_baru">
                        <div class="form-group col-md-6 m-t-10" >
                            <label>Email Saksi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="email" name="email_saksi" class="form-control" placeholder="Isikan email petugas" >
                            </fieldset>
                        </div>
                        <div class="form-group col-md-6 m-t-10">
                            <label>Nomor Handphone <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <div class="input-group">                            
                                    <input type="text" name="nomor_hp_saksi" class="form-control" data-mask="00000000000000">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Angka</span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="col-md-12 row" >
                        <div class="form-group col-md-6 m-t-10">
                            <label>Input Password <span class="text-danger">*</span></label>          
                            <fieldset class="controls">
                                <input type="password" name="password" value="12345" class="form-control" placeholder="Inputkan password" required data-validation-required-message="Kolom ini wajib diisi" >                        
                            </fieldset>
                            <small class="form-control-feedback">*Password default <b>12345</b></small>
                        </div>  
                        <div class="form-group col-md-6 m-t-10">
                            <label>Input Konfirmasi Password <span class="text-danger">*</span></label>  
                            <fieldset class="controls">
                                <input type="password" name="cf_passwd" value="12345" class="form-control" placeholder="Inputkan konfirmasi password" required data-validation-match-match="password" data-validation-required-message="Kolom ini wajib diisi"  >                       
                            </fieldset>
                        </div>
                    </div>
                    <div class="form-group col-md-12 m-t-5">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <button type="reset" onclick="history.back()" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- .row -->
<!-- Plugin JavaScript -->
<script>
    var url = "<?php echo site_url('pemilihan/add_ajax_anggota/' . $pemilihan[0]->id_admin); ?>";
    $('#anggota').load(url);
    
    $(document).ready(function () {
        var kategori_saksi = $('select[name="kategori_petugas"]');
        var id_kat = kategori_saksi.val();

        $(function () {

            document.getElementById("saksi_baru").hidden = true;
            document.getElementById("saksi_baru_ktp").hidden = true;
            document.getElementById("saksi_baru_nama").hidden = true;
            document.getElementById("saksi_anggota").hidden = false;

            kategori_saksi.change(function () {
                id_kat = $(this).val();

                if ($(this).val() == 1) {
                    document.getElementById("saksi_anggota").hidden = true;
                    document.getElementById("saksi_baru").hidden = false;
                    document.getElementById("saksi_baru_nama").hidden = false;
                    document.getElementById("saksi_baru_ktp").hidden = false;
                } else if ($(this).val() == 2) {
                    document.getElementById("saksi_baru").hidden = true;
                    document.getElementById("saksi_baru_ktp").hidden = true;
                    document.getElementById("saksi_baru_nama").hidden = true;
                    document.getElementById("saksi_anggota").hidden = false;
                }
            });
        });

        kategori_saksi.change(function () {
            var url = "<?php echo site_url('pemilihan/add_ajax_anggota/' . $pemilihan[0]->id_admin); ?>";
            $('#anggota').load(url);
            return false;
        })
    });
</script>

