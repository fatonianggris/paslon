<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Label Dapil</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Label Dapil</a></li>
                <li class="breadcrumb-item active">Edit Label Dapil</li>
            </ol>        
            <a href="<?php echo site_url('format/formatcetak/daftar_format_pencarian'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Dapil</button></a> 
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
                <h4 class="card-title">Edit Label Dapil</h4>
                <h6 class="card-subtitle">Edit label dapil terkait nama, status, alamat dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('format/formatcetak/edit_format/' . $label[0]->id_format); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">
                        <div class="form-group col-md-3 m-t-5">
                            <label>Tingkat Kategori <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kategori_dapil" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <option value="<?php echo $label[0]->kategori_dapil; ?>">
                                        <?php
                                        if ($label[0]->kategori_dapil == 1) {
                                            echo 'DPP';
                                        } else if ($label[0]->kategori_dapil == 2) {
                                            echo 'DPD';
                                        } else if ($label[0]->kategori_dapil == 3) {
                                            echo 'DPC';
                                        }
                                        ?>
                                    </option>
                                    <?php if ($usr['role_admin'] == 1) { ?>
                                        <option value="2">DPD</option> 
                                        <option value="3">DPC</option>  
                                    <?php } else if ($usr['role_admin'] == 2) { ?>                                   

                                    <?php } else { ?>
                                        <option value="1">DPP</option> 
                                        <option value="2">DPD</option> 
                                        <option value="3">DPC</option>
                                    <?php } ?>                           
                                </select>
                            </fieldset>
                        </div>

                        <div class="form-group col-md-9 m-t-5" >
                            <label>Nama Label <span class="text-danger">*</span></label>
                            <input type="text" name="nama_alias" class="form-control" value="<?php echo strtoupper($label[0]->nama_alias); ?>" placeholder="Isikan nama label" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-4">
                            <label>Pilih Provinsi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="provinsi" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <option value="<?php echo $label[0]->provinsi; ?>" selected>
                                        <?php
                                        if (!empty($prov)) {
                                            foreach ($prov as $key => $value) {
                                                if ($value->id == $label[0]->provinsi) {
                                                    ?>
                                                    <?php echo $value->nama; ?>                                    
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>     
                                    </option>
                                    <?php
                                    if ($usr['role_admin'] == 0) {
                                        if (!empty($prov)) {
                                            foreach ($prov as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>                                     
                                                <?php
                                            }
                                        }
                                    }
                                    ?>      
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-4" >
                            <label>Pilih Kabupaten <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kabupaten[]" class="select_kab form-control " multiple="multiple" style="width: 100%; height:36px;" id="kabupaten" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <?php if ($usr['role_admin'] == 2) { ?>
                                        <?php
                                        $id_kab = $label[0]->kabupaten;
                                        $id_array_kab = explode(',', $id_kab);
                                        if (!empty($get_kab)) {
                                            foreach ($get_kab as $key => $value) {
                                                if (in_array($value->kab_con, $id_array_kab)) {
                                                    ?>
                                                    <option value="<?php echo $value->kab_con; ?>" selected><?php echo $value->nama . " [" . strtoupper($value->administratif) . "]"; ?></option> 
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>    
                                    <?php } else { ?>
                                        <?php
                                        $id_kab = $label[0]->kabupaten;
                                        $id_array_kab = explode(',', $id_kab);
                                        if (!empty($get_kab)) {
                                            foreach ($get_kab as $key => $value) {
                                                if (in_array($value->kab_con, $id_array_kab)) {
                                                    ?>
                                                    <option value="<?php echo $value->kab_con; ?>" selected><?php echo $value->nama . " [" . strtoupper($value->administratif) . "]"; ?></option> 
                                                <?php } else {
                                                    ?>
                                                    <option value="<?php echo $value->kab_con; ?>"><?php echo $value->nama . " [" . strtoupper($value->administratif) . "]"; ?></option> 
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   

                                    <?php } ?>  
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-4 " id="kec">
                            <label>Pilih Kecamatan <span class="text-danger">*</span></label>
                            <select name="kecamatan[]" class="select2 form-control select2-multiple" multiple="multiple" style="width: 100%; height:36px;" id="kecamatan" > 
                                <?php
                                $id_kec = $label[0]->kecamatan;
                                $id_array_kec = explode(',', $id_kec);
                                if (!empty($get_kec)) {
                                    foreach ($get_kec as $key => $value) {
                                        if (in_array($value->kec_con, $id_array_kec)) {
                                            ?>
                                            <option value="<?php echo $value->kec_con; ?>" selected><?php echo $value->nama; ?></option> 
                                            <?php
                                        } else {
                                            ?>
                                            <option value = "<?php echo $value->kec_con; ?>"><?php echo $value->nama; ?></option>  
                                            <?php
                                        }
                                    }
                                }
                                ?>     
                            </select>
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
<script>
    $(document).ready(function () {
        var kategori_dapil = $('select[name="kategori_dapil"]');
        var kec = $('select[name="kecamatan[]"]');

        var id_prov = <?php echo $label[0]->provinsi; ?>;
        var id = '<?php echo $label[0]->kabupaten; ?>';
        var id_kab = id.split(",");
        var id_kat = <?php echo $label[0]->kategori_dapil; ?>;

        $(function () {

            if (id_kat === 3) {

                $(".select_kab").select2({
                    maximumSelectionLength: 1
                });

            } else {
                $(".select_kab").select2({
                    maximumSelectionLength: 1000
                });
            }

            if (<?php echo ($label[0]->kategori_dapil) ?> !== 3) {
                document.getElementById("kec").hidden = true;
            }
            kategori_dapil.change(function () {
                id_kat = $(this).val();
                kec.val(null).trigger('change');
                kab_trigger();

                if (id_kat === '1') {
                    $(".select_kab").select2({
                        maximumSelectionLength: 1000
                    });

                    document.getElementById("kec").hidden = true;
                } else if (id_kat === '2') {

                    $(".select_kab").select2({
                        maximumSelectionLength: 1000
                    });

                    document.getElementById("kec").hidden = true;
                } else if (id_kat === '3') {
                    kec.prop('required', true);
                    $(".select_kab").select2({
                        maximumSelectionLength: 1
                    });
                    document.getElementById("kec").hidden = false;

                }
            });
        });

        $("#provinsi").change(function () {
            id_prov = $(this).val();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('format/formatcetak/add_ajax_kab'); ?>",
                data: {id_prov: id_prov, id_kat: id_kat},
                success: function (msg)
                {
                    console.log(msg);
                    $('#kabupaten').html(msg);
                },
                error: function (msg)
                {
                    console.log(msg);
                }
            });
        });

        $("#kabupaten").change(function () {
            id_prov = $("#provinsi").val();
            id_kab = $(this).val();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('format/formatcetak/add_ajax_kec'); ?>",
                data: {id_prov: id_prov, id_kab: id_kab, id_kat: id_kat},
                success: function (msg)
                {
                    console.log(msg);
                    $('#kecamatan').html(msg);
                },
                error: function (msg)
                {
                    console.log(msg);
                }
            });
        });

        function kab_trigger() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('format/formatcetak/add_ajax_kab'); ?>",
                data: {id_prov: id_prov, id_kat: id_kat},
                success: function (msg)
                {
                    console.log(msg);
                    $('#kabupaten').html(msg);
                },
                error: function (msg)
                {
                    console.log(msg);
                }
            });
        }

    });
</script>
