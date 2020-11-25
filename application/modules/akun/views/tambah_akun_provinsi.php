<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Admin Provinsi</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin Provinsi</a></li>
                <li class="breadcrumb-item active">Tambah Admin Provinsi</li>
            </ol> 
            <a href="<?php echo site_url('akun/daftar_admin_provinsi'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Admin Provinsi</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row" id="validation">
    <div class="col-12">
        <!-- Column -->
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card-body wizard-content">
                <h4 class="card-title">Formulir Tambah Admin & Petugas Provinsi</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah admin & petugas provinsi yang sesuai </h6>
                <form id="form_admin" class="form-horizontal m-t-20 validation-wizard wizard-circle" action="<?php echo site_url('akun/kirim_admin_provinsi'); ?>" enctype="multipart/form-data" method="post" >          
                    <!-- Step 1 -->
                    <h6>Formulir Admin</h6>
                    <section >
                        <div class="row">
                            <div class="form-group col-md-6 m-t-10" >
                                <label>Nama Lengkap Admin Provinsi <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="text" name="nama_admin" class="form-control" placeholder="Isikan nama lengkap admin provinsi" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-3 m-t-10">
                                <label>Hak Akses Admin Provinsi <span class="text-danger">*</span></label>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="create" value="1" checked="" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label" for="customCheck1">Create</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="read" value="1" checked class="custom-control-input" id="customCheck2" disabled="" >
                                    <label class="custom-control-label" for="customCheck2">Read</label>
                                </div>          
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                            </div>
                            <div class="form-group col-md-3 m-t-10">
                                <label></label>                        
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="update" value="1" checked="" class="custom-control-input" id="customCheck3">
                                    <label class="custom-control-label" for="customCheck3">Update</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="delete"value="1" checked="" class="custom-control-input" id="customCheck4">
                                    <label class="custom-control-label" for="customCheck4">Delete</label>
                                </div>
                            </div>                   
                            <div class="form-group col-md-6 m-t-10" >
                                <label>Nama Email Admin Provinsi <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="email" name="email" class="form-control" placeholder="Isikan email admin provinsi" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 m-t-10">
                                <label>Nomor HP Admin Provinsi <span class="text-danger">*</span></label>
                                <fieldset class="controls">                          
                                    <input type="number" name="nomor_hp_pet"  data-mask="00000000000000" class="form-control" placeholder="Isikan nomor HP admin provinsi" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-2 m-t-5">
                                <label>Status Admin Provinsi<span class="text-danger">*</span></label>
                                <div class="custom-control custom-radio m-t-10">
                                    <input type="radio" id="sts1" value="1" name="status" class="custom-control-input" required>
                                    <label class="custom-control-label" for="sts1">Aktif</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="sts2" value="0" name="status" class="custom-control-input">
                                    <label class="custom-control-label" for="sts2">Tidak Aktif</label>
                                </div>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                            </div>
                            <div class="form-group col-md-5 m-t-10">
                                <label>Pilih Wilayah/Regional Admin <span class="text-danger">*</span></label>
                                <select name="provinsi" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required>
                                    <option value="">Pilih Provinsi</option>
                                    <?php
                                    if (!empty($provinsi)) {
                                        foreach ($provinsi as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>                                     
                                            <?php
                                        }
                                    }
                                    ?>                       
                                </select>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                            </div>                     
                            <div class="form-group col-md-5 m-t-10">
                                <label>License Key Expired <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="text" name="license_exp" class="form-control" placeholder="Tanggal Expired" id="license_date" required data-validation-required-message="Kolom ini wajib diisi!">                          
                                </fieldset>
                            </div>
                            <div class="form-group col-md-12 m-t-5">
                                <label>License Key (base 64) <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <textarea class="form-control" rows="5" name="license" ></textarea>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 m-t-10">
                                <label>Input Password <span class="text-danger">*</span></label>   
                                <fieldset class="controls">
                                    <input type="password"  minlength="4" name="password_adm" class="form-control" placeholder="Inputkan password" required data-validation-required-message="Kolom ini wajib diisi" >                        
                                </fieldset>
                            </div>  
                            <div class="form-group col-md-6 m-t-10">
                                <label>Input Konfirmasi Password <span class="text-danger">*</span></label> 
                                <fieldset class="controls">
                                    <input type="password" minlength="4" name="cf_passwd_adm" class="form-control" data-validation-match-match="password_adm" placeholder="Inputkan konfirmasi password" required data-validation-required-message="Kolom ini wajib diisi" >                       
                                </fieldset>
                            </div>
                            <div class="form-group col-md-12 m-t-10">
                                <label>Foto Admin <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="file" name="img_adm" class="dropify" data-max-file-size="2M" data-height="200" required="" data-allowed-file-extensions="jpg png jpeg ico"/>
                                    <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                                </fieldset>
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Formulir Petugas</h6>
                    <section>
                        <div class="row">
                            <div class="form-group col-md-6 m-t-10" >
                                <label>Nama Lengkap Petugas Recruitment <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="text" name="nama_petugas" class="form-control" placeholder="Isikan nama lengkap petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 m-t-10">
                                <label>Nomor KTP Petugas <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="number" name="nomor_ktp" class="form-control" data-mask="9999999999999999" maxlength="16" placeholder="Isikan nomor ktp petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 m-t-10">
                                <label>Email Petugas Recruitment <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="email" name="email_petugas" class="form-control" placeholder="Isikan email petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6 m-t-10">
                                <label>Nomor Handphone <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="number" name="nomor_hp" class="form-control" data-mask="9999999999999" placeholder="Isikan nomor HP petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-4 m-t-10">
                                <label>Regional Petugas <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <select name="region_petugas" class="select2 form-control custom-select" style="width: 100%; height:36px;" required id="region_petugas" data-validation-required-message="Kolom ini wajib diisi!">

                                    </select>
                                </fieldset>
                            </div>  
                            <div class="form-group col-md-8 m-t-10">
                                <label>Alamat Petugas Recruitment</label>
                                <input type="text" name="alamat_petugas" class="form-control" placeholder="Isikan alamat petugas">
                                <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                            </div>

                            <div class="form-group col-md-12 m-t-10">
                                <label>Foto Petugas Recruitment <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="file" name="img_pet" class="dropify" data-max-file-size="2M" data-height="200" required="" data-allowed-file-extensions="jpg png jpeg ico"/>
                                    <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-12 m-t-10">
                                <label>Kode Khusus Petugas</label>
                                <?php
                                $fourdigitrandom = rand(100000, 999999);
                                ?>
                                <div class="input-group">    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><b>Kode</b></span>
                                    </div>
                                    <input type="number" name="kode_petugas" class="form-control bold" value="<?php echo $fourdigitrandom; ?>" required data-validation-required-message="Kolom ini wajib diisi" readonly="">
                                </div>
                                <small class="form-control-feedback">*Kolom Ini <b>Terisi</b> Secara Otomatis dan ditunjukan kepada petugas untuk Login ! </small>
                            </div>                   
                            <div class="form-group col-md-6 m-t-10">
                                <label>Input Password <span class="text-danger">*</span></label>          
                                <fieldset class="controls">
                                    <input type="password" minlength="4" name="password_pet" class="form-control" placeholder="Inputkan password" required data-validation-required-message="Kolom ini wajib diisi" >                        
                                </fieldset>
                            </div>  
                            <div class="form-group col-md-6 m-t-10">
                                <label>Input Konfirmasi Password <span class="text-danger">*</span></label>  
                                <fieldset class="controls">
                                    <input type="password" minlength="4" name="cf_passwd_pet" class="form-control" placeholder="Inputkan konfirmasi password" required data-validation-match-match="password_pet" data-validation-required-message="Kolom ini wajib diisi"  >                       
                                </fieldset>
                            </div>
                        </div>
                    </section>      
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var prov_text;
        var prov_id;

        var data = {
            id_prov: prov_id,
            text_prov: prov_text
        };

        $("#provinsi").change(function () {
            $('#region_petugas').empty();
            prov_text = $("#provinsi option:selected").text();
            prov_id = $("#provinsi option:selected").val();

            data = {
                id_prov: prov_id,
                text_prov: prov_text
            };

            var newOption = new Option(data.text_prov, data.id_prov, false, false);
            $('#region_petugas').append(newOption).trigger('change');
        });
    });
</script>