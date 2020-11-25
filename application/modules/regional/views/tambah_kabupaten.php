<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Kabupaten</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Kabupaten</a></li>
                <li class="breadcrumb-item active">Tambah Regional Kabupaten </li>
            </ol>   
            <!--<a href="<?php echo site_url('regional/daftar_kabupaten'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Regional Kabupaten</button></a>--> 
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
                <h4 class="card-title">Formulir Tambah Regional Kabupaten </h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah regional kabupaten yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('regional/kirim_kabupaten'); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-4 m-t-10">
                        <label>Pilih Provinsi <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="id_dati1" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Provinsi</option>
                                <?php
                                if (!empty($prov)) {
                                    foreach ($prov as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>                                     
                                        <?php
                                    }
                                }
                                ?>                       
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Nama Regional Kabupaten <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama" class="form-control" placeholder="Isikan nama regional" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Akronim Regional Kabupaten <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <input type="text" name="akronim" class="form-control" placeholder="Isikan akronim regional" >
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Administratif Regional Kabupaten <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="administratif" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Administratif</option>
                                <option value="kab">KAB</option> 
                                <option value="kota">KOTA</option> 
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Jumlah Penduduk <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="jml_penduduk" class="form-control" min="1" placeholder="Isikan jumlah penduduk">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Luas Kabupaten <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="luas" class="form-control" min="1" placeholder="Isikan luas kabupaten" >
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col m-t-10 col-md-12">
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
