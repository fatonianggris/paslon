<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Anggota</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Anggota</a></li>
                <li class="breadcrumb-item active">Edit Anggota per Regional</li>
            </ol>
            <a href="<?php echo site_url('ktp'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Data Anggota</button></a>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-12">
        <!-- Column -->
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Formulir Edit Anggota per Regional "<?php
                    if (!empty($admin_regional) && $ktp[0]->id_admin != null) {
                        foreach ($admin_regional as $key => $value) {
                            if ($value->id_ref == $ktp[0]->id_admin) {
                                ?>
                                <?php echo strtoupper($value->provinsi); ?>
                                <?php
                                if ($value->kabupaten != NULL) {
                                    echo ' - ' . strtoupper($value->kabupaten);
                                }
                                ?>                                
                                <?php
                            }
                        }
                    }
                    ?>"
                </h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir Edit Anggota per Regional yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('ktp/edit_ktp_admin/' . $ktp[0]->id_ktp); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nama ID <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_ktp" class="form-control"  value="<?php echo $ktp[0]->nama_ktp; ?>"  placeholder="Isikan nama anggota" required data-validation-required-message="Kolom ini wajib diisi!">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>No Identitas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" onkeyup="checkNikRealTime(this.value)"  value="<?php echo $ktp[0]->nik_ktp; ?>" data-mask="9999999999999999" name="nik_ktp" class="form-control" placeholder="Isikan No Identitas" required  data-validation-required-message="Kolom ini wajib diisi!">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Tempat/Tanggal Lahir <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="tempat_lahir" class="select2 form-control custom-select" style="width: 100%; height:36px;" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo $ktp[0]->tempat_lahir; ?>"><?php echo $ktp[0]->tempat_lahir; ?></option>
                                <?php
                                if (!empty($kab)) {
                                    foreach ($kab as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->nama; ?> <?php echo strtoupper($value->administratif); ?>"><?php echo $value->nama; ?> [<?php echo strtoupper($value->administratif); ?>]</option>                                
                                        <?php
                                    }
                                }
                                ?>                       
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label></label>
                        <fieldset class="controls">
                            <div class="input-group">
                                <input type="text" name="tanggal_lahir" class="form-control"  value="<?php echo $ktp[0]->tanggal_lahir; ?>"  placeholder="Tanggal lahir" id="mdate_edit" required data-validation-required-message="Kolom ini wajib diisi!">                          
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-5">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="custom-control custom-radio m-t-10">
                                <input type="radio" id="jk1" value="1" name="jenis_kelamin" class="custom-control-input" <?php echo ($ktp[0]->jenis_kelamin == '1') ? 'checked' : '' ?> required data-validation-required-message="Kolom ini wajib diisi!">
                                <label class="custom-control-label" for="jk1">Laki-Laki</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="jk2" value="0" name="jenis_kelamin" class="custom-control-input" <?php echo ($ktp[0]->jenis_kelamin == '0') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="jk2">Perempuan</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Golongan Darah <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="gol_darah" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo $ktp[0]->gol_darah; ?>">
                                    <?php
                                    if ($ktp[0]->gol_darah == 1) {
                                        echo 'A';
                                    } else if ($ktp[0]->gol_darah == 2) {
                                        echo 'B';
                                    } else if ($ktp[0]->gol_darah == 3) {
                                        echo 'AB';
                                    } else if ($ktp[0]->gol_darah == 4) {
                                        echo 'O';
                                    } else if ($ktp[0]->gol_darah == 5) {
                                        echo 'Lainnya';
                                    }
                                    ?>
                                </option>
                                <option value="1">A</option> 
                                <option value="2">B</option> 
                                <option value="3">AB</option> 
                                <option value="4">O</option>  
                                <option value="5">Lainnya</option>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Email Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="email" class="form-control" value="<?php echo $ktp[0]->email; ?>" placeholder="Isikan email" required data-validation-required-message="Kolom ini wajib diisi!">
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Pilih Asal Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="provinsi" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo substr($ktp[0]->id_asal, 0, 2); ?>">
                                    <?php
                                    if (!empty($prov)) {
                                        foreach ($prov as $key => $value) {
                                            if ($value->id == substr($ktp[0]->id_asal, 0, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>
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
                    <div class="form-group col-md-3 m-t-10">
                        <label></label>
                        <fieldset class="controls">
                            <select name="kabupaten" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kabupaten" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo substr($ktp[0]->id_asal, 2, 2); ?>">
                                    <?php
                                    if (!empty($kab)) {
                                        foreach ($kab as $key => $value) {
                                            if ($value->id == substr($ktp[0]->id_asal, 2, 2) && $value->id_dati1 == substr($ktp[0]->id_asal, 0, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>                                       
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label></label>
                        <fieldset class="controls">
                            <select name="kecamatan" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kecamatan" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo substr($ktp[0]->id_asal, 4, 2); ?>">
                                    <?php
                                    if (!empty($kec)) {
                                        foreach ($kec as $key => $value) {
                                            if ($value->id == substr($ktp[0]->id_asal, 4, 2) && $value->id_dati1 == substr($ktp[0]->id_asal, 0, 2) && $value->id_dati2 == substr($ktp[0]->id_asal, 2, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>            
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10" >
                        <label></label>
                        <fieldset class="controls">
                            <select name="kelurahan" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kelurahan" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo substr($ktp[0]->id_asal, 6, 2); ?>">
                                    <?php
                                    if (!empty($kel)) {
                                        foreach ($kel as $key => $value) {
                                            if ($value->id == substr($ktp[0]->id_asal, 6, 2) && $value->id_dati1 == substr($ktp[0]->id_asal, 0, 2) && $value->id_dati2 == substr($ktp[0]->id_asal, 2, 2) && $value->id_dati3 == substr($ktp[0]->id_asal, 4, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>            
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Alamat ID <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="alamat_ktp" class="form-control" value="<?php echo $ktp[0]->alamat_ktp; ?>" placeholder="Isikan Alamat ID" required data-validation-required-message="Kolom ini wajib diisi!">     
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>RT <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="rt" class="form-control" data-mask="9999" value="<?php echo $ktp[0]->rt; ?>" placeholder="Isikan RT" required  data-validation-required-message="Kolom ini wajib diisi!">
                                <div class="input-group-append">
                                    <span class="input-group-text">RT</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>RW <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="rw" class="form-control" data-mask="9999" value="<?php echo $ktp[0]->rw; ?>" placeholder="Isikan RW" required  data-validation-required-message="Kolom ini wajib diisi!">
                                <div class="input-group-append">
                                    <span class="input-group-text">RW</span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Kode Pos <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="kodepos" class="form-control"  data-mask="99999" value="<?php echo $ktp[0]->kodepos; ?>" placeholder="Isikan Kodepos">                         
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Agama <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="agama" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo $ktp[0]->agama; ?>">
                                    <?php
                                    if ($ktp[0]->agama == 1) {
                                        echo 'Islam';
                                    } else if ($ktp[0]->agama == 2) {
                                        echo 'Kristen';
                                    } else if ($ktp[0]->agama == 3) {
                                        echo 'Hindu';
                                    } else if ($ktp[0]->agama == 4) {
                                        echo 'Budha';
                                    } else if ($ktp[0]->agama == 5) {
                                        echo 'Lainnya';
                                    }
                                    ?>
                                </option>
                                <option value="1">Islam</option> 
                                <option value="2">Kristen</option> 
                                <option value="3">Hindu</option> 
                                <option value="4">Budha</option> 
                                <option value="5">Lainnya</option> 
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="pend_terakhir" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo $ktp[0]->pend_terakhir; ?>">
                                    <?php
                                    if ($ktp[0]->pend_terakhir == 1) {
                                        echo 'Tidak Sekolah';
                                    } else if ($ktp[0]->pend_terakhir == 2) {
                                        echo 'SD';
                                    } else if ($ktp[0]->pend_terakhir == 3) {
                                        echo 'SLTP';
                                    } else if ($ktp[0]->pend_terakhir == 4) {
                                        echo 'SLTA';
                                    } else if ($ktp[0]->pend_terakhir == 5) {
                                        echo 'D-I/D-II';
                                    } else if ($ktp[0]->pend_terakhir == 6) {
                                        echo 'D-III';
                                    } else if ($ktp[0]->pend_terakhir == 7) {
                                        echo 'D-IV/S1';
                                    } else if ($ktp[0]->pend_terakhir == 8) {
                                        echo 'S2/S3';
                                    }
                                    ?>
                                </option
                                <option value="1" >Tidak Sekolah</option>
                                <option value="2" >SD</option>
                                <option value="3" >SLTP</option>
                                <option value="4" >SLTA</option>
                                <option value="5" >D-I/D-II</option>
                                <option value="6" >D-III</option>
                                <option value="7" >D-IV/S1</option>
                                <option value="8" >S2/S3</option></select>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="pekerjaan" class="select2 form-control custom-select" style="width: 100%; height:36px;" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="<?php echo $ktp[0]->pekerjaan; ?>">
                                    <?php
                                    if (!empty($pekerjaan)) {
                                        foreach ($pekerjaan as $key => $value) {
                                            if ($value->id == $ktp[0]->pekerjaan) {
                                                ?>
                                                <?php echo ucwords($value->job); ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>
                                <?php
                                if (!empty($pekerjaan)) {
                                    foreach ($pekerjaan as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo ucwords($value->job); ?></option>                                     
                                        <?php
                                    }
                                }
                                ?>                       
                            </select>
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-2 m-t-5">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="custom-control custom-radio m-t-10">
                                <input type="radio" id="kawin1" value="0" name="status_nikah" class="custom-control-input" <?php echo ($ktp[0]->status_nikah == '0') ? 'checked' : '' ?> required data-validation-required-message="Kolom ini wajib diisi!">
                                <label class="custom-control-label" for="kawin1">Belum Menikah</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin2" value="1" name="status_nikah" class="custom-control-input" <?php echo ($ktp[0]->status_nikah == '1') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="kawin2">Menikah</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin3" value="2" name="status_nikah" class="custom-control-input" <?php echo ($ktp[0]->status_nikah == '2') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="kawin3">Cerai Hidup</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin4" value="3" name="status_nikah" class="custom-control-input" <?php echo ($ktp[0]->status_nikah == '3') ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="kawin4">Cerai Mati</label>
                            </div>
                        </fieldset>
                    </div>         

                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Tel. Rumah <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_rumah_ktp" data-mask="00000000000000" value="<?php echo $ktp[0]->nomor_rumah_ktp; ?>" class="form-control" placeholder="Isikan nomor tlp rumah">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Handphone <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_hp_ktp" data-mask="00000000000000" value="<?php echo $ktp[0]->nomor_hp_ktp; ?>" class="form-control" placeholder="Isikan nomor HP" required data-validation-required-message="Kolom ini wajib diisi!">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Tel. Kantor <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_kantor_ktp" data-mask="00000000000000" value="<?php echo $ktp[0]->nomor_kantor_ktp; ?>" class="form-control" placeholder="Isikan nomor tlp kantor">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Faksimili <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_faksimili_ktp" data-mask="00000000000000" value="<?php echo $ktp[0]->nomor_faksimili_ktp; ?>" class="form-control" placeholder="Isikan no faksimili">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Foto ID Anggota <span class="text-danger">*</span></label>
                        <input type="text" name="image" value="<?php echo $ktp[0]->img ?>" style="display:none" />
                        <input type="text" name="image_thumb" value="<?php echo $ktp[0]->img_thumb; ?>" style="display:none" />
                        <input type="file" name="img" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $ktp[0]->img ?>"/>
                        <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                    </div>    
                    <div class="form-group col-md-6 m-t-10">
                        <label>Foto PAS Anggota <span class="text-danger">*</span></label>
                        <input type="text" name="image_pas" value="<?php echo $ktp[0]->img_pas ?>" style="display:none" />
                        <input type="text" name="image_pas_thumb" value="<?php echo $ktp[0]->img_pas_thumb; ?>" style="display:none" />
                        <input type="file" name="img_pas" class="dropify" data-max-file-size="2M" data-height="300" data-allowed-file-extensions="jpg png jpeg ico" data-default-file="<?php echo base_url() . $ktp[0]->img_pas ?>"/>
                        <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                    </div>   
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor KTA Lama <span class="text-danger">*</span></label>
                        <div class="input-group">                            
                            <input type="text" data-mask="99999999999999999999999"  value="<?php echo $ktp[0]->nik_kta_lama; ?>" name="nik_kta_lama" class="form-control" placeholder="Isikan nomor KTA lama">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nomor KTA Baru <span class="text-danger">*</span></label>
                        <div class="input-group">                            
                            <input type="text" data-mask="99999999999999999999999"  value="<?php echo $ktp[0]->nik_kta_baru; ?>" class="form-control" disabled="">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small id="info" class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                    </div>
                    <div class="form-group col-md-5 m-t-10">
                        <label>Nama Alias Region Anggota<span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="region_anggota" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="region_anggota" required data-validation-required-message="Kolom ini wajib diisi!">
                                <?php
                                if (!empty($admin_regional) && $ktp[0]->id_admin != null) {
                                    foreach ($admin_regional as $key => $value) {
                                        if ($value->id_ref == $ktp[0]->id_admin) {
                                            ?>
                                            <option value="<?php echo $ktp[0]->id_admin; ?>" selected="">
                                                <?php echo strtoupper($value->provinsi); ?>
                                                <?php
                                                if ($value->kabupaten != NULL) {
                                                    echo ' - ' . strtoupper($value->kabupaten);
                                                }
                                                ?>                                
                                            </option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <?php if (empty($ktp[0]->id_admin) or $ktp[0]->id_admin == 0) {
                                    ?>
                                    <option value="" selected="">Pilih nama regional</option>
                                <?php } ?>
                                </option>

                            </select>
                        </fieldset>
                    </div>    
                    <div class="form-group col-md-5 m-t-10">
                        <label>Nama Petugas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="nama_petugas" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="nama_petugas" required data-validation-required-message="Kolom ini wajib diisi!">
                                <?php
                                if (!empty($petugas)) {
                                    foreach ($petugas as $key => $values) {
                                        if ($values->id_petugas == $ktp[0]->id_petugas) {
                                            ?>
                                            <option value="<?php echo $ktp[0]->id_petugas; ?>" selected="">
                                                <?php echo ucwords($values->nama_petugas); ?>  
                                            </option> 
                                        <?php } else { ?>
                                            <option value="<?php echo $ktp[0]->id_petugas; ?>" selected="">
                                                <?php echo ucwords($values->nama_petugas); ?>  
                                            </option> 
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <?php if ($ktp[0]->id_petugas == 0) { ?>
                                    <option value="<?php echo $ktp[0]->id_petugas; ?>" selected="">
                                        Petugas belum dipilih  
                                    </option>  
                                <?php } ?>
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Tanggal Daftar <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">
                                <input type="text" name="tanggal_daftar" class="form-control" value="<?php echo $ktp[0]->tanggal_daftar; ?>" placeholder="Tanggal daftar" id="mdate_kta" required data-validation-required-message="Kolom ini wajib diisi!">                          
                            </div>
                        </fieldset>
                    </div>
                    <input type="hidden" name="pengurus" class="form-control" value="2">          
                    <div id="pengurus">
                        <div class="col-md-12 m-t-10">
                            <h5 class="card-subtitle text-danger"><b>Pemilihan Pengurus </b></h5>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label>Pilih pengurus <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="pengurus" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <option value="<?php echo $ktp[0]->pengurus; ?>">
                                        <?php
                                        if ($ktp[0]->pengurus == 1) {
                                            echo 'Ya';
                                        } else if ($ktp[0]->pengurus == 2) {
                                            echo 'Tidak';
                                        }
                                        ?>
                                    </option>
                                    <option value="1">Ya</option> 
                                    <option value="2">Tidak</option>                            
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label><span class="text-danger">*</span></label>
                            <select name="kategori" class="form-control">
                                <option value="<?php echo $ktp[0]->kategori; ?>">
                                    <?php
                                    if ($ktp[0]->kategori == 1) {
                                        echo 'DPP';
                                    } else if ($ktp[0]->kategori == 2) {
                                        echo 'DPD';
                                    } else if ($ktp[0]->kategori == 3) {
                                        echo 'DPC';
                                    } else if ($ktp[0]->kategori == 4) {
                                        echo 'PAC';
                                    } else if ($ktp[0]->kategori == 5) {
                                        echo 'Ranting';
                                    }
                                    ?>
                                </option>
                                <option value="1">DPP</option> 
                                <option value="2">DPD</option>  
                                <option value="3">DPC</option> 
                                <option value="4">PAC</option>
                                <option value="5">Ranting</option>
                            </select>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-6 m-t-10">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" value="<?php echo $ktp[0]->jabatan; ?>" placeholder="Isikan jabatan">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label>Pilih Regional Pengurus <span class="text-danger">*</span></label>
                            <select name="provinsi_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi_peng">
                                <option value="<?php echo substr($ktp[0]->wilayah_pengurus, 0, 2); ?>">
                                    <?php
                                    if (!empty($prov)) {
                                        foreach ($prov as $key => $value) {
                                            if ($value->id == substr($ktp[0]->wilayah_pengurus, 0, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option>                           
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
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label></label>
                            <select name="kabupaten_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kabupaten_peng" >
                                <option value="<?php echo substr($ktp[0]->wilayah_pengurus, 2, 2); ?>">
                                    <?php
                                    if (!empty($kab)) {
                                        foreach ($kab as $key => $value) {
                                            if ($value->id == substr($ktp[0]->wilayah_pengurus, 2, 2) && $value->id_dati1 == substr($ktp[0]->wilayah_pengurus, 0, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option> 
                                <option value=""></option>
                            </select>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label></label>
                            <select name="kecamatan_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kecamatan_peng" >
                                <option value="<?php echo substr($ktp[0]->wilayah_pengurus, 4, 2); ?>">
                                    <?php
                                    if (!empty($kec)) {
                                        foreach ($kec as $key => $value) {
                                            if ($value->id == substr($ktp[0]->wilayah_pengurus, 4, 2) && $value->id_dati1 == substr($ktp[0]->wilayah_pengurus, 0, 2) && $value->id_dati2 == substr($ktp[0]->wilayah_pengurus, 2, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option> 
                                <option value=""></option>
                            </select>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10" >
                            <label></label>
                            <select name="kelurahan_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kelurahan_peng" >
                                <option value="<?php echo substr($ktp[0]->wilayah_pengurus, 6, 2); ?>">
                                    <?php
                                    if (!empty($kel)) {
                                        foreach ($kel as $key => $value) {
                                            if ($value->id == substr($ktp[0]->wilayah_pengurus, 6, 2) && $value->id_dati1 == substr($ktp[0]->wilayah_pengurus, 0, 2) && $value->id_dati2 == substr($ktp[0]->wilayah_pengurus, 2, 2) && $value->id_dati3 == substr($ktp[0]->wilayah_pengurus, 4, 2)) {
                                                ?>
                                                <?php echo $value->nama; ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </option> 
                                <option value=""></option>
                            </select>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div> 
                    </div>
                    <div class="col-md-12 m-t-10">
                        <h5 class="card-subtitle text-danger"><b>Sosial Media </b></h5>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Facebook <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="facebook" class="form-control" value="<?php echo $ktp[0]->facebook; ?>" placeholder="Isikan ID facebook">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Twitter <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="twitter" class="form-control" value="<?php echo $ktp[0]->twitter; ?>" placeholder="Isikan ID twitter">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Whatsapp <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="whatsapp" class="form-control" data-mask="00000000000000" value="<?php echo $ktp[0]->whatsapp; ?>" placeholder="Isikan no whatsapp">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Instagram <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="instagram" class="form-control" value="<?php echo $ktp[0]->instagram; ?>" placeholder="Isikan ID instagram">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
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

    });
</script>

<script>
    $(document).ready(function () {

        var id_prov;
        var id_kab;
        var id_kec;

        $("#provinsi_peng").change(function () {
            id_prov = $(this).val();
            var url = "<?php echo site_url('ktp/add_ajax_kab'); ?>/" + id_prov;
            $('#kabupaten_peng').load(url);
            return false;
        })
        $("#kabupaten_peng").change(function () {
            id_kab = $(this).val();
            var url = "<?php echo site_url('ktp/add_ajax_kec'); ?>/" + id_prov + "/" + id_kab;
            $('#kecamatan_peng').load(url);
            return false;
        })
        $("#kecamatan_peng").change(function () {
            id_kec = $(this).val()
            var url = "<?php echo site_url('ktp/add_ajax_des'); ?>/" + id_prov + "/" + id_kab + "/" + id_kec;
            $('#kelurahan_peng').load(url);
            return false;
        })

        $(function () {
            var kat = $('select[name="kategori"]');
            var input = $('input[name="jabatan"]');
            var prov = $('select[name="provinsi_peng"]');
            var kab = $('select[name="kabupaten_peng"]');
            var kec = $('select[name="kecamatan_peng"]');
            var kel = $('select[name="kelurahan_peng"]');
            kat.prop('disabled', true);
            input.prop('disabled', true);

<?php if ($ktp[0]->pengurus == 1) { ?>
                kat.prop('disabled', false);
                input.prop('disabled', false);
<?php } ?>
            $('select[name ="pengurus"]').change(function () {
                if ($(this).val() == 1) {
                    kat.prop('disabled', false);
                    input.prop('disabled', false);
                } else {
                    kat.prop('disabled', true);
                    input.prop('disabled', true);
                    kat.prop('selectedIndex', 0);
                    input.val("");
                    prov.prop('disabled', true);
                    kab.prop('disabled', true);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                }
            });

            prov.prop('disabled', true);
            kab.prop('disabled', true);
            kec.prop('disabled', true);
            kel.prop('disabled', true);

<?php if (substr($ktp[0]->wilayah_pengurus, 0, 2) != "") { ?>
                prov.prop('disabled', false);
<?php } if (substr($ktp[0]->wilayah_pengurus, 2, 2) != "") { ?>
                kab.prop('disabled', false);
<?php } if (substr($ktp[0]->wilayah_pengurus, 4, 2) != "") { ?>
                kec.prop('disabled', false);
<?php } if (substr($ktp[0]->wilayah_pengurus, 6, 2) != "") { ?>
                kel.prop('disabled', false);
<?php } ?>

            $('select[name ="kategori"]').change(function () {
                if ($(this).val() == 1) {
                    prov.prop('disabled', true);
                    kab.prop('disabled', true);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                    prov.val("").trigger('change');
                    kab.val("").trigger('change');
                    kec.val("").trigger('change');
                    kel.val("").trigger('change');
                } else if ($(this).val() == 2) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', true);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                    kab.val("").trigger('change');
                    kec.val("").trigger('change');
                    kel.val("").trigger('change');
                } else if ($(this).val() == 3) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', false);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                    kec.val("").trigger('change');
                    kel.val("").trigger('change');
                } else if ($(this).val() == 4) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', false);
                    kec.prop('disabled', false);
                    kel.prop('disabled', true);
                    kel.val("").trigger('change');
                } else if ($(this).val() == 5) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', false);
                    kec.prop('disabled', false);
                    kel.prop('disabled', false);

                }
            });
        });

    });
</script>

<script>
    var b = document.getElementById('info');
    function checkNikRealTime(nik_usr) {
        $.ajax({
            type: "POST", //type of the request to make
            url: "<?php echo base_url(); ?>ktp/cek_nik_ktp",
            data: {nik: nik_usr},
            success: function (result) {
                if (result == 0) {
                    b.innerHTML = "<b class='text-danger'>*NIK Anda Duplikat</b>";
                } else {
                    b.innerHTML = "<b class='text-success'>*NIK Anda Tidak Duplikat</b>";
                }
            }
        });
    }
</script>
