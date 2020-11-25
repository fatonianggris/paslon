<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Dashboard </h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard Admin</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('ktp/tambah_ktp'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Data Anggota</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Data NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Data Anggota</button>
            <?php } ?>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<?php if ($usr['role_admin'] == 1) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h3 class="text-success"><i class="fa fa-check-circle"></i> Selamat Datang di Website "<?php echo ucwords($template[0]->nama_website); ?>"></h3> Hello!!.. "<b><?php echo strtoupper($usr['nama_admin']); ?></b>", Anda login sebagai admin <b>Provinsi </b>
        <?php
        if (!empty($prov)) {
            foreach ($prov as $key => $val) {
                if ($val->id == substr($usr['id_ref'], 0, 2)) {
                    ?>
                    <b>"<?php echo ucwords($val->nama); ?>"</b>                                   
                    <?php
                }
            }
        }
        ?>    
    </div>
<?php } elseif ($usr['role_admin'] == 2) { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h3 class="text-success"><i class="fa fa-check-circle"></i> Selamat Datang di Website "<?php echo ucwords($template[0]->nama_website); ?>"</h3> Hello!!.. "<b><?php echo strtoupper($usr['nama_admin']); ?></b>", Anda login sebagai admin <b>Kabupaten </b>
        <?php
        if (!empty($kab)) {
            foreach ($kab as $key => $val) {
                if ($val->id == substr($usr['id_ref'], 2, 2) && $val->id_dati1 == substr($usr['id_ref'], 0, 2)) {
                    ?>
                    <b>"<?php echo ucwords($val->nama); ?>"</b>                                   
                    <?php
                }
            }
        }
        ?> 
        <b>, Provinsi </b>
        <?php
        if (!empty($prov)) {
            foreach ($prov as $key => $val) {
                if ($val->id == substr($usr['id_ref'], 0, 2)) {
                    ?>
                    <b>"<?php echo ucwords($val->nama); ?>"</b>                                   
                    <?php
                }
            }
        }
        ?>    
    </div>
<?php } else { ?>
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
        <h3 class="text-success"><i class="fa fa-check-circle"></i> Selamat Datang di Website "<?php echo ucwords($template[0]->nama_website); ?>"</h3> Hello!!.. "<b><?php echo strtoupper($usr['nama_admin']); ?></b>", Anda login sebagai admin <b>Nasional </b> 
    </div>
<?php } ?>
<div class="card-group">
    <!-- card -->
    <div class="card o-income col-lg-6">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h4 class="card-title m-b-0 align-self-center">Recruitment per Petugas</h4>
                <div class="ml-auto">

                </div>
            </div>
            <div id="income" style="height:260px; width:100%;"></div>
            <ul class="list-inline m-t-30 text-center font-12">                
                <li><i class="fa fa-circle text-primary"></i> PETUGAS</li>
            </ul>
        </div>
    </div>
    <!-- card -->
    <div class="card col-lg-3">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h4 class="card-title m-b-0 align-self-center">Recruitment per Regional</h4>
                <div class="ml-auto">

                </div>
            </div>
            <div id="visitor" style="height:250px; width:100%;"></div>
            <!--            <ul class="list-inline m-t-30 text-center font-12">
            
            <?php
            if (!empty($ktp_reg)) {
                foreach ($ktp_reg as $key => $value) {
                    ?>
                                                    <li><i class="fa fa-circle "></i> <?php echo strtolower($value->nama_admin) ?> <b>(<?php echo ucwords($value->jml_ktp) ?>)</b></li>
                    <?php
                }
            }
            ?>
                        </ul>-->
        </div>
    </div>
    <!-- card -->
    <div class="card col-lg-3">
        <div class="p-20 p-t-25 ">
            <h4 class="card-title">Laporan</h4>

        </div>
        <div class="d-flex no-block p-15 align-items-center">
            <div class="round round-info"><i class="icon-user font-16"></i></div>
            <div class="m-l-10 ">
                <h3 class="m-b-0"><?php echo $laporan[0]->jml_petugas; ?> User</h3>
                <h6 class="text-muted font-light m-b-0">Total semua petugas</h6> </div>
        </div>
        <hr>
        <div class="d-flex no-block p-15 align-items-center">
            <div class="round round-primary"><i class="icon-pin font-16"></i></div>
            <div class="m-l-10">
                <h3 class="m-b-0"><?php echo $laporan[0]->jml_ktp; ?> Anggota</h3>
                <h6 class="text-muted font-light m-b-0">Total semua anggota</h6></div>
        </div>
        <hr>
        <div class="d-flex no-block p-15 m-b-15 align-items-center">
            <div class="round round-danger"><i class="icon-ban font-16"></i></div>
            <div class="m-l-10">
                <h3 class="m-b-0"><?php echo $laporan[0]->total_duplikat; ?> ID</h3>
                <h6 class="text-muted font-light m-b-0">Total ID duplikat dari <b class="text-danger"><?php echo $laporan[0]->total_ktp; ?> ID</b></h6></div>
        </div>

    </div>
