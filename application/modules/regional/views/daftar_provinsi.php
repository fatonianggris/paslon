<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Regional Provinsi</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Provinsi</a></li>
                <li class="breadcrumb-item active">Daftar Regional Provinsi</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('regional/tambah_provinsi'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Regional Provinsi</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Regional Provinsi NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Regional Provinsi</button>           
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
                <h4 class="card-title">Daftar Regional Provinsi</h4>
                <h6 class="card-subtitle">Daftar regional provinsi terkait code, wilayah, nama dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_regional" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th> 
                                <th>Nama Provinsi</th>
                                <th>Akronim</th>
                                <th>Jml. Penduduk</th>
                                <th>Luas</th>
                                <th>Tanggal Post</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td">No.</th>
                                <th>Kode</th> 
                                <th>Nama Provinsi</th>
                                <th>Akronim</th>
                                <th>Jml. Penduduk</th>
                                <th>Luas</th>
                                <th>Tanggal Post</th>
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($daftar_provinsi)) {
                                $i = 1;
                                foreach ($daftar_provinsi as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <span class="label label-info"><b><?php echo strtoupper($value->code); ?></b></b></span>
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
                                                <a onclick="act_del_provinsi(<?php echo $value->id; ?>, '<?php echo strtoupper($value->nama); ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Provinsi"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Provinsi NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <?php if ($usr['update_prev'] == 1) { ?>
                                                <a href="<?php echo site_url('regional/get_provinsi_form/' . $value->id); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit Provinsi"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Provinsi NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <a href="<?php echo site_url('regional/daftar_kabupaten/' . $value->id); ?>"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Lihat Provinsi"><i class="ti-eye" aria-hidden="true"></i></button></a>
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
    function act_del_provinsi(id, name) {
        //var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Provinsi " + name + " ?",
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
                    url: "<?php echo site_url("regional/delete_provinsi") ?>",
                    data: {id: id},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Provinsi " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Provinsi " + name + " batal dihapus.", "error");
            }
        });
    }
</script>
