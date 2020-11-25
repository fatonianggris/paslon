<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Petugas</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Petugas Anggota</a></li>
                <li class="breadcrumb-item active">Tambah Anggota Sebagai Petugas</li>
            </ol>   
            <a href="<?php echo site_url('petugas'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Petugas</button></a> 
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
                <h4 class="card-title">Formulir Tambah Anggota Sebagai Petugas</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah anggota sebagai petugas yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('petugas/kirim_petugas_anggota'); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Lengkap Petugas Recruitment <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_petugas" class="form-control" value="<?php echo $anggota_petugas[0]->nama_ktp ?>" placeholder="Isikan nama lengkap petugas" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor KTP Petugas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="nomor_ktp" class="form-control" value="<?php echo $anggota_petugas[0]->nik_ktp ?>"  data-mask="9999999999999999" placeholder="Isikan nomor ktp petugas" required data-validation-required-message="Kolom ini wajib diisi">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Email Petugas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="email" name="email_petugas" class="form-control" value="<?php echo $anggota_petugas[0]->email ?>"  placeholder="Isikan email petugas" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor Handphone <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="nomor_hp" class="form-control" data-mask="00000000000000" value="<?php echo $anggota_petugas[0]->nomor_hp_ktp ?>"  placeholder="Isikan nomor HP petugas" required data-validation-required-message="Kolom ini wajib diisi">
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

                                <option value="<?php echo $anggota_petugas[0]->id_admin; ?>">
                                    <?php echo strtoupper($anggota_petugas[0]->provinsi); ?>
                                    <?php
                                    if ($anggota_petugas[0]->kabupaten != NULL || $anggota_petugas[0]->kabupaten != "") {
                                        echo ' - ' . strtoupper($anggota_petugas[0]->kabupaten);
                                    }
                                    ?>
                                </option>                                     
                            </select>
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-8 m-t-10">
                        <label>Alamat Petugas Recruitment</label>
                        <input type="text" name="alamat_petugas" value="<?php echo $anggota_petugas[0]->alamat_ktp ?>" class="form-control" placeholder="Isikan alamat petugas">
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>

                    <div class="form-group col-md-12 m-t-10">
                        <label>Foto Petugas Recruitment <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="image" value="<?php echo $anggota_petugas[0]->img_pas ?>" style="display:none" />
                            <input type="text" name="image_thumb" value="<?php echo $anggota_petugas[0]->img_pas_thumb; ?>" style="display:none" />
                            <input type="file" name="img" class="dropify" data-max-file-size="1M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $anggota_petugas[0]->img_pas ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 MB</b> ! </small>
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
                            <input type="password" name="password" class="form-control" placeholder="Inputkan password" required data-validation-required-message="Kolom ini wajib diisi" >                        
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-6 m-t-10">
                        <label>Input Konfirmasi Password <span class="text-danger">*</span></label>  
                        <fieldset class="controls">
                            <input type="password" name="cf_passwd" class="form-control" placeholder="Inputkan konfirmasi password" required data-validation-match-match="password" data-validation-required-message="Kolom ini wajib diisi"  >                       
                        </fieldset>
                    </div>
                    <div class="form-group col m-t-10">
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
