<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Kop Laporan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kop Laporan Anggota</a></li>
                <li class="breadcrumb-item active">Edit Kop Laporan Anggota</li>
            </ol>    
            <a href="<?php echo site_url('ktp'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Data Anggota</button></a>
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
        <!-- Column -->
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Formulir Edit Kop Laporan</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir Kop Laporan Anggota yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('laporan/edit_laporan'); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Jenis Laporan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="jenis_laporan" value="<?php echo @$laporan[0]->jenis_laporan; ?>" class="form-control" placeholder="Isikan nama lampiran" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                            <small class="form-control-feedback"> *Contoh <b>LAMPIRAN MODEL F-1 DPD</b></small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Header Laporan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="header_laporan" value="<?php echo @$laporan[0]->header_laporan; ?>" class="form-control" placeholder="Isikan header laporan" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </fieldset>
                    </div>                          
                    <div class="form-group col-md-12 m-t-10">
                        <label>Kop Laporan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="image" value="<?php echo @$laporan[0]->img ?>" style="display:none" />
                            <input type="text" name="image_thumb" value="<?php echo @$laporan[0]->image_thumb; ?>" style="display:none" />
                            <input type="file" name="img" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . @$laporan[0]->img ?>"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>1 Mb</b> ! </small>
                        </fieldset>
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
