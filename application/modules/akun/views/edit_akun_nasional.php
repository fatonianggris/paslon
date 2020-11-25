<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Admin Nasional</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin Nasional</a></li>
                <li class="breadcrumb-item active">Edit Admin Nasional</li>
            </ol>        
            <a href="<?php echo site_url('akun/daftar_admin_nasional'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Admin Provinsi</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <!-- Column -->
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Formulir Edit Admin Nasional</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formilir edit admin nasional yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('akun/edit_admin_nasional/' . $admin_nasional[0]->id_user); ?>" enctype="multipart/form-data" method="post">          
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Lengkap Admin Nasional<span class="text-danger">*</span></label>
                        <input type="text" name="nama_admin" value="<?php echo $admin_nasional[0]->nama_admin; ?>" class="form-control" placeholder="Isikan nama lengkap admin nasional" required data-validation-required-message="Kolom ini wajib diisi">
                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Email Admin Nasional <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="<?php echo $admin_nasional[0]->email; ?>" class="form-control" placeholder="Isikan email admin nasional" required data-validation-required-message="Kolom ini wajib diisi">
                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                    </div>
                    <div class="form-group col-md-2 m-t-5">
                        <label>Status Admin Nasional<span class="text-danger">*</span></label>
                        <div class="custom-control custom-radio m-t-10">
                            <input type="radio" id="sts1" value="1" name="status" class="custom-control-input"  <?php echo ($admin_nasional[0]->status == '1') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="sts1">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="sts2" value="0" name="status" class="custom-control-input"  <?php echo ($admin_nasional[0]->status == '0') ? 'checked' : '' ?>>
                            <label class="custom-control-label" for="sts2">Tidak Aktif</label>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                    </div> 
                    <div class="form-group col-md-5 m-t-10">
                        <label>Nomor HP Admin Nasional<span class="text-danger">*</span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_hp" value="<?php echo $admin_nasional[0]->nomor_hp; ?>" class="form-control" data-mask="00000000000000" placeholder="Isikan nomor HP admin" required data-validation-required-message="Kolom ini wajib diisi">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                    </div>

                    <div class="form-group col-md-5 m-t-10">
                        <label>License Key Expired <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="license_exp" class="form-control" value="<?php echo $admin_nasional[0]->license_exp; ?>" placeholder="Tanggal Expired" id="license_date" required data-validation-required-message="Kolom ini wajib diisi!">                          
                        </div>
                        <small class="form-control-feedback">
                            <?php if ($admin_nasional[0]->license_exp == NULL or $admin_nasional[0]->license_exp == '') { ?>
                                <span class="label label-info">
                                    Masa Expired <b>Belum</b> Diinputkan
                                </span>
                            <?php } else { ?>
                                <?php
                                date_default_timezone_set("Asia/Jakarta");
                                $date = DateTime::createFromFormat('d/m/Y', $admin_nasional[0]->license_exp);
                                $newdate = $date->format('Y-m-d');
                                $from = strtotime($newdate);
                                $today = time();
                                $difference = $from - $today;
                                $hasil = floor($difference / 86400) + 1;
                                if ($hasil > 10) {
                                    ?>
                                    <span class="label label-success">
                                        <b><?php echo $hasil; ?></b> hari lagi
                                    </span>
                                <?php } elseif ($hasil <= 10 && $hasil > 0) { ?>
                                    <span class="label label-warning">
                                        <b><?php echo $hasil; ?></b> hari lagi
                                    </span>
                                <?php } elseif ($hasil <= 0) { ?>
                                    <span class="label label-danger">
                                        <b>Expired</b>
                                    </span>
                                <?php } ?>
                            <?php } ?>
                        </small>
                    </div>
                    <div class="form-group col-md-12 m-t-5">
                        <label>License Key (base 64) <span class="text-danger">*</span></label>
                        <div class="input-group"> 
                            <textarea class="form-control" rows="5" name="license" ><?php echo $admin_nasional[0]->license; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12 m-t-10">
                        <label>Foto Admin Nasional</label>
                        <input type="text" name="image" value="<?php echo $admin_nasional[0]->img ?>" style="display:none" />
                        <input type="text" name="image_thumb" value="<?php echo $admin_nasional[0]->img_thumb; ?>" style="display:none" />
                        <input type="file" name="img" class="dropify" data-max-file-size="1M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $admin_nasional[0]->img ?>"/>
                        <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 Mb</b> ! </small>
                    </div>  
                    <div class="col-md-12 row m-b-10">
                        <div id="accordion2" class="minimal-faq col-md-12" aria-multiselectable="true">
                            <div class="card m-b-0">
                                <div class="card-header" role="tab" id="headingOne11">
                                    <h5 class="mb-0">
                                        <a class="link" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne11" aria-expanded="true" aria-controls="collapseOne11">
                                            ingin mengubah password?. KLIK DISINI
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
                    <div class="form-group col-md-12 m-t-10">
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