</div>
<div class="card col-lg-12">
    <div class="card-body">
        <h4 class="card-title">Daftar ID Duplikat</h4>
        <h6 class="card-subtitle">Daftar ID duplikat disemua regional</h6>
        <div class="table-responsive m-t-40">
            <table id="table_dashboard" class="table table-bordered table-striped no-wrap">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama ID</th>                       
                        <th>Tempat/Tgl Lahir</th>
                        <th>Petugas</th>
                        <th>Regional</th>
                        <th>Tanggal post</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>NIK</th>
                        <th>Nama ID</th>                        
                        <th>Tempat/Tgl Lahir</th>
                        <th>Petugas</th>
                        <th>Regional</th>
                        <th>Tanggal post</th>
                        <th class="clear-td">Aksi</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    if (!empty($duplikat)) {
                        $i = 1;
                        foreach ($duplikat as $key => $value) {
                            ?> 
                            <tr>
                                <td><span class="label label-danger text-white"><b><?php echo ucwords($value->nik_ktp); ?></b></span></td>
                                <td><b><?php echo ucwords($value->nama_ktp); ?></b></td>
                                <td><?php echo ucwords($value->tempat_lahir); ?>, <?php echo ucwords($value->tanggal_lahir); ?></td>
                                <td>
                                    <?php
                                    $id = $value->id_petugas;
                                    $id_array = explode(',', $id);
                                    if (!empty($petugas)) {
                                        foreach ($petugas as $key => $values) {
                                            if (in_array($values->id_petugas, $id_array)) {
                                                ?>
                                                <span class="label label-success"><b><?php echo ucwords($values->nama_petugas); ?></b></span>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <?php if (empty($id) or $id == NULL) {
                                        ?>
                                        <span class="label label-danger"><b>Kosong</b></span>
                                    <?php } ?>
                                </td>
                                <td><b><?php echo ucwords($value->provinsi); ?></b></td>
                                <td><?php echo $value->tanggal_post; ?></td>
                                <td>
                                    <?php if ($usr['delete_prev'] == 1) { ?>
                                        <a onclick="act_del_ktp(<?php echo $value->id_ktp; ?>,'<?php echo $value->nama_ktp; ?>')"><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus ID Duplikat"><i class="ti-close" aria-hidden="true"></i></button></a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus ID NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                    <?php } ?>
                                    <?php if ($usr['update_prev'] == 1) { ?>
                                        <a href="<?php echo site_url('ktp/get_ktp/' . $value->id_ktp); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit ID Duplikat"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit ID NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                        <?php } ?>
                                </td>
                            </tr>
                            <?php
                        }  //ngatur nomor urut
                    }
                    ?>         
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    function act_del_ktp(object, name) {
        //var name = $('#' + object).val();
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
                    url: "<?php echo site_url("ktp/delete_ktp") ?>",
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
