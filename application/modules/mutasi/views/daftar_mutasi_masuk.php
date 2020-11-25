<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Mutasi Anggota Masuk</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Mutasi Anggota</a></li>
                <li class="breadcrumb-item active">Daftar Mutasi Anggota Masuk</li>
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
                <h4 class="card-title">Daftar Mutasi Anggota Masuk</h4>
                <h6 class="card-subtitle">Daftar mutasi anggota masuk terkait nama, status, regional asal dll</h6>
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
                            if (!empty($mutasi_anggota_masuk)) {
                                $i = 1;
                                foreach ($mutasi_anggota_masuk as $key => $value) {
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
                                            <td><span class="label label-warning"><b>PENGAJUAN</b></span></td>
                                        <?php } elseif ($value->status_mutasi == 2) { ?>
                                            <td><span class="label label-success"><b>DIKONFIRMASI</b></span></td>
                                        <?php } elseif ($value->status_mutasi == 3) { ?>
                                            <td><span class="label label-danger"><b>DITOLAK</b></span></td>
                                            <?php
                                        }
                                        ?>                                      
                                        <td>
                                            <?php if ($usr['update_prev'] == 1 or $usr['create_prev'] == 1) { ?>
                                                <?php if ($value->status_mutasi == 1) { ?>
                                                    <a onclick="act_konfirmasi_anggota_mutasi(<?php echo $value->id_mutasi; ?>, '<?php echo $value->nama_anggota; ?>')" ><button type="button" class="btn btn-success btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Konfirmasi Mutasi"><i class="ti-check" aria-hidden="true"></i></button></a>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Konfirmasi Mutasi NonAktif (*hub petugas)"><i class="ti-check" aria-hidden="true"></i></button>
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
if (!empty($mutasi_anggota_masuk)) {
    foreach ($mutasi_anggota_masuk as $key => $value) {
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
                                <small class="p-t-30 db"><strong>NOMOR KTA LAMA</strong></small>
                                <h6><span class="label label-warning"><b><?php echo $value->no_kta_lama; ?></b></span></h6> 
                                <small class="p-t-30 db"><strong>NOMOR KTA BARU</strong></small>
                                <h6><span class="label label-success"><b><?php echo $value->no_kta_baru; ?></b></span></h6>
                                <small class="p-t-30 db"><strong>NOMOR HANDPHONE</strong></small>
                                <h6><?php echo $value->nomor_hp; ?></h6> 
                                <small class="p-t-30 db"><strong>KETERANGAN</strong></small>
                                <h6><?php echo $value->keterangan; ?></h6>     
                                <small class="p-t-30 db"><strong>TANGGAL PENGAJUAN MUTASI</strong></small>
                                <h6><?php echo $value->tgl_pengajuan_mutasi; ?></h6> 
                                <small class="p-t-30 db"><strong>TANGGAL KONFIRMASI MUTASI</strong></small>
                                <h6><?php echo $value->tgl_konfirmasi_mutasi; ?></h6> 
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

<script type="text/javascript">
    function act_konfirmasi_anggota_mutasi(object, name) {
//        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin mengkonfirmasi Anggota " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, konfirmasi!",
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
                        swal("Terkonfirmasi!", "Konfirmasi Anggota " + name + " telah dikonfirmasi.", "success");
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
                swal("Dibatalkan", "Konfirmasi Anggota " + name + " dibatalkan.", "error");
            }
        });
    }
</script>