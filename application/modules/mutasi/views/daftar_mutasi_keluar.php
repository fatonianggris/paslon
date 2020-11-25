<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Mutasi Anggota Keluar</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Mutasi Anggota</a></li>
                <li class="breadcrumb-item active">Daftar Mutasi Anggota Keluar</li>
            </ol>
            <a href="<?php echo site_url('akun/tambah_admin_nasional'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Admin Nasional </button></a>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-shift-left"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->all_admin; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Mutasi Masuk</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-shift-right"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->superadmin; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Mutasi Keluar</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-warning">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->admin_kab; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Anggota</h5></div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Mutasi Anggota Keluar</h4>
                <h6 class="card-subtitle">Daftar mutasi anggota keluar terkait nama, status, regional tujuan dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_admin_nas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                
                                <th>Region Asal</th>                               
                                <th>Region Tujuan</th>                                
                                <th>Nama Anggota</th>  
                                <th>No. KTP</th>  
                                <th>No. KTA Lama</th>  
                                <th>No.HP</th>
                                <th>Status Mutasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Region Asal</th>                               
                                <th>Region Tujuan</th>                                
                                <th>Nama Anggota</th>  
                                <th>No. KTP</th>  
                                <th>No. KTA Lama</th>  
                                <th>No.HP</th>
                                <th>Status Mutasi</th>
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($mutasi_anggota_keluar)) {
                                $i = 1;
                                foreach ($mutasi_anggota_keluar as $key => $value) {
                                    ?> 
                                    <tr>                                      
                                        <td>
                                            <?php echo ucwords($value->provinsi_asal); ?>
                                            <?php
                                            if ($value->kabupaten_asal != NULL) {
                                                echo ' - ' . strtoupper($value->kabupaten_asal);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo ucwords($value->provinsi_tujuan); ?>
                                            <?php
                                            if ($value->kabupaten_tujuan != NULL) {
                                                echo ' - ' . strtoupper($value->kabupaten_tujuan);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo strtoupper($value->nama_anggota); ?>
                                        </td>
                                        <td>
                                            <?php echo $value->nik_ktp; ?>
                                        </td> 
                                        <td>
                                            <?php echo $value->no_kta_lama; ?>
                                        </td> 
                                        <td><?php echo $value->nomor_hp; ?></td>   
                                        <?php if ($value->status_mutasi == 1) { ?> 
                                            <td><span class="label label-warning"><b>DIKIRIMKAN</b></span></td>
                                        <?php } elseif ($value->status_mutasi == 2) { ?>
                                            <td><span class="label label-success"><b>DITERIMA</b></span></td>
                                        <?php } elseif ($value->status_mutasi == 3) { ?>
                                            <td><span class="label label-danger"><b>DITOLAK</b></span></td>
                                            <?php
                                        }
                                        ?>                                      
                                        <td>
                                            <?php if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) { ?>
                                                <a onclick="act_del_anggota_mutasi(<?php echo $value->id_mutasi; ?>, '<?php echo $value->nama_anggota; ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Mutasi"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Mutasi NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <?php if ($value->status_mutasi == 1) { ?> 
                                                <?php if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) { ?>
                                                    <a data-target="#edit_mutasi<?php echo $value->id_mutasi; ?>" data-toggle="modal" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-original-title="Edit Mutasi"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Mutasi NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) { ?>
                                                <a data-target="#lihat_mutasi<?php echo $value->id_mutasi; ?>" data-toggle="modal"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Lihat Mutasi"><i class="ti-eye" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Lihat Mutasi NonAktif (*hub petugas)"><i class="ti-printer" aria-hidden="true"></i></button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }  //ngatur nomor urut
                            }
                            ?>         
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if (!empty($mutasi_anggota_keluar)) {
    foreach ($mutasi_anggota_keluar as $key => $value) {
        ?> 
        <div id="lihat_mutasi<?php echo $value->id_mutasi; ?>" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-danger" id="myModalLabel"><b>Mutasi Anggota </b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">                  
                        <div class="card">
                            <div class="card-body"> 
                                <small class=""><strong>NAMA ANGGOTA </strong></small>
                                <h6><span class="label label-warning"><b><?php echo strtoupper($value->nama_anggota); ?></b></span></h6> 
                                <small class="p-t-30 db"><strong>REGION ASAL</strong></small>
                                <h6>
                                    <?php echo ucwords($value->provinsi_asal); ?>
                                    <?php
                                    if ($value->kabupaten_asal != NULL) {
                                        echo ' - ' . strtoupper($value->kabupaten_asal);
                                    }
                                    ?>
                                </h6> 
                                <small class="p-t-30 db"><strong>REGION TUJUAN</strong></small>
                                <h6>

                                    <?php echo ucwords($value->provinsi_tujuan); ?>
                                    <?php
                                    if ($value->kabupaten_tujuan != NULL) {
                                        echo ' - ' . strtoupper($value->kabupaten_tujuan);
                                    }
                                    ?>
                                </h6>     
                                <small class="p-t-30 db"><strong>STATUS KEANGGOTAAN</strong></small>
                                <h6>
                                    <?php if ($value->status_pengurus == 2) { ?> 
                                        <span class="label label-success"><b>PENGURUS</b></span>
                                    <?php } elseif ($value->status_pengurus == 1) { ?>
                                        <span class="label label-warning"><b>ANGGOTA</b></span>
                                    <?php } ?>
                                </h6>     
                                <small class="p-t-30 db"><strong>NIK KTP</strong></small>
                                <h6><?php echo $value->nik_ktp; ?></h6> 
                                <small class="p-t-30 db"><strong>NOMOR KTA</strong></small>
                                <h6><span class="label label-success"><b><?php echo $value->no_kta_lama; ?></b></span></h6>     
                                <small class="p-t-30 db"><strong>NOMOR HANDPHONE</strong></small>
                                <h6><?php echo $value->nomor_hp; ?></h6> 
                                <small class="p-t-30 db"><strong>KETERANGAN</strong></small>
                                <h6><?php echo $value->keterangan; ?></h6>     
                                <small class="p-t-30 db"><strong>TANGGAL PENGAJUAN MUTASI</strong></small>
                                <h6><?php echo $value->tgl_pengajuan_mutasi; ?></h6>     
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">                           
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }  //ngatur nomor urut
}
?>            
<?php
if (!empty($mutasi_anggota_keluar)) {
    foreach ($mutasi_anggota_keluar as $key => $value) {
        ?> 
        <div id="edit_mutasi<?php echo $value->id_mutasi; ?>" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-danger" id="myModalLabel"><b>Edit Mutasi Anggota </b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form class="form-horizontal" action="<?php echo site_url('mutasi/edit_mutasi_anggota/' . $value->id_mutasi); ?>" enctype="multipart/form-data" method="post">
                        <div class="modal-body">                  
                            <div class="card">
                                <div class="card-body"> 
                                    <div class="form-group col-md-12 text-left">
                                        <label>Region Asal</label>
                                        <?php
                                        if ($value->kabupaten_asal != NULL) {
                                            $kab = ' - ' . strtoupper($value->kabupaten_asal);
                                        } else {
                                            $kab = '';
                                        }
                                        ?>
                                        <input type="text" class="form-control"  value=" <?php echo strtoupper($value->provinsi_asal) . $kab; ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>Region Tujuan Mutasi<span class="text-danger">*</span></label>
                                        <select name="id_region_tujuan" class="select2 form-control custom-select" style="width: 100%; height:36px;" required="" data-validation-required-message="Kolom ini wajib diisi!" id="region_anggota">                                        
                                            <option value="<?php echo $value->id_region_tujuan; ?>"selected="">
                                                <?php echo strtoupper($value->provinsi_tujuan); ?>
                                                <?php
                                                if ($value->kabupaten_tujuan != NULL) {
                                                    echo ' - ' . strtoupper($value->kabupaten_tujuan);
                                                }
                                                ?>
                                            </option>  
                                            <?php
                                            if (!empty($admin_mutasi)) {
                                                foreach ($admin_mutasi as $key => $values) {
                                                    ?>
                                                    <option value="<?php echo $values->id_ref; ?>">
                                                        <?php echo strtoupper($values->provinsi); ?>
                                                        <?php
                                                        if ($values->kabupaten != NULL) {
                                                            echo ' - ' . strtoupper($values->kabupaten);
                                                        }
                                                        ?>
                                                    </option>                                     
                                                    <?php
                                                }
                                            }
                                            ?>      
                                        </select>
                                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                                    </div>  
                                    <div class="form-group col-md-12 text-left">
                                        <label>Status Keanggotaan</label>
                                        <?php if ($value->status_pengurus == 2) { ?> 
                                            <input type="text"  class="form-control"  value="PENGURUS" readonly="">
                                        <?php } elseif ($value->status_pengurus == 1) { ?>
                                            <input type="text"  class="form-control"  value="ANGGOTA" readonly="">
                                        <?php } ?>
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>Nama Anggota</label>
                                        <input type="text" name="nama_anggota" class="form-control"  value="<?php echo strtoupper($value->nama_anggota); ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>NIK KTP</label>
                                        <input type="text" class="form-control"  value="<?php echo $value->nik_ktp; ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>Nomor KTA Lama</label>
                                        <input type="text"  class="form-control"  value="<?php echo $value->no_kta_lama; ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>Nomor Handphone</label>
                                        <input type="text"  class="form-control"  value="<?php echo $value->nomor_hp; ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 text-left">
                                        <label>Tanggal Pengajuan Mutasi</label>
                                        <input type="text"  class="form-control"  value="<?php echo $value->tgl_pengajuan_mutasi; ?>" readonly="">
                                    </div>
                                    <div class="form-group col-md-12 m-t-5 text-left">
                                        <label>Keterangan <span class="text-danger">*</span></label>
                                        <textarea name="keterangan" id="textarea" class="form-control" rows="5" placeholder="Isikan keterangan mutasi" aria-invalid="false"><?php echo $value->keterangan; ?></textarea>
                                        <small class="form-control-feedback">*Kolom <b>Tidak</b> harus Diisi! </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">  
                            <button class="btn btn-success waves-effect" >Update</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
    }  //ngatur nomor urut
}
?>      
<script type="text/javascript">
    function act_del_anggota_mutasi(object, name) {
//        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Anggota " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batal!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "post",
                    url: "<?php echo site_url("mutasi/delete_mutasi") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Anggota " + name + " telah terhapus.", "success");
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function (result) {
                        console.log(result);
                        swal("Opsss!", "No Network connection.", "error");
                    }
                });

            } else {
                swal("Dibatalkan", "Anggota " + name + " batal dihapus.", "error");
            }
        });
    }
</script>
