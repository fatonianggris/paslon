<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Template</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Edit Template Website</a></li>
                <li class="breadcrumb-item active">Edit Template Website</li>
            </ol> 
            <a href="<?php echo site_url('dashboard'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-eye"></i> Lihat Dashboard</button></a> 
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
                <h4 class="card-title">Formulir Edit Template</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir edit Template web yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('pengaturan/edit_template/' . $template[0]->id_template); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Judul Website <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="judul_website" value="<?php echo $template[0]->judul_website; ?>" class="form-control" placeholder="Isikan email admin" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Nama Website <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_website" value="<?php echo $template[0]->nama_website; ?>" class="form-control" placeholder="Isikan nama lengkap admin" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>   
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Warna Template Website <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="warna_website" value="<?php echo $template[0]->warna_website; ?>" class="colorpicker form-control" placeholder="Isikan warna template website" required >
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-4 m-t-10">
                        <label>Logo Website</label>
                        <fieldset class="controls">
                            <input type="text" name="logo_website" value="<?php echo $template[0]->logo_website; ?>" style="display:none" />
                            <input type="file" name="img_logo_website" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $template[0]->logo_website ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 Mb</b> ! </small>
                        </fieldset>
                    </div>                 
                    <div class="form-group col-md-4 m-t-10">
                        <label>Logo Nama/Text Website</label>
                        <fieldset class="controls">
                            <input type="text" name="logo_nama_website" value="<?php echo $template[0]->logo_nama_website; ?>" style="display:none" />
                            <input type="file" name="img_logo_nama_website" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $template[0]->logo_nama_website ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 Mb</b> ! </small>
                        </fieldset>
                    </div>                 

                    <div class="form-group col-md-4 m-t-10">
                        <label>Logo Favicon Website</label>
                        <fieldset class="controls">
                            <input type="text" name="logo_favicon" value="<?php echo $template[0]->logo_favicon; ?>" style="display:none" />
                            <input type="file" name="img_logo_favicon" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $template[0]->logo_favicon ?>"/>
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

