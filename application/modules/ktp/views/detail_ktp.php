<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php
$usr = $this->session->userdata("ktpapps");
?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Detail Anggota</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Anggota</a></li>
                <li class="breadcrumb-item active">Detail Anggota</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('ktp/tambah_ktp'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data E-KTP</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Data NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Data E-KTP</button>
            <?php } ?>
           
        </div>
    </div>
</div>
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-xlg-3 col-md-5">
        <div class="card">
            <div class="card-body">
                <center class="m-t-30">
                    <?php if ($detail[0]->img == true) {
                        ?>
                        <img src="<?php echo base_url() . $detail[0]->img; ?>" width="350" />
                    <?php } else { ?>
                        <img src="<?php echo base_url() . 'uploads/data/ktp_contoh.png'; ?>" width="350" >
                        <small class="text-center text-danger"><b>E-KTP Belum Diinputkan!</b></small>
                    <?php } ?>

                </center>
            </div>
            <div>
                <hr> 
            </div>
            <div class="card-body"> 
                <small class=""><b>Regional Anggota </b></small>
                <h6>
                    <?php echo ucwords($detail[0]->provinsi); ?>
                    <?php
                    if ($detail[0]->kabupaten != NULL) {
                        echo ' - ' . strtoupper($detail[0]->kabupaten);
                    }
                    ?>
                </h6> 
                <small class=" p-t-30 db"><b>Provinsi </b></small>
                <h6>
                    <?php
                    if (!empty($prov)) {
                        foreach ($prov as $key => $value) {
                            if ($value->id == substr($detail[0]->id_asal, 0, 2)) {
                                ?>
                                <?php echo $value->nama; ?>                                    
                                <?php
                            }
                        }
                    }
                    ?>     
                </h6>
                <small class=" p-t-30 db"><b>Kabupaten </b></small>
                <h6>
                    <?php
                    if (!empty($kab)) {
                        foreach ($kab as $key => $value) {
                            if ($value->id == substr($detail[0]->id_asal, 2, 2) && $value->id_dati1 == substr($detail[0]->id_asal, 0, 2)) {
                                ?>
                                <?php echo $value->nama; ?>                                    
                                <?php
                            }
                        }
                    }
                    ?>     
                </h6>
                <small class=" p-t-30 db"><b>Kecamatan </b></small>
                <h6>
                    <?php
                    if (!empty($kec)) {
                        foreach ($kec as $key => $value) {
                            if ($value->id == substr($detail[0]->id_asal, 4, 2) && $value->id_dati1 == substr($detail[0]->id_asal, 0, 2) && $value->id_dati2 == substr($detail[0]->id_asal, 2, 2)) {
                                ?>
                                <?php echo $value->nama; ?>                                    
                                <?php
                            }
                        }
                    }
                    ?>     
                </h6>
                <small class="p-t-30 db"><b>Kelurahan </b></small>
                <h6>
                    <?php
                    if (!empty($kel)) {
                        foreach ($kel as $key => $value) {
                            if ($value->id == substr($detail[0]->id_asal, 6, 2) && $value->id_dati1 == substr($detail[0]->id_asal, 0, 2) && $value->id_dati2 == substr($detail[0]->id_asal, 2, 2) && $value->id_dati3 == substr($detail[0]->id_asal, 4, 2)) {
                                ?>
                                <?php echo $value->nama; ?>                                    
                                <?php
                            }
                        }
                    }
                    ?>     
                </h6> 

            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs profile-tab" role="tablist">               
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab">Profile</a> </li>

            </ul>
            <!-- Tab panes -->

            <div class="tab-content a">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>NIK e-KTP</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nik_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nomor KTA</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nik_kta_baru; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama</strong>
                                <br>
                                <p class="text-muted"><?php echo ucwords($detail[0]->nama_ktp); ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Tempat/Tanggal Lahir</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($detail[0]->tempat_lahir); ?>, <?php echo $detail[0]->tanggal_lahir; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Jenis Kelamin</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->jenis_kelamin == 1) {
                                        echo 'Laki-laki';
                                    } else if ($detail[0]->jenis_kelamin == 0) {
                                        echo 'Perempuan';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Golongan Darah</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->gol_darah == 1) {
                                        echo 'A';
                                    } else if ($detail[0]->gol_darah == 2) {
                                        echo 'B';
                                    } else if ($detail[0]->gol_darah == 3) {
                                        echo 'AB';
                                    } else if ($detail[0]->gol_darah == 4) {
                                        echo 'O';
                                    } else if ($detail[0]->gol_darah == 5) {
                                        echo 'Lainnya';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Alamat e-KTP</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->alamat_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>No. RT</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->rt; ?></p>
                            </div>                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>No RW</strong>
                                <br>
                                <p class="text-muted"><?php echo ucwords($detail[0]->rw); ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Agama</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->agama == 1) {
                                        echo 'Islam';
                                    } else if ($detail[0]->agama == 2) {
                                        echo 'Kristen';
                                    } else if ($detail[0]->agama == 3) {
                                        echo 'Hindu';
                                    } else if ($detail[0]->agama == 4) {
                                        echo 'Budha';
                                    } else {
                                        echo 'Lainnya';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Status Perkawinan</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->status_nikah == 0) {
                                        echo 'Belum Menikah';
                                    } else if ($detail[0]->status_nikah == 1) {
                                        echo 'Menikah';
                                    } else if ($detail[0]->status_nikah == 2) {
                                        echo 'Cerai Hidup';
                                    } else if ($detail[0]->status_nikah == 3) {
                                        echo 'Cerai Mati';
                                    } else {
                                        echo 'Lainnya';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Pekerjaan e-KTP</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if (!empty($pekerjaan)) {
                                        foreach ($pekerjaan as $key => $value) {
                                            if ($value->id == $detail[0]->pekerjaan) {
                                                ?>
                                                <?php echo ucwords($value->job); ?>                                    
                                                <?php
                                            }
                                        }
                                    }
                                    ?>     
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Pendidikan Terakhir</strong>
                                <br>
                                <p class="text-muted">                                
                                    <?php
                                    if ($detail[0]->pend_terakhir == 1) {
                                        echo 'Tidak Sekolah';
                                    } else if ($detail[0]->kategori == 2) {
                                        echo 'SD';
                                    } else if ($detail[0]->kategori == 3) {
                                        echo 'SLTP';
                                    } else if ($detail[0]->kategori == 4) {
                                        echo 'SLTA';
                                    } else if ($detail[0]->kategori == 5) {
                                        echo 'D-I/D-II';
                                    } else if ($detail[0]->kategori == 6) {
                                        echo 'D-III';
                                    } else if ($detail[0]->kategori == 7) {
                                        echo 'D-IV/S1';
                                    } else {
                                        echo 'S2/S3';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Kodepos</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->alamat_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Nomor Handphone </strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nomor_hp_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nomor Rumah</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nomor_rumah_ktp; ?></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nomor Kantor</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nomor_kantor_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nomor Faksimili</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->nomor_faksimili_ktp; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Pengurus </strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->pengurus == 1) {
                                        echo 'Ya';
                                    } else if ($detail[0]->pengurus == 2) {
                                        echo 'Tidak';
                                    }
                                    ?>
                                </p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Kategori Pengurus</strong>
                                <br>
                                <p class="text-muted">
                                    <?php
                                    if ($detail[0]->kategori == 1) {
                                        echo 'DPP';
                                    } else if ($detail[0]->kategori == 2) {
                                        echo 'DPD';
                                    } else if ($detail[0]->kategori == 3) {
                                        echo 'DPC';
                                    } else if ($detail[0]->kategori == 4) {
                                        echo 'PAC';
                                    } else {
                                        echo 'Ranting';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Facebook</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->facebook; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Twitter</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->twitter; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6"> <strong>Instagram</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->instagram; ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Whatsapp</strong>
                                <br>
                                <p class="text-muted"><?php echo $detail[0]->whatsapp; ?></p>
                            </div>
                        </div>
                        <hr>
                        <a onclick="history.back()"><button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Kembali"><i class="ti-back-left" aria-hidden="true"></i> Kembali</button></a>
                        <a href="<?php echo site_url('ktp/get_ktp/' . $detail[0]->id_ktp); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit"><i class="ti-pencil" aria-hidden="true"></i> Edit</button></a>
                        <a href="<?php echo site_url('petugas/tambah_petugas_anggota/' . $detail[0]->id_ktp); ?>" class="pull-right"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit"><i class="ti-user" aria-hidden="true"></i> Jadikan Petugas</button></a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>