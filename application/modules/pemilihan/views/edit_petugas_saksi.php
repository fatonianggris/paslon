<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Petugas Saksi</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Petugas Saksi</a></li>
                <li class="breadcrumb-item active">Edit Petugas Saksi</li>
            </ol>        
            <a href="<?php echo site_url('pemilihan/daftar_petugas_saksi/' . $pemilihan[0]->id_pemilihan . ''); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Pemilihan</button></a> 
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
                <h4 class="card-title">Edit Petugas Saksi</h4>
                <h6 class="card-subtitle">Edit Petugas Saksi terkait nama, petugas saksi dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/edit_petugas_saksi/' . $petugas_saksi[0]->id_saksi . '/' . $pemilihan[0]->id_pemilihan); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">                      
                        <div class="form-group col-md-6 m-t-5" id="saksi_baru_ktp">
                            <label>Nomor KTP Petugas <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <div class="input-group">                            
                                    <input type="text" name="nomor_ktp_saksi" value="<?php echo $petugas_saksi[0]->nomor_ktp_saksi; ?>" class="form-control" data-mask="9999999999999999" placeholder="Isikan nomor ktp petugas" readonly="" >
                                    <div class="input-group-append">
                                        <span class="input-group-text">Angka</span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-6 m-t-5" id="saksi_baru_nama">
                            <label>Nama Saksi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="text" name="nama_saksi" value="<?php echo strtoupper($petugas_saksi[0]->nama_saksi); ?>" class="form-control" placeholder="Isikan nama saksi" readonly="">
                            </fieldset>
                        </div>
                    </div>                   
                    <div class="col-md-12 row" id="saksi_baru">
                        <div class="form-group col-md-6 m-t-10" >
                            <label>Email Saksi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="email" name="email_saksi" value="<?php echo $petugas_saksi[0]->email_saksi; ?>" class="form-control" placeholder="Isikan email petugas" >
                            </fieldset>
                        </div>
                        <div class="form-group col-md-6 m-t-10">
                            <label>Nomor Handphone <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <div class="input-group">                            
                                    <input type="text" name="nomor_hp_saksi" value="<?php echo $petugas_saksi[0]->nomor_hp_saksi; ?>" class="form-control" data-mask="00000000000000">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Angka</span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>      
                    <div class="col-md-12 row m-b-10">
                        <div id="accordion2" class="minimal-faq col-md-12" aria-multiselectable="true">
                            <div class="card m-b-0">
                                <div class="card-header" role="tab" id="headingOne11">
                                    <h5 class="mb-0">
                                        <a class="link" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne11" aria-expanded="true" aria-controls="collapseOne11">
                                            ingin mengubah password?.
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne11" class="collapse form-group row">
                                    <div class="card-body row">
                                        <div class="col-md-4 m-t-10">
                                            <label>Password Lama <span class="text-danger">*</span></label>
                                            <fieldset class="controls">
                                                <div class="input-group">                            
                                                    <input type="password" name="password_lama" class="form-control">                                  
                                                </div>
                                            </fieldset>
                                        </div>
                                        <div class=" col-md-4 m-t-10">
                                            <label>Password Baru <span class="text-danger">*</span></label>
                                            <fieldset class="controls">
                                                <div class="input-group">                            
                                                    <input type="password" name="password_baru" class="form-control" id="c_pass_baru">                                 
                                                </div>
                                            </fieldset>
                                            <small id="info_pass_baru" class="form-control-feedback"></small>
                                        </div>
                                        <div class=" col-md-4 m-t-10">
                                            <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                            <fieldset class="controls">
                                                <div class="input-group">                            
                                                    <input type="password" name="conf_password_lama" class="form-control" id="c_pass_lama">                                  
                                                </div>
                                            </fieldset>
                                            <small id="info_pass_konf" class="form-control-feedback"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
<script>
    var a = document.getElementById('info_pass_baru');
    var b = document.getElementById('info_pass_konf');
    var pass_baru;
    var pass_konf_baru;

    $('input[id="c_pass_baru"]').on('input', function () {
        pass_baru = $(this).val();
        if ($(this).val().length < 5) {
            a.innerHTML = "<b class='text-danger'>*Password harus lebih dari 5 karakter</b>";
        } else {
            a.innerHTML = "";
            if ($(this).val() != pass_konf_baru) {
                b.innerHTML = "<b class='text-danger'>*Password tidak sesuai</b>";
            } else if ($(this).val() == pass_konf_baru) {
                b.innerHTML = "<b class='text-success'>*Password sesuai</b>";
            }
        }
    });

    $('input[id="c_pass_lama"]').on('input', function () {
        pass_konf_baru = $(this).val()
        if ($(this).val() != pass_baru) {
            b.innerHTML = "<b class='text-danger'>*Password tidak sesuai</b>";
        } else {
            b.innerHTML = "<b class='text-success'>*Password sesuai</b>";
        }
    });
</script>


