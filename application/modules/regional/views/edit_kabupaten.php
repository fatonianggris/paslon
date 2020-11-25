<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Kabupaten</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Kabupaten</a></li>
                <li class="breadcrumb-item active">Edit Regional Kabupaten </li>
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
                <h4 class="card-title">Formulir Edit Regional Kabupaten </h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir edit regional kabupaten yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('regional/edit_kabupaten/' . $kabupaten[0]->id . '/' . $kabupaten[0]->id_dati1); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-4 m-t-10">
                        <label>Pilih Provinsi <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="id_dati1" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                <?php
                                if (!empty($prov)) {
                                    foreach ($prov as $key => $value) {
                                        if ($kabupaten[0]->id_dati1 == $value->id) {
                                            ?>
                                            <option value="<?php echo $value->id; ?>" selected><?php echo $value->nama; ?></option>                                     
                                            <?php
                                        }
                                    }
                                }
                                ?>        
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
                            <input type="text" name="nama" value="<?php echo $kabupaten[0]->nama; ?>" class="form-control" placeholder="Isikan nama regional" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Akronim Regional Kabupaten <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <input type="text" name="akronim" value="<?php echo $kabupaten[0]->akronim; ?>" class="form-control" placeholder="Isikan akronim regional" >
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10" >
                        <label>Administratif Regional Kabupaten <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="administratif" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">                             
                                <?php if ($kabupaten[0]->administratif == "kab") { ?>
                                    <option value="kab" selected>KAB</option> 
                                <?php } else { ?>
                                    <option value="kota" selected>KOTA</option> 
                                <?php } ?>
                                <option value="kab">KAB</option> 
                                <option value="kota">KOTA</option> 
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Jumlah Penduduk <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="jml_penduduk" value="<?php echo $kabupaten[0]->jml_penduduk; ?>" class="form-control" min="1" placeholder="Isikan jumlah penduduk">
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
                                <input type="number" name="luas" value="<?php echo $kabupaten[0]->luas; ?>" class="form-control" min="1" placeholder="Isikan luas kabupaten" >
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
