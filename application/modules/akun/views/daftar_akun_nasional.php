<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Admin Nasional</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin Nasional</a></li>
                <li class="breadcrumb-item active">Daftar Admin Nasional</li>
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
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->all_admin; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Semua Admin</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->superadmin; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Admin Nasional</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-warning">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->admin_kab; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Admin Kabupaten</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-danger">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->admin_prov; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Admin Provinsi</h5></div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Admin Nasional</h4>
                <h6 class="card-subtitle">Daftar admin nasional terkait nama, foto, alamat dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_admin_nas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Admin Nasional</th>                               
                                <th>Email</th>                                
                                <th>Status</th>  
                                <th>Masa Lisensi</th>  
                                <th>No. HP</th>  
                                <th>Jml Anggota</th>   
                                <th>Jml Petugas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td">No.</th>
                                <th>Nama Admin Nasional</th>                               
                                <th>Email</th>                                
                                <th>Status</th>  
                                <th>Masa Lisensi</th>  
                                <th>No. HP</th>  
                                <th>Jml Anggota</th>   
                                <th>Jml Petugas</th>
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($admin_nas)) {
                                $i = 1;
                                foreach ($admin_nas as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->nama_admin); ?></td>
                                        <td><?php echo $value->email; ?></td>
                                        <?php if ($value->status == 1) { ?> 
                                            <td><span class="label label-success"><b>AKTIF</b></span></td>
                                        <?php } elseif ($value->status == 0) { ?>
                                            <td><span class="label label-warning"><b>TIDAK AKTIF</b></span></td>
                                            <?php
                                        }
                                        ?>
                                        <td>
                                            <?php if ($value->license_exp == NULL or $value->license_exp == '') { ?>
                                                <span class="label label-info">
                                                    <b>Kosong</b>
                                                </span>
                                            <?php } else { ?>
                                                <?php
                                                date_default_timezone_set("Asia/Jakarta");
                                                $date = DateTime::createFromFormat('d/m/Y', $value->license_exp);
                                                $newdate = $date->format('Y-m-d');
                                                $from = strtotime($newdate);
                                                $today = time();
                                                $difference = $from - $today;
                                                $hasil = floor($difference / 86400) + 1;
                                                if ($hasil > 10) {
                                                    ?>
                                                    <span class="label label-success">
                                                        <b><?php echo $hasil; ?></b> hari lagi
                                                    </span>
                                                <?php } elseif ($hasil <= 10 && $hasil > 0) { ?>
                                                    <span class="label label-warning">
                                                        <b><?php echo $hasil; ?></b> hari lagi
                                                    </span>
                                                <?php } elseif ($hasil <= 0) { ?>
                                                    <span class="label label-danger">
                                                        <b>Expired</b>
                                                    </span>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>   
                                        <td><?php echo $value->nomor_hp; ?></td>  
                                        <td><span class="label label-info">Total-> <b><?php echo $value->jml_ktp; ?> Anggota</b></span></td>
                                        <td><span class="label label-info">Total-> <b><?php echo $value->jml_pet; ?> Petugas</b></td>
                                        <td>
                                            <a onclick="act_del_admin_nas(<?php echo $value->id_user; ?>, '<?php echo $value->nama_admin; ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Admin Nasional"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <a href="<?php echo site_url('akun/get_admin_nasional/' . $value->id_user); ?>" ><button type="button" data-toggle="tooltip" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-original-title="Edit Admin Nasional"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                            <a href="<?php echo site_url('ktp/lihat_ktp_admin/' . $value->id_ref); ?>" ><button type="button" data-toggle="tooltip" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-original-title="Lihat Anggota Admin Nasional"><i class="ti-eye" aria-hidden="true"></i></button></a>
                                            <?php if ($usr['create_prev'] == 1) { ?>
                                                <a href="<?php echo site_url('ktp/tambah_ktp_admin/' . $value->id_ref); ?>"><button type="button" class="btn btn-success btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Tambah KTP Admin"><i class="ti-plus" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Tambah KTP Admin NonAktif (*hub petugas)"><i class="ti-plus" aria-hidden="true"></i></button>
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
<script type="text/javascript">
    function act_del_admin_nas(object, name) {
//        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Admin " + name + " ?",
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
                    url: "<?php echo site_url("akun/delete_admin_nasional") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Admin " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Admin " + name + " batal dihapus.", "error");
            }
        });
    }
</script>