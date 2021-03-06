<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Kelurahan/Desa</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Kelurahan/Desa</a></li>
                <li class="breadcrumb-item active">Tambah Regional Kelurahan/Desa </li>
            </ol>   
            <!--<a href="<?php echo site_url('regional/daftar_kelurahan_desa'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Regional Kelurahan/Desa</button></a>--> 
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
                <h4 class="card-title">Formulir Tambah Regional Kelurahan/Desa </h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah regional kelurahan/desa yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('regional/kirim_kelurahan_desa'); ?>" enctype="multipart/form-data" method="post" novalidate>          
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
                    <div class="form-group col-md-4 m-t-10">
                        <label>Pilih Kabupaten/Kota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="id_dati2" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kabupaten" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Kabupaten/Kota</option>                                       
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Pilih Kecamatan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="id_dati3" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kecamatan" required data-validation-required-message="Kolom ini wajib diisi!"> 
                                <option value="">Pilih Kecamatan</option>            
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Nama Regional Kelurahan/Desa <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama" class="form-control" placeholder="Isikan nama regional" required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Akronim Regional Kelurahan/Desa <span class="text-danger">*/span></label>
                        <fieldset class="controls">
                            <input type="text" name="akronim" class="form-control" placeholder="Isikan akronim regional" >
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10" >
                        <label>Administratif Regional Kelurahan/Desa <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="administratif" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Administratif</option>
                                <option value="kel">Kelurahan</option> 
                                <option value="desa">Desa</option> 
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Kode Pos <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="kodepos" class="form-control" data-mask="00000" placeholder="Isikan jumlah penduduk">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
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
                    <div class="form-group col-md-6 m-t-10">
                        <label>Luas Kelurahan/Desa <span class="text-danger"></span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="number" name="luas" class="form-control" min="1" placeholder="Isikan luas kelurahan/desa" >
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
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
<script>
                            $(document).ready(function () {
                                var id_prov;
                                var id_kab;
                                var id_kec;
                                $("#provinsi").change(function () {
                                    id_prov = $(this).val();
                                    var url = "<?php echo site_url('ktp/add_ajax_kab'); ?>/" + id_prov;
                                    $('#kabupaten').load(url);
                                    return false;
                                })

                                $("#kabupaten").change(function () {
                                    id_kab = $(this).val();
                                    var url = "<?php echo site_url('ktp/add_ajax_kec'); ?>/" + id_prov + "/" + id_kab;
                                    $('#kecamatan').load(url);
                                    return false;
                                })

                                $("#kecamatan").change(function () {
                                    id_kec = $(this).val()
                                    var url = "<?php echo site_url('ktp/add_ajax_des'); ?>/" + id_prov + "/" + id_kab + "/" + id_kec;
                                    $('#kelurahan').load(url);
                                    return false;
                                })
                                $(document).ready(function () {
                                    $("#region_anggota").change(function () {
                                        var url = "<?php echo site_url('ktp/add_ajax_petugas'); ?>/" + $(this).val();
                                        $('#nama_petugas').load(url);
                                        return false;
                                    })
                                });
                            });
</script>
