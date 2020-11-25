<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Anggota</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Anggota</a></li>
                <li class="breadcrumb-item active">Daftar Anggota</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_pemilihan'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Buat Pemilihan</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Buat Pemilihan NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Buat Pemilihan</button>
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
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-id-badge"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->pemilihan; ?></h3>
                    <h5 class="text-muted m-b-0">Total Pemilihan</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-danger">
                    <h3 class="text-white box m-b-0"><i class="ti-na"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-danger"><?php echo $count[0]->tps; ?></h3>
                    <h5 class="text-muted m-b-0">Total TPS</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-inverse">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0"><?php echo $count[0]->saksi; ?></h3>
                    <h5 class="text-muted m-b-0">Total Petugas Saksi</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Semua Pemilihan</h4>
                <h6 class="card-subtitle">Daftar Semua Pemilihan terkait calon, periode dll</h6>

                <div class="table-responsive m-t-10">
                    <table id="tabel_pemilihan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kat. Pemilihan</th>
                                <th>Nama Pemilihan</th>
                                <th>Regional</th>
                                <th>Nama Calon </th>
                                <th>Nama Wakil Calon</th>
                                <th>Periode Pemilihan</th>  
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td">No.</th>                                   
                                <th>Kat. Pemilihan</th>
                                <th>Nama Pemilihan</th>
                                <th>Regional</th>
                                <th>Nama Calon </th>
                                <th>Nama Wakil Calon</th>
                                <th>Periode Pemilihan</th>   
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($pemilihan)) {
                                $i = 1;
                                foreach ($pemilihan as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <b>
                                                <?php if ($value->id_kategori_pemilihan == 1) { ?>
                                                    PRESIDEN
                                                <?php } else if ($value->id_kategori_pemilihan == 2) { ?>
                                                    DPR RI
                                                <?php } else if ($value->id_kategori_pemilihan == 3) { ?>
                                                    GUBERNUR
                                                <?php } else if ($value->id_kategori_pemilihan == 4) { ?>
                                                    WALIKOTA
                                                <?php } else if ($value->id_kategori_pemilihan == 5) { ?>
                                                    BUPATI
                                                <?php } else if ($value->id_kategori_pemilihan == 6) { ?>
                                                    DPRD PROVINSI
                                                <?php } else if ($value->id_kategori_pemilihan == 7) { ?>
                                                    DPRD KABUPATEN/KOTA
                                                <?php } ?>
                                            </b>
                                        </td>
                                        <td>
                                            <?php echo strtoupper($value->nama_pemilihan); ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($provinsi)) {
                                                foreach ($provinsi as $key => $values) {
                                                    if ($values->id == substr($value->id_regional_pemilihan, 0, 2)) {
                                                        ?>
                                                        <?php echo $values->nama; ?>                                    
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>     

                                            <?php
                                            if (substr($value->id_regional_pemilihan, 2, 2) != "") {
                                                if (!empty($kabupaten)) {
                                                    foreach ($kabupaten as $keys => $valuess) {
                                                        if ($valuess->id == substr($value->id_regional_pemilihan, 2, 2) && $valuess->id_dati1 == substr($value->id_regional_pemilihan, 0, 2)) {
                                                            ?>
                                                            -<?php echo $valuess->nama; ?>                                    
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>       
                                        <td>
                                            <?php echo strtoupper($value->nama_calon); ?>
                                        </td>  
                                        <td>
                                            <?php echo strtoupper($value->nama_wakil_calon); ?>
                                        </td>  
                                        <td>
                                            <?php echo strtoupper($value->tahun_pemilihan); ?>
                                        </td>
                                        <td>
                                            <?php if ($usr['delete_prev'] == 1) { ?>
                                                <a onclick="act_del_pemilihan(<?php echo $value->id_pemilihan; ?>, '<?php echo strtoupper($value->nama_pemilihan); ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Pemilihan"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Pemilihan NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <?php if ($usr['update_prev'] == 1) { ?>
                                                <a href="<?php echo site_url('pemilihan/get_pemilihan/' . $value->id_pemilihan); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit Pemilihan"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Pemilihan NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <a href="<?php echo site_url('pemilihan/dashboard_pemilihan/' . $value->id_pemilihan); ?>"><button type="button" class="btn btn-warning btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Lihat Dashboard Pemilihan"><i class="ti-eye" aria-hidden="true"></i></button></a>
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
    function act_del_pemilihan(object, name) {
        //var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Pemilihan " + name + " ?",
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
                    url: "<?php echo site_url("pemilihan/delete_pemilihan") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Pemilihan " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Pemilihan " + name + " batal dihapus.", "error");
            }
        });
    }
</script>
