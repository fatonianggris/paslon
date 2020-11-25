<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tampilan Hasil Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Hasil Pemilihan</a></li>
                <li class="breadcrumb-item active">Tampilan Hasil Pemilihan</li>
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
            <div class="tab-content">
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
                <div class="col-md-12 row">
                    <div class="col-md-8 ">
                        <h4 class="card-title">Tampilan Hasil TPS "<?php echo strtoupper($tps[0]->nama_tps); ?>-<?php echo strtoupper($tps[0]->nomor_tps); ?>"</h4>
                        <h6 class="card-subtitle">Tampilan hasil TPS terkait data pemilih, data hak pilih dll</h6> 
                    </div>
                    <div class="col-md-4 ">
                        <a href="<?php echo site_url('pemilihan/get_hasil_pemilihan_suara/' . $tps[0]->id_tps . '/' . $pemilihan[0]->id_pemilihan . '/' . $nama_wilayah[0]->id_wilayah); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15 pull-right"><i class="fa fa-edit"></i> Edit Formulir C1</button></a> 
                    </div>
                </div>
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/kirim_hasil_pemilihan/' . $tps[0]->id_tps . '/' . $pemilihan[0]->id_pemilihan . '/' . $nama_wilayah[0]->id_wilayah); ?>" enctype="multipart/form-data" method="post">                             
                    <div class="col-md-12 row">
                        <div class="form-group col-md-12">
                            <label>Petugas Saksi </label>
                            <fieldset class="controls">
                                <select name="id_petugas_saksi[]" class="select_hasil form-control select2-multiple"  style="width: 100%; height:36px;" id="provinsi" readonly>
                                    <?php
                                    $id_saksi = $tps[0]->id_petugas_saksi;
                                    $id_array_saksi = explode(',', $id_saksi);
                                    if (!empty($petugas_saksi_terpakai)) {
                                        foreach ($petugas_saksi_terpakai as $key => $value) {
                                            if (in_array($value->id_saksi, $id_array_saksi)) {
                                                ?>
                                                <option value="<?php echo $value->id_saksi; ?>" selected><?php echo strtoupper($value->nama_saksi) . " [" . strtoupper($value->nomor_ktp_saksi) . "]"; ?></option> 
                                                <?php
                                            }
                                        }
                                    }
                                    ?>    
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-12 card m-l-5">
                                <h5 class="card-title text-danger"><b>DATA PEMILIH & PENGGUNA HAK PILIH </b></h5>
                                <h5 class="card-title text-success"><b> A. DATA PEMILIH </b></h5>
                                <h6 class="card-subtitle-new">Pemilih terdaftar dalam Daftar Pemilih Tetap (DPT)</h6>    
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpt_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->dp_dpt_laki_laki; ?>" id="id_dp_dpt_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpt_perempuan" value="<?php echo $get_hasil_pemilihan[0]->dp_dpt_perempuan; ?>" id="id_dp_dpt_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpt_jumlah" id="id_dp_dpt_jumlah" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly >
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <div class="col-md-12 card row m-l-5">                            
                                <h6 class="card-subtitle-new">Pemilih terdaftar dalam Daftar Pemilih Pindahan (DPPh)</h6>    
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpph_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->dp_dpph_laki_laki; ?>" id="id_dp_dpph_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>  </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpph_perempuan" value="<?php echo $get_hasil_pemilihan[0]->dp_dpph_perempuan; ?>" id="id_dp_dpph_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly> 
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dpph_jumlah" id="id_dp_dpph_jumlah" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <div class="col-md-12 card row m-l-5">                            
                                <h6 class="card-subtitle-new">Daftar Pemilih Tambahan (DPTb)/ Pengguna KTP Elektronik atau Surat Keterangan</h6>    
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dptb_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->dp_dptb_laki_laki; ?>"  id="id_dp_dptb_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_dptb_perempuan" value="<?php echo $get_hasil_pemilihan[0]->dp_dptb_perempuan; ?>" id="id_dp_dptb_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0"  name="dp_dptb_jumlah" id="id_dp_dptb_jumlah" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="form-group col-md-8 " >
                                <label><span class="text-danger"></span></label>
                                <input type="text" value="HASIL" class="form-control text-center" readonly>
                            </div>
                            <div class="form-group col-md-4 " >
                                <label>TOTAL SUARA <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="dp_total" id="id_dp_total" class="form-control" placeholder="Total Suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>
                        <div class="col-md-12 row ">
                            <div class="col-md-12 card m-l-5">
                                <h5 class="card-title text-success"><b> B.DATA PENGGUNA HAK PILIH </b></h5>
                                <h6 class="card-subtitle-new">Pemilih terdaftar dalam Daftar Pemilih Tetap (DPT)</h6>    
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpt_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->php_dpt_laki_laki; ?>" id="id_php_dpt_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpt_perempuan" value="<?php echo $get_hasil_pemilihan[0]->php_dpt_perempuan; ?>" id="id_php_dpt_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpt_jumlah" id="id_php_dpt_jumlah" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>

                        <div class="col-md-12 row">
                            <div class="col-md-12 card row m-l-5">                            
                                <h6 class="card-subtitle-new">Pemilih terdaftar dalam Daftar Pemilih Pindahan (DPPh)</h6>    
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpph_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->php_dpph_laki_laki; ?>" id="id_php_dpph_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3  " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpph_perempuan" value="<?php echo $get_hasil_pemilihan[0]->php_dpph_perempuan; ?>" id="id_php_dpph_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>   </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dpph_jumlah" id="id_php_dpph_jumlah" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-12 card row m-l-5">                            
                                <h6 class="card-subtitle-new">Daftar Pemilih Tambahan (DPTb)/ Pengguna KTP Elektronik atau Surat Keterangan</h6>    
                            </div>
                            <div class="form-group col-md-3 " >
                                <label>Laki-Laki <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dptb_laki_laki" value="<?php echo $get_hasil_pemilihan[0]->php_dptb_laki_laki; ?>" id="id_php_dptb_laki_laki" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-plus"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-3 " >
                                <label>Perempuan <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dptb_perempuan" value="<?php echo $get_hasil_pemilihan[0]->php_dptb_perempuan; ?>" id="id_php_dptb_perempuan" class="form-control" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b>    </small>
                            </div>
                            <div class="form-group col-md-1">
                                <label></label>
                                <div class="input-group-append-hasil">
                                    <span class="input-group-text-hasil"><i class="fa fa-arrow-right"></i></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4  " >
                                <label>Jumlah <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="php_dptb_jumlah" id="id_php_dptb_jumlah" class="form-control" placeholder="Isikan hasil" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="form-group col-md-8 " >
                                <label><span class="text-danger"></span></label>
                                <input type="text" value="HASIL" class="form-control text-center" readonly>
                            </div>
                            <div class="form-group col-md-4 " >
                                <label>TOTAL SUARA <span class="text-danger">*</span></label>
                                <input type="number"  min="0" name="php_total" id="id_php_total" class="form-control" placeholder="Total Suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                <small class="form-control-feedback">*Perhitungan Otomatis </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row ">
                        <div class="col-md-12 card m-l-5">
                            <h5 class="card-title text-danger"><b>RINCIAN PEROLEHAN SUARA SAH & TIDAK SAH </b></h5>                           
                        </div>
                        <div class="col-md-12 card">
                            <div class="table-responsive">
                                <table class="table table-no-bordered no-border text-center table-pemilihan">
                                    <thead>
                                        <tr> 
                                            <th>NOMOR URUT</th>
                                            <th>NAMA PASANGAN CALON</th>
                                            <th>SUARA SAH</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($suara_calon)) {
                                            $i = 1;
                                            foreach ($suara_calon as $key => $value) {
                                                ?> 
                                                <tr>
                                                    <td width="10%">
                                                        <?php if ($i == 1) { ?>
                                                            <b class="text-success">
                                                                <?php echo $value->nomor_urut; ?>
                                                            </b>
                                                        <?php } else { ?>
                                                            <?php echo $value->nomor_urut; ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="70%">
                                                        <?php if ($i == 1) { ?>
                                                            <b class="text-success">
                                                                <?php echo strtoupper($value->nama_calon); ?>/<?php echo strtoupper($value->nama_wakil_calon); ?>
                                                            </b>
                                                        <?php } else { ?>
                                                            <?php echo strtoupper($value->nama_calon); ?>/<?php echo strtoupper($value->nama_wakil_calon); ?>
                                                        <?php } ?>
                                                    </td>
                                                    <td width="20%">
                                                        <input type="text" name="id_calon_pemilihan[]" value="<?php echo $value->id_calon_pemilihan; ?>" style="display:none" />
                                                        <input type="number" min="0" name="suara_sah[]" value="<?php echo $value->suara_sah; ?>" class="form-control id_suara_sah" placeholder="Isikan nominal suara" required data-validation-required-message="Kolom ini wajib diisi" readonly>
                                                    </td>
                                                </tr>
                                                <?php
                                                $i++;
                                            }  //ngatur nomor urut
                                        }
                                        ?>            
                                    </tbody>
                                    <tfoot>
                                        <tr class="center align-center"> 
                                            <th></th>
                                            <th >JUMLAH SELURUH SUARA SAH</th>
                                            <th>
                                                <input type="number" min="0" value="<?php echo $get_hasil_pemilihan[0]->total_suara_sah; ?>"  name="total_suara_sah" id="id_total_suara_sah" class="form-control" placeholder="Jumlah suara sah" required data-validation-required-message="Kolom ini wajib diisi" readonly>                    
                                            </th>                                           
                                        </tr>
                                    </tfoot>
                                    <tfoot>
                                        <tr class="center align-center"> 
                                            <th></th>
                                            <th >JUMLAH SELURUH SUARA TIDAK SAH</th>
                                            <th>
                                                <input type="number" min="0" value="<?php echo $get_hasil_pemilihan[0]->total_suara_tidak_sah; ?>" name="total_suara_tidak_sah" class="form-control" placeholder="Jumlah suara tidak sah" required data-validation-required-message="Kolom ini wajib diisi" readonly>                    
                                            </th>                                           
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="col-md-12 m-l-5">
                            <h5 class="card-title text-danger"><b>BUKTI FORMULIR C1 PEROLEHAN SUARA </b></h5>                           
                        </div> 
                        <div class="col-md-6 card">
                            <div class="card-body">
                                <label> <b>Foto Formulir C1 Ke-1 </b><span class="text-danger">*</span></label>
                                <input type="file" name="fotoc1_pertama" class="dropify" data-default-file="<?php echo base_url() . $get_hasil_pemilihan[0]->fotoc1_pertama_thumb ?>" data-max-file-size="4M" data-height="300" disabled="disabled" data-allowed-file-extensions="jpg png jpeg ico" />
                            </div>
                        </div>
                        <div class="col-md-6 card">
                            <div class="card-body">
                                <label> <b>Foto Formulir C1 Ke-2 </b><span class="text-danger">*</span></label>
                                <input type="file" name="fotoc1_kedua" class="dropify" data-default-file="<?php echo base_url() . $get_hasil_pemilihan[0]->fotoc1_kedua_thumb ?>" data-max-file-size="4M" data-height="300" disabled="disabled" data-allowed-file-extensions="jpg png jpeg ico" />
                            </div>
                        </div>
                    </div>                  
                </form>

            </div>
        </div>
    </div>
</div>
<!-- .row -->
<!-- Plugin JavaScript -->
<script>
// DataTable
    $(".select_hasil").select2("readonly", true);
</script>
<script>

    $('input[name="suara_sah[]"]').on('input', function () {
        var inputs = document.getElementsByClassName('id_suara_sah');
        var names = [].map.call(inputs, function (input) {
            return input.value;
        }).join(',');

        var sum = names.split(',').reduce((a, b) => (+a) + (+b));

        if ($(this).val().length) {
            $('input[id="id_total_suara_sah"]').val(sum);
        } else {
            $('input[id="id_total_suara_sah"]').val(sum);
        }
    });

    var floor = Math.floor;
    var count_dp_dpt = floor($('#id_dp_dpt_laki_laki').val()) + floor($('#id_dp_dpt_perempuan').val());
    $('input[id="id_dp_dpt_jumlah"]').val(count_dp_dpt);

    var count_dp_dpph = floor($('#id_dp_dpph_laki_laki').val()) + floor($('#id_dp_dpph_perempuan').val());
    $('input[id="id_dp_dpph_jumlah"]').val(count_dp_dpph);

    var count_dp_dptb = floor($('#id_dp_dptb_laki_laki').val()) + floor($('#id_dp_dptb_perempuan').val());
    $('input[id="id_dp_dptb_jumlah"]').val(count_dp_dptb);

    trigger_total_dp();

    function trigger_total_dp() {
        var floor = Math.floor;
        var count_total_dp = floor($('#id_dp_dpt_jumlah').val()) + floor($('#id_dp_dpph_jumlah').val()) + floor($('#id_dp_dptb_jumlah').val());
        $('input[id="id_dp_total"]').val(count_total_dp);
    }

</script>

<script>
    var floor = Math.floor;
    var count_php_dpt = floor($('#id_php_dpt_laki_laki').val()) + floor($('#id_php_dpt_perempuan').val());
    $('input[id="id_php_dpt_jumlah"]').val(count_php_dpt);

    var count_php_dpph = floor($('#id_php_dpph_laki_laki').val()) + floor($('#id_php_dpph_perempuan').val());
    $('input[id="id_php_dpph_jumlah"]').val(count_php_dpph);

    var count_php_dptb = floor($('#id_php_dptb_laki_laki').val()) + floor($('#id_php_dptb_perempuan').val());
    $('input[id="id_php_dptb_jumlah"]').val(count_php_dptb);

    trigger_total_php();

    function trigger_total_php() {
        var floor = Math.floor;
        var count_total_dp = floor($('#id_php_dpt_jumlah').val()) + floor($('#id_php_dpph_jumlah').val()) + floor($('#id_php_dptb_jumlah').val());
        $('input[id="id_php_total"]').val(count_total_dp);
    }

</script>

