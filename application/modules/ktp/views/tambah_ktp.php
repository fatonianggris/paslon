<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Tambah Anggota</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Anggota</a></li>
                <li class="breadcrumb-item active">Tambah Anggota</li>
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
                <h4 class="card-title">Formulir Tambah Anggota</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah Anggota yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('ktp/kirim_ktp'); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-6 m-t-10">
                        <label>Nama ID <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="nama_ktp" class="form-control ktp" placeholder="Isikan nama anggota" required data-validation-required-message="Kolom ini wajib diisi!">
                        </fieldset>                      
                    </div>                    
                    <div class="form-group col-md-6 m-t-10">
                        <label>No Identitas <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" onkeyup="checkNikRealTime(this.value)" data-mask="9999999999999999" maxlength="16" name="nik_ktp" class="form-control" placeholder="Isikan No Identitas" required data-validation-required-message="Kolom ini wajib diisi!">
                                <div class="input-group-append">
                                    <span class="input-group-text">Angka</span>
                                </div>
                            </div>
                        </fieldset>
                        <small id="info" class="form-control-feedback"></small>
                    </div>                 
                    <div class="form-group col-md-3 m-t-10">
                        <label>Tempat/Tanggal Lahir <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="tempat_lahir" class="select2 form-control custom-select" style="width: 100%; height:36px;" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Kabupaten</option>
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
                                <input type="text" name="tanggal_lahir" class="form-control" placeholder="Tanggal lahir" id="mdate" required data-validation-required-message="Kolom ini wajib diisi!">                          
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-5">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="custom-control custom-radio m-t-10">
                                <input type="radio" id="jk1" value="1" name="jenis_kelamin" required class="custom-control-input" data-validation-required-message="Kolom ini wajib diisi!">
                                <label class="custom-control-label" for="jk1">Laki-Laki</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="jk2" value="0" name="jenis_kelamin" class="custom-control-input">
                                <label class="custom-control-label" for="jk2">Perempuan</label>
                            </div>
                        </fieldset>                     
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Golongan Darah <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="gol_darah" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih golongan darah</option>
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
                            <input type="text" name="email" class="form-control" placeholder="Isikan email" required data-validation-required-message="Kolom ini wajib diisi!">
                        </fieldset>                      
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Pilih Alamat Asal ID <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="provinsi" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Provinsi</option>
                                <?php
                                if (!empty($provinsi)) {
                                    foreach ($provinsi as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id; ?>"><?php echo strtoupper($value->nama); ?></option>                                     
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
                                <option value="">Pilih Kabupaten</option>                                       
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label></label>
                        <fieldset class="controls">
                            <select name="kecamatan" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kecamatan" required data-validation-required-message="Kolom ini wajib diisi!"> 
                                <option value="">Pilih Kecamatan</option>            
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10" >
                        <label></label>
                        <fieldset class="controls">
                            <select name="kelurahan" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kelurahan" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih Kelurahan/Desa</option>            
                            </select>
                        </fieldset>
                    </div>                   
                    <div class="form-group col-md-6 m-t-10">
                        <label>Alamat ID <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="alamat_ktp" class="form-control" placeholder="Isikan Alamat Anggota" required data-validation-required-message="Kolom ini wajib diisi!">     
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>RT <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <div class="input-group">                            
                                <input type="text" name="rt" class="form-control" placeholder="Isikan RT" data-mask="9999" required  data-validation-required-message="Kolom ini wajib diisi!">
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
                                <input type="text" name="rw" class="form-control" placeholder="Isikan RW" data-mask="9999" required  data-validation-required-message="Kolom ini wajib diisi!">
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
                                <input type="text" name="kodepos" class="form-control" placeholder="Isikan Kodepos" data-mask="99999" >                         
                            </div>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Agama <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="agama" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih agama di ID Anggota</option>
                                <option value="1">Islam</option> 
                                <option value="2">Kristen</option> 
                                <option value="3">Hindu</option> 
                                <option value="4">Budha</option> 
                                <option value="5">Lainnya.</option> 
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="pend_terakhir" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih pendidikan</option>
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
                                <option value="">Pilih pekerjaan</option>
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
                                <input type="radio" id="kawin1" value="0" required name="status_nikah" class="custom-control-input" required data-validation-required-message="Kolom ini wajib diisi!">
                                <label class="custom-control-label" for="kawin1">Belum Menikah</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin2" value="1" name="status_nikah" class="custom-control-input">
                                <label class="custom-control-label" for="kawin2">Menikah</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin3" value="2" name="status_nikah" class="custom-control-input">
                                <label class="custom-control-label" for="kawin3">Cerai Hidup</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="kawin4" value="3" name="status_nikah" class="custom-control-input">
                                <label class="custom-control-label" for="kawin4">Cerai Mati</label>
                            </div>
                        </fieldset>
                    </div>                        
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Tel. Rumah <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_rumah_ktp" class="form-control" data-mask="00000000000000" placeholder="Isikan nomor tlp rumah">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Handphone <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_hp_ktp" class="form-control" data-mask="00000000000000" placeholder="Isikan nomor HP" required data-validation-required-message="Kolom ini wajib diisi!">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Tel. Kantor <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_kantor_ktp" class="form-control" data-mask="00000000000000" placeholder="Isikan nomor tlp kantor" >
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nomor Faksimili <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="nomor_faksimili_ktp" class="form-control" data-mask="00000000000000" placeholder="Isikan no faksimili">
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>               
                    <div class="form-group col-md-6 m-t-10">
                        <label>Foto ID Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="file" name="img" class="dropify" data-max-file-size="2M" data-height="200" required="" data-allowed-file-extensions="jpg png jpeg ico"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-6 m-t-10">
                        <label>Pas Foto Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="file" name="img_pas" class="dropify" data-max-file-size="2M" data-height="200" required="" data-allowed-file-extensions="jpg png jpeg ico"/>
                            <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>2 Mb</b> ! </small>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-4 m-t-10">
                        <label>Nomor KTA Lama <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" onkeyup="checkNikRealTime(this.value)" name="nik_kta_lama" data-mask="99999999999999999999999" class="form-control" placeholder="Isikan Nomor KTA Lama" >
                            <div class="input-group-append">
                                <span class="input-group-text">Angka</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nama Region Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="region_anggota" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="region_anggota" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih region pemungutan</option>
                                <?php
                                if (!empty($admin_regional)) {
                                    foreach ($admin_regional as $key => $value) {
                                        ?>
                                        <option value="<?php echo $value->id_ref; ?>">
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
                                ?>                        
                            </select>
                        </fieldset>
                    </div>  
                    <div class="form-group col-md-3 m-t-10">
                        <label>Nama Petugas  <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <select name="nama_petugas" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="nama_petugas" required data-validation-required-message="Kolom ini wajib diisi!">
                                <option value="">Pilih petugas pemungutan</option>            
                            </select>
                        </fieldset>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <label>Tanggal Daftar <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="tanggal_daftar" class="form-control" value="<?php echo date("d/m/Y"); ?>" placeholder="Tanggal daftar" id="mdate_kta" required data-validation-required-message="Kolom ini wajib diisi!">                          
                        </div>                       
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
                                    <option value="">Pilih status</option>
                                    <option value="1">Ya</option> 
                                    <option value="2">Tidak</option>                            
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-control">
                                <option value="">Pilih kategori</option>
                                <option value="1">DPP</option> 
                                <option value="2">DPD</option>  
                                <option value="3">DPC</option> 
                                <option value="4">PAC</option>
                                <option value="5">Ranting</option>
                            </select>
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div>
                        <div class="form-group col-md-6 m-t-10">
                            <label>Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Isikan jabatan" >
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label>Pilih Regional/Wilayah Pengurus <span class="text-danger">*</span></label>
                            <select name="provinsi_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="provinsi_peng" >
                                <option value=""></option>
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
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label></label>
                            <select name="kabupaten_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kabupaten_peng" >
                                <option value="">Pilih Kabupaten</option>                                       
                            </select>
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10">
                            <label></label>
                            <select name="kecamatan_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kecamatan_peng">
                                <option value="">Pilih Kecamatan</option>            
                            </select>
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div>
                        <div class="form-group col-md-3 m-t-10" >
                            <label></label>
                            <select name="kelurahan_peng" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="kelurahan_peng">
                                <option value="">Pilih Kelurahan/Desa</option>            
                            </select>
                            <small class="form-control-feedback">*Kolom <b>WAJIB</b> Diisi ! </small>
                        </div> 
                    </div>
                    <div class="col-md-12 m-t-10">
                        <h5 class="card-subtitle text-danger"><b>Sosial Media </b></h5>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Facebook <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="facebook" class="form-control" placeholder="Isikan ID facebook">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Twitter <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="twitter" class="form-control" placeholder="Isikan ID twitter">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Whatsapp <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="whatsapp" class="form-control" data-mask="00000000000000" placeholder="Isikan no whatsapp">
                            <div class="input-group-append">
                                <span class="input-group-text">Link</span>
                            </div>
                        </div>
                        <small class="form-control-feedback">*Kolom Ini <b>TIDAK</b> Harus Diisi ! </small>
                    </div>
                    <div class="form-group col-md-6 m-t-1">
                        <label>Instagram <span class="text-danger"></span></label>
                        <div class="input-group">                            
                            <input type="text" name="instagram" class="form-control" placeholder="Isikan ID instagram">
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

    document.getElementById("pengurus").hidden = true;
    $('#mdate').bootstrapMaterialDatePicker({weekStart: 0, time: false, format: 'DD/MM/YYYY'});
    $('#mdate').bootstrapMaterialDatePicker('setDate', '01/01/2000').change()
    $('#mdate').val(null).change();

</script> 
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
            kat.prop('disabled', true);
            input.prop('disabled', true);

            $('select[name ="pengurus"]').change(function () {
                if ($(this).val() == 1) {
                    kat.prop('disabled', false);
                    input.prop('disabled', false);
                } else {
                    kat.prop('disabled', true);
                    input.prop('disabled', true);
                    kat.prop('selectedIndex', 0);
                    input.val("");
                }
            });
            var prov = $('select[name="provinsi_peng"]');
            var kab = $('select[name="kabupaten_peng"]');
            var kec = $('select[name="kecamatan_peng"]');
            var kel = $('select[name="kelurahan_peng"]');
            prov.prop('disabled', true);
            kab.prop('disabled', true);
            kec.prop('disabled', true);
            kel.prop('disabled', true);

            $('select[name ="kategori"]').change(function () {
                if ($(this).val() == 1) {
                    prov.val('').trigger('change');
                    kab.val('').trigger('change');
                    kec.val('').trigger('change');
                    kel.val('').trigger('change');
                    prov.prop('disabled', true);
                    kab.prop('disabled', true);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                } else if ($(this).val() == 2) {
                    kab.val('').trigger('change');
                    kec.val('').trigger('change');
                    kel.val('').trigger('change');
                    prov.prop('disabled', false);
                    kab.prop('disabled', true);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                } else if ($(this).val() == 3) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', false);
                    kec.prop('disabled', true);
                    kel.prop('disabled', true);
                } else if ($(this).val() == 4) {
                    prov.prop('disabled', false);
                    kab.prop('disabled', false);
                    kec.prop('disabled', false);
                    kel.prop('disabled', true);
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
