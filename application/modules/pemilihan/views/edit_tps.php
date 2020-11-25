<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit TPS</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> TPS</a></li>
                <li class="breadcrumb-item active">Edit TPS</li>
            </ol>        
            <a href="<?php echo site_url('pemilihan/daftar_tps_petugas/' . $nama_wilayah[0]->id_wilayah . '/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar TPS</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="tab-content a">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-xs-6 b-r"> <strong>Pemilihan</strong>
                                <br>
                                <p class="text-muted">
                                    <?php if ($pemilihan[0]->id_kategori_pemilihan == 1) { ?>
                                        PRESIDEN
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 2) { ?>
                                        DPR RI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 3) { ?>
                                        GURBERNUR
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 4) { ?>
                                        WALIKOTA
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 5) { ?>
                                        BUPATI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 6) { ?>
                                        DPRD PROVINSI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 7) { ?>
                                        DPRD KABUPATEN/KOTA
                                    <?php } ?>
                                </p>
                            </div>
                            <div class="col-md-2 col-xs-6 b-r"> <strong>Periode</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->tahun_pemilihan); ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_calon); ?></p>
                            </div>
                            <div class="col-md-5 col-xs-6"> <strong>Provinsi/Kabupaten/Kecamatan/Kelurahan</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($nama_wilayah[0]->provinsi); ?>/<?php echo strtoupper($nama_wilayah[0]->kabupaten); ?>/<?php echo strtoupper($nama_wilayah[0]->kecamatan); ?>/<?php echo strtoupper($nama_wilayah[0]->kelurahan); ?></p>
                            </div>           
                        </div>                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Edit TPS</h4>
                <h6 class="card-subtitle">Edit TPS terkait nama, petugas saksi dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/edit_tps/' . $tps[0]->id_tps . '/' . $tps[0]->id_pemilihan . '/' . $tps[0]->id_wilayah_pemilihan); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">                 
                        <div class="form-group col-md-9 m-t-5" >
                            <label>Nama TPS <span class="text-danger">*</span></label>
                            <input type="text" name="nama_tps" class="form-control" value="<?php echo strtoupper($tps[0]->nama_tps); ?>" placeholder="Isikan nama TPS" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b></small>
                        </div>
                        <div class="form-group col-md-3 m-t-5" >
                            <label>Nomor TPS <span class="text-danger">*</span></label>
                            <input type="number" name="nomor_tps" class="form-control" value="<?php echo strtoupper($tps[0]->nomor_tps); ?>" data-mask="999" placeholder="Isikan nomor TPS" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Format nomor 3 digit "001"</small>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12" id="prov">
                            <label>Pilih Petugas Saksi<span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="id_petugas_saksi[]" class="select2 form-control select2-multiple" multiple="multiple" style="width: 100%; height:36px;" id="petugas" >                                 
                                    <?php
                                    $id_saksi = $tps[0]->id_petugas_saksi;
                                    $id_array_saksi = explode(',', $id_saksi);
                                    if (!empty($petugas_saksi_terpakai)) {
                                        foreach ($petugas_saksi_terpakai as $key => $value) {
                                            if (in_array($value->id_saksi, $id_array_saksi)) {
                                                ?>
                                                <option value="<?php echo $value->id_saksi; ?>" selected><?php echo strtoupper($value->nama_saksi); ?> (<?php echo $value->nomor_ktp_saksi; ?>) </option>                                     
                                            <?php } else {
                                                ?>
                                                <option disabled=""><?php echo strtoupper($value->nama_saksi); ?> (<?php echo $value->nomor_ktp_saksi; ?>) [<?php echo strtoupper($value->kelurahan) . '/TPS-' . strtoupper($value->nomor_tps); ?>]</option>                                     
                                                <?php
                                            }
                                        }
                                    }
                                    ?>    
                                    <?php
                                    if (!empty($petugas_saksi)) {
                                        foreach ($petugas_saksi as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id_saksi; ?>"><?php echo strtoupper($value->nama_saksi) . " (" . strtoupper($value->nomor_ktp_saksi) . ")"; ?></option> 
                                            <?php
                                        }
                                    }
                                    ?>      
                                </select>
                            </fieldset>
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
        $(function () {
            $("#petugas").select2({
                maximumSelectionLength: 2
            });
        });
    });
</script>
