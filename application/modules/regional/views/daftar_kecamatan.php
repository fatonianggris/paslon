<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Regional Kecamatan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Kecamatan</a></li>
                <li class="breadcrumb-item active">Daftar Regional Kecamatan</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('regional/tambah_kecamatan'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Regional Kecamatan</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Regional Kecamatan NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Regional Kecamatan</button>           
            <?php } ?>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-3">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->provinsi; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Provinsi</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-3">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->kabupaten; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Kabupaten</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-3">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-warning">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-warning"><?php echo $count[0]->kecamatan; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Kecamatan</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-3">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-danger">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-danger"><?php echo $count[0]->kelurahan; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Kelurahan</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Regional Kecamatan "PROVINSI <?php echo $get_nama_prov[0]->nama ?> - KABUPATEN <?php echo $get_nama_kab[0]->nama ?>"</h4>
                <h6 class="card-subtitle">Daftar regional kecamatan terkait code, wilayah, nama dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_regional" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kecamatan</th>
                                <th>Akronim</th>
                                <th>Jml. Penduduk</th>
                                <th>Luas</th>
                                <th>Tanggal Post</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kecamatan</th>
                                <th>Akronim</th>
                                <th>Jml. Penduduk</th>
                                <th>Luas</th>
                                <th>Tanggal Post</th>
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($daftar_kecamatan)) {
                                $i = 1;
                                foreach ($daftar_kecamatan as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>

                                        <td>
                                            <b><?php echo strtoupper($value->nama); ?></b>
                                        </td>
                                        <td>
                                            <?php echo ucwords($value->akronim); ?>
                                        </td> 
                                        <td> 
                                            <?php echo ucwords($value->jml_penduduk); ?>
                                        </td> 

                                        <td>
                                            <?php echo ucwords($value->luas); ?>
                                        </td> 

                                        <td>
                                            <?php echo ucwords($value->tanggal_post); ?>
                                        </td>                                       
                                        <td>
                                            <?php if ($usr['delete_prev'] == 1) { ?>
                                                <a onclick="act_del_kecamatan(<?php echo $value->id; ?>,<?php echo $value->id_dati1; ?>,<?php echo $value->id_dati2; ?>, '<?php echo strtoupper($value->nama); ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Kecamatan"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Kecamatan NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <?php if ($usr['update_prev'] == 1) { ?>
                                                <a href="<?php echo site_url('regional/get_kecamatan_form/' . $value->id . "/" . $value->id_dati1 . "/" . $value->id_dati2); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit Kecamatan"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Kecamatan NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <a href="<?php echo site_url('regional/daftar_kelurahan_desa/' . $value->id_dati1 . "/" . $value->id_dati2 . "/" . $value->id); ?>"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Lihat Kecamatan"><i class="ti-eye" aria-hidden="true"></i></button></a>

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
    function act_del_kecamatan(id, id_dati1, id_dati2, name) {
        //var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Kecamatan " + name + " ?",
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
                    url: "<?php echo site_url("regional/delete_kecamatan") ?>",
                    data: {id: id, id_dati1: id_dati1, id_dati2: id_dati2},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Kecamatan " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Kecamatan " + name + " batal dihapus.", "error");
            }
        });
    }
</script>