<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Pemilihan</a></li>
                <li class="breadcrumb-item active">Tambah Pemilihan</li>
            </ol>        
            <a href="<?php echo site_url('pemilihan/daftar_pemilihan'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Pemilihan</button></a> 
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
            <div class="card card-body wizard-content">
                <h4 class="card-title">Tambah Pemilihan</h4>
                <h6 class="card-subtitle">Tambah pemilihan terkait kategori, calon, tahun dll</h6>               
                <form id="form_admin" class="form-horizontal m-t-10 validation-wizard wizard-circle" action="<?php echo site_url('pemilihan/kirim_pemilihan'); ?>" enctype="multipart/form-data" method="post">          
                    <!-- Step 1 -->
                    <h6>Formulir Tambah Pemilihan</h6>
                    <section>
                        <div class="col-md-12 row">
                            <div class="form-group col-md-3 m-t-5">
                                <label>Kategori Pemilihan<span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <select name="kategori_pemilihan" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                        <?php if ($usr['role_admin'] == 1) { ?>                                     
                                            <option value="3" selected>GUBERNUR</option>
                                            <option value="4">WALIKOTA</option>
                                            <option value="5">BUPATI</option>
                                            <option value="6">DPRD PROVINSI</option> 
                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                        <?php } else if ($usr['role_admin'] == 2) { ?>                                   
                                            <option value="4" selected>WALIKOTA</option>
                                            <option value="5">BUPATI</option>                                       
                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                        <?php } else { ?>
                                            <option value="1" selected>PRESIDEN</option> 
                                            <option value="2">DPR RI</option>       
                                            <option value="3">GUBERNUR</option>
                                            <option value="4">WALIKOTA</option>
                                            <option value="5">BUPATI</option>
                                            <option value="6">DPRD PROVINSI</option> 
                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                        <?php } ?>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group col-md-9 m-t-5" >
                                <label>Nama Pemilihan <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="text" name="nama_pemilihan" class="form-control" placeholder="Isikan nama pemilihan" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="form-group col-md-6" id="prov">
                                <label>Pilih Provinsi <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <select name="provinsi" class="select2 form-control" style="width: 100%; height:36px;" id="provinsi" >
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
                                </fieldset>
                            </div>
                            <div class="form-group col-md-6" id="kab">
                                <label>Pilih Kabupaten/Kota <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <select name="kabupaten" class="select2 form-control" style="width: 100%; height:36px;" id="kabupaten">
                                        <option value="">Pilih Kabupaten/Kota </option>
                                    </select>
                                </fieldset>
                            </div>                       
                        </div>
                        <div class="col-md-12 row">
                            <div class="form-group col-md-2 m-t-5">
                                <label>Tahun Pemilihan<span class="text-danger"> *</span></label>
                                <fieldset class="controls">
                                    <div class="input-group">
                                        <input type="text" name="tahun_pemilihan" class="form-control" value="<?php echo date("Y"); ?>" placeholder="Tahun pemilihan" id="pemilihan_date" required data-validation-required-message="Kolom ini wajib diisi!">                          
                                    </div>        
                                </fieldset>
                            </div>
                            <div class="form-group col-md-2 m-t-5" >
                                <label>No. Urut <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="number" min="0" name="nomor_urut_awal" id="nomor_urut_awal" class="form-control" placeholder="Isikan no urut" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-4 m-t-5" >
                                <label>Nama Calon <span class="text-danger">*</span></label>
                                <fieldset class="controls">
                                    <input type="text" name="nama_calon_awal" id="nama_calon_awal" class="form-control" placeholder="Isikan nama calon" required data-validation-required-message="Kolom ini wajib diisi">
                                </fieldset>
                            </div>
                            <div class="form-group col-md-4 m-t-5" >
                                <label>Nama Wakil Calon <span class="text-danger"></span></label>
                                <input type="text" name="nama_wakil_calon_awal" id="nama_wakil_calon_awal" class="form-control" placeholder="Isikan nama wakil calon" >
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <label>Foto/Logo Kandidat<span class="text-danger"></span></label>
                                        <input type="file" name="foto" class="dropify" data-max-file-size="2M" data-height="300"  data-allowed-file-extensions="jpg png jpeg ico"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Formulir Tambah Calon</h6>
                    <section>
                        <div id="dynamic_field">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2 m-t-5">
                                    <label>Nomor Urut<span class="text-danger">*</span></label>
                                    <fieldset class="controls">
                                        <input type="number" min="0" name="nomor_urut[]" id="nomor_urut" class="form-control" required placeholder="Isikan nomor urut" readonly="">
                                    </fieldset>
                                    <small class="form-control-feedback">*Contoh <b>01, 02</b></small>
                                </div>
                                <div class="form-group col-md-5 m-t-5" >
                                    <label>Nama Calon <span class="text-danger">*</span></label>
                                    <fieldset class="controls">
                                        <input type="text" name="nama_calon[]" id="nama_calon"  class="form-control" required placeholder="Isikan calon" readonly="">
                                    </fieldset>                                
                                </div>
                                <div class="form-group col-md-4 m-t-5" >
                                    <label>Nama Wakil Calon <span class="text-danger"></span></label>
                                    <fieldset class="controls">
                                        <input type="text" name="nama_wakil_calon[]" id="nama_wakil_calon" class="form-control" required placeholder="Isikan wakil calon" readonly="">
                                    </fieldset>                           
                                </div>
                                <div class="form-group col-md-1 m-t-5">      
                                    <label></label>
                                    <button type="button" name="add" id="add" class="btn btn-success">Tambah Calon</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- .row -->
