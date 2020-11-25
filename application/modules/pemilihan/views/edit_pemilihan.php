<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pemilihan</a></li>
                <li class="breadcrumb-item active">Edit Pemilihan</li>
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
            <div class="card card-body">
                <h4 class="card-title">Edit Pemilihan</h4>
                <h6 class="card-subtitle">Edit Pemilihan terkait kategori, calon, nama dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/edit_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">
                        <div class="form-group col-md-3 m-t-5">
                            <label>Kategori Pemilihan <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kategori_pemilihan" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!" readonly>
                                    <option value="<?php echo $pemilihan[0]->id_kategori_pemilihan; ?>">
                                        <?php
                                        if ($pemilihan[0]->id_kategori_pemilihan == 1) {
                                            echo 'PRESIDEN';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 2) {
                                            echo 'DPR RI';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 3) {
                                            echo 'GURBERNUR';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 4) {
                                            echo 'WALIKOTA';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 5) {
                                            echo 'BUPATI';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 6) {
                                            echo 'DPRD PROVINSI';
                                        } else if ($pemilihan[0]->id_kategori_pemilihan == 7) {
                                            echo 'DPRD KABUPATEN/KOTA';
                                        }
                                        ?>
                                    </option>
                                    <!--                                    <?php if ($usr['role_admin'] == 1) { ?>
                                                                                                                                            <option value="3">GUBERNUR</option>
                                                                                                                                            <option value="4">WALIKOTA</option>
                                                                                                                                            <option value="5">BUPATI</option>
                                                                                                                                            <option value="6">DPRD PROVINSI</option> 
                                                                                                                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                    <?php } else if ($usr['role_admin'] == 2) { ?>                                   
                                                                                                                                            <option value="4">WALIKOTA</option>
                                                                                                                                            <option value="5">BUPATI</option>                                       
                                                                                                                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                    <?php } else { ?>
                                                                                                                                            <option value="1">PRESIDEN</option> 
                                                                                                                                            <option value="2">DPR RI</option>       
                                                                                                                                            <option value="3">GUBERNUR</option>
                                                                                                                                            <option value="4">WALIKOTA</option>
                                                                                                                                            <option value="5">BUPATI</option>
                                                                                                                                            <option value="6">DPRD PROVINSI</option> 
                                                                                                                                            <option value="7">DPRD KABUPATEN/KOTA</option> 
                                    <?php } ?>                           -->
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-9 m-t-5" >
                            <label>Nama Pemilihan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pemilihan" class="form-control" value="<?php echo strtoupper($pemilihan[0]->nama_pemilihan); ?>"  placeholder="Isikan nama pemilihan" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-6" id="prov">
                            <label>Pilih Provinsi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="provinsi" class=" form-control" style="width: 100%; height:36px;" id="provinsi" readonly>
                                    <option value = "<?php echo substr($pemilihan[0]->id_regional_pemilihan, 0, 2); ?>" selected>
                                        <?php
                                        if (!empty($provinsi)) {
                                            foreach ($provinsi as $key => $value) {
                                                if ($value->id == substr($pemilihan[0]->id_regional_pemilihan, 0, 2)) {
                                                    ?>
                                                    <?php echo $value->nama; ?>                                    
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>     
                                    </option>
                                    <!--                                    <?php
                                    if ($usr['role_admin'] == 0) {
                                        if (!empty($provinsi)) {
                                            foreach ($provinsi as $key => $value) {
                                                ?>
                                                                                                                                                                                                                                                                        <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>                                     
                                                <?php
                                            }
                                        }
                                    }
                                    ?>      -->
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-6" id="kab" >
                            <label>Pilih Kabupaten <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kabupaten" class="form-control" style="width: 100%; height:36px;" id="kabupaten" readonly>
                                    <option value="<?php echo substr($pemilihan[0]->id_regional_pemilihan, 2, 2); ?>" selected>
                                        <?php
                                        if (!empty($kabupaten)) {
                                            foreach ($kabupaten as $key => $value) {
                                                if ($value->id == substr($pemilihan[0]->id_regional_pemilihan, 2, 2) && $value->id_dati1 == substr($pemilihan[0]->id_regional_pemilihan, 0, 2)) {
                                                    ?>
                                                    <?php echo $value->nama; ?> [<?php echo strtoupper($value->administratif); ?>]                                   
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>    
                                        <!--                                        <?php
                                        if ($usr['role_admin'] != 2) {
                                            if (!empty($kabupaten)) {
                                                foreach ($kabupaten as $key => $value) {
                                                    ?>
                                                                                                                                                                                                                                                                            <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?> [<?php echo strtoupper($value->administratif); ?>]</option>                                     
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>      -->
                                    </option>                                    
                                </select>
                            </fieldset>
                        </div>                      
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 m-t-5">
                            <label>Tahun Pemilihan<span class="text-danger"> *</span></label>
                            <fieldset class="controls">
                                <div class="input-group">
                                    <input type="text" name="tahun_pemilihan" class="form-control" value="<?php echo $pemilihan[0]->tahun_pemilihan; ?>" placeholder="Tahun pemilihan"  id="pemilihan_date" required data-validation-required-message="Kolom ini wajib diisi!">                          
                                </div>        
                            </fieldset>
                        </div>
                        <div class="form-group col-md-2 m-t-5" >
                            <label>No. Urut <span class="text-danger">*</span></label>
                            <input type="number" min="0" name="nomor_urut" value="<?php echo $pemilihan[0]->nomor_urut; ?>" class="form-control" placeholder="Isikan no urut" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-4 m-t-5" >
                            <label>Nama Calon <span class="text-danger">*</span></label>
                            <input type="text" name="nama_calon" class="form-control" value="<?php echo $pemilihan[0]->nama_calon; ?>" placeholder="Isikan nama calon " required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-4 m-t-5" >
                            <label>Nama Wakil Calon <span class="text-danger"></span></label>
                            <input type="text" name="nama_wakil_calon" class="form-control" value="<?php echo $pemilihan[0]->nama_wakil_calon; ?>" placeholder="Isikan nama wakil calon" >
                        </div>
                    </div> 
                    <div class="col-md-12 row">
                        <div class="col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <label>Foto/Logo Kandidat<span class="text-danger"></span></label>
                                    <input type="text" name="foto_temp" value="<?php echo $pemilihan[0]->foto_calon ?>" style="display:none" />
                                    <input type="text" name="foto_temp_thumb" value="<?php echo $pemilihan[0]->foto_calon_thumb; ?>" style="display:none" />
                                    <input type="file" name="foto" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $pemilihan[0]->foto_calon ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12 m-t-5">
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
        var kategori_pemilihan = $('select[name="kategori_pemilihan"]');
        var prov = $('select[name="provinsi"]');
        var kabu = $('select[name="kabupaten"]');

        var id_prov;
        var id_kat = kategori_pemilihan.val();

        $(function () {

            if (<?php echo $pemilihan[0]->id_kategori_pemilihan ?> == 1 || <?php echo $pemilihan[0]->id_kategori_pemilihan ?> == 2) {
                document.getElementById("prov").hidden = true;
                document.getElementById("kab").hidden = true;
                prov.prop('disabled', true);
                kabu.prop('disabled', true);
            } else if (<?php echo $pemilihan[0]->id_kategori_pemilihan ?> == 3) {
                document.getElementById("kab").hidden = true;
                kabu.prop('disabled', true);
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
            var url = "<?php echo site_url('ktp/add_ajax_kab'); ?>/" + id_prov;
            $('#kabupaten').load(url);
            return false;
        })
    });
</script>
