<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Akun</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Akun Anggota</a></li>
                <li class="breadcrumb-item active">Edit Akun Anggota</li>
            </ol> 
            <a href="<?php echo site_url('dashboard'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Lihat Dashborad</button></a> 
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
                <h4 class="card-title">Formulir Edit Admin Website Anggota</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir edit akun web anggota yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('pengaturan/edit_user/' . $user[0]->id_user); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Nama Lengkap Admin Web <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_admin" value="<?php echo $user[0]->nama_admin; ?>" class="form-control" placeholder="Isikan nama lengkap admin" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Nama Email Admin Web <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="email" name="email" value="<?php echo $user[0]->email; ?>" class="form-control" placeholder="Isikan email admin" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Nomor Handphone Admin <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="nomor_hp" value="<?php echo $user[0]->nomor_hp; ?>" class="form-control" placeholder="Isikan nomor HP admin" required data-validation-required-message="Kolom ini wajib diisi">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>     
                    <div class="form-group col-md-12 m-t-10">
                        <label>Foto Admin <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="image" value="<?php echo $user[0]->img; ?>" style="display:none" />
                            <input type="text" name="image_thumb" value="<?php echo $user[0]->img_thumb; ?>" style="display:none" />
                            <input type="file" name="img" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $user[0]->img ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 Mb</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-12 m-t-10">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <button type="reset" onclick="history.back()"  class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- .row -->
<!-- Plugin JavaScript -->
