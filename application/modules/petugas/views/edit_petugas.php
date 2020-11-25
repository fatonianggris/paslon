<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Petugas</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Petugas Recruitment Anggota</a></li>
                <li class="breadcrumb-item active">Edit Petugas Recruitment Anggota</li>
            </ol>   
            <a href="<?php echo site_url('petugas'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Petugas Recruitment</button></a> 
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
                <h4 class="card-title">Formulir Edit Petugas Recruitment Anggota</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir edit petugas recruitment anggota yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('petugas/edit_petugas/' . $petugas[0]->id_petugas); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Lengkap Petugas Recruitment <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_petugas" value="<?php echo $petugas[0]->nama_petugas; ?>" class="form-control" placeholder="Isikan nama lengkap petugas" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor KTP Petugas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="nomor_ktp" value="<?php echo $petugas[0]->nomor_ktp; ?>" class="form-control" placeholder="Isikan nomor ktp petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Email Petugas Recruitment <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="email" name="email_petugas" value="<?php echo $petugas[0]->email_petugas; ?>" class="form-control" placeholder="Isikan email petugas" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor Handphone <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="nomor_hp" value="<?php echo $petugas[0]->nomor_hp; ?>" data-mask="00000000000000" class="form-control" placeholder="Isikan nomor HP petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Regional Petugas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="region_petugas" class="select2 form-control custom-select" style="width: 100%; height:36px;" required id="region_petugas" data-validation-required-message="Kolom ini wajib diisi!">
                                <?php
                                if (!empty($admin_regional) && $petugas[0]->id_admin != null) {
                                    foreach ($admin_regional as $key => $value) {
                                        if ($value->id_ref == $petugas[0]->id_admin) {
                                            ?>
                                            <option value="<?php echo $petugas[0]->id_admin; ?>" selected="">
                                                <?php echo strtoupper($value->provinsi); ?>
                                                <?php
                                                if ($value->kabupaten != NULL) {
                                                    echo ' - ' . strtoupper($value->kabupaten);
                                                }
                                                ?>                                
                                            </option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <?php
                                if (!empty($admin_regional)) {
                                    foreach ($admin_regional as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id_ref; ?>">
                                            <?php echo strtoupper($value->provinsi); ?>
                                            <?php
                                            if ($value->kabupaten != NULL) {
                                                echo ' - ' . strtoupper($value->kabupaten);
                                            }
                                            ?>
                                        </option>                                     
                                        <?php
                                    }
                                }
                                ?>                        
                            </select>
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-8 m-t-10">
                        <label>Alamat Petugas Recruitment</label>
                        <input type="text" name="alamat_petugas" value="<?php echo $petugas[0]->alamat_petugas; ?>" class="form-control" placeholder="Isikan alamat petugas">
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-12 m-t-10">
                        <label>Kode Khusus Petugas</label>                     
                        <div class="input-group">    
                            <div class="input-group-prepend">
                                <span class="input-group-text"><b>Kode</b></span>
                            </div>
                            <input type="number" name="" class="form-control bold" value="<?php echo $petugas[0]->kode_petugas; ?>" required data-validation-required-message="Kolom ini wajib diisi" readonly="">
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>Terisi</b> Secara Otomatis dan ditunjukan kepada petugas untuk Login ! </small>
                    </div>   
                    <div class="form-group col-md-12 m-t-10">
                        <label>Foto Petugas Recruitment</label>
                        <fieldset class="controls">
                            <input type="text" name="image" value="<?php echo $petugas[0]->img ?>" style="display:none" />
                            <input type="text" name="image_thumb" value="<?php echo $petugas[0]->img_thumb; ?>" style="display:none" />
                            <input type="file" name="img" class="dropify" data-max-file-size="1M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $petugas[0]->img ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 MB</b> ! </small>
                        </fieldset>
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
                    <div class="form-group col-md-12 col m-t-10">
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