<!-- Plugin JavaScript -->
<script>

    $(document).ready(function () {
        var kategori_pemilihan = $('select[name="kategori_pemilihan"]');
        var prov = $('select[name="provinsi"]');
        var kabu = $('select[name="kabupaten"]');

        var id_prov;
        var id_kat = kategori_pemilihan.val();

        $(function () {

            if (<?php echo ($usr['role_admin']) ?> == 0) {
                document.getElementById("prov").hidden = true;
                document.getElementById("kab").hidden = true;
                prov.prop('disabled', true);
                kabu.prop('disabled', true);
            } else if (<?php echo ($usr['role_admin']) ?> == 1) {
                document.getElementById("kab").hidden = true;
                kabu.prop('disabled', true);
            } else if (<?php echo ($usr['role_admin']) ?> == 2) {
                id_prov = <?php echo ($usr['id_ref']) ?>;
                var url = "<?php echo site_url('pemilihan/add_ajax_kab'); ?>/" + id_prov;
                $('#kabupaten').load(url);
            }

            kategori_pemilihan.change(function () {
                id_kat = $(this).val();

                if ($(this).val() == 1 || $(this).val() == 2) {
                    prov.prop('disabled', true);
                    kabu.prop('disabled', true);
                    document.getElementById("prov").hidden = true;
                    document.getElementById("kab").hidden = true;
                } else if ($(this).val() == 3 || $(this).val() == 6) {
                    prov.prop('disabled', false);
                    kabu.prop('disabled', true);
                    document.getElementById("prov").hidden = false;
                    document.getElementById("kab").hidden = true;
                } else if ($(this).val() == 4 || $(this).val() == 5 || $(this).val() == 7) {
                    prov.prop('disabled', false);
                    kabu.prop('disabled', false);
                    document.getElementById("prov").hidden = false;
                    document.getElementById("kab").hidden = false;
                }

            });
        });

        $("#provinsi").change(function () {
            id_prov = $(this).val();
            var url = "<?php echo site_url('pemilihan/add_ajax_kab'); ?>/" + id_prov;
            $('#kabupaten').load(url);
            return false;
        })

        $('input[id="nomor_urut_awal"]').on('input', function () {
            if ($(this).val().length) {
                $('input[id="nomor_urut"]').val($(this).val());
            } else {
                $('input[id="nomor_urut"]').val($(this).val());
            }
        });

        $('input[id="nama_calon_awal"]').on('input', function () {
            if ($(this).val().length) {
                $('input[id="nama_calon"]').val($(this).val());
            } else {
                $('input[id="nama_calon"]').val($(this).val());
            }
        });

        $('input[id="nama_wakil_calon_awal"]').on('input', function () {
            if ($(this).val().length) {
                $('input[id="nama_wakil_calon"]').val($(this).val());
            } else {
                $('input[id="nama_wakil_calon"]').val($(this).val());
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        var i = 1;

        $('#add').click(function () {
            i++;
            $('#dynamic_field').append('<div id="row' + i + '"><div class="col-md-12 row"><div class="form-group col-md-2 m-t-5"><label>Nomor Urut<span class="text-danger">*</span></label><fieldset class="controls"><input type="number" min="0" name="nomor_urut[]" class="form-control" required  data-validation-required-message="Kolom ini wajib diisi" placeholder="Isikan nomor urut" ></fieldset><small class="form-control-feedback">*Contoh <b>01, 02</b></small></div><div class="form-group col-md-5 m-t-5" ><label>Nama Calon <span class="text-danger">*</span></label><fieldset class="controls"><input type="text" name="nama_calon[]" class="form-control" required  data-validation-required-message="Kolom ini wajib diisi" placeholder="Isikan calon"></fieldset></div><div class="form-group col-md-4 m-t-5" ><label>Nama Wakil Calon <span class="text-danger"></span></label><fieldset class="controls"><input type="text" name="nama_wakil_calon[]" class="form-control" placeholder="Isikan wakil calon" ></fieldset></div><div class="form-group col-md-1 m-t-25"><label></label><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Hapus</button></div></div></div>');
        });

        $(document).on('click', '.btn_remove', function () {
            var button_id = $(this).attr("id");
            var res = confirm('Anda yakin ingin menghapus kolom ini?');
            if (res == true) {
                $('#row' + button_id + '').remove();
                $('#' + button_id + '').remove();
            }
        });

    });
</script>


