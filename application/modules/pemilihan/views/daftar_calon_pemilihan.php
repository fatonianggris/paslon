<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Calon Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Calon Pemilihan</a></li>
                <li class="breadcrumb-item active">Daftar Calon Pemilihan</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_calon_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Calon </button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Calon NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Calon </button>
            <?php } ?>

            <a href="<?php echo site_url('pemilihan/daftar_pemilihan'); ?>" <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Pemilihan</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-inverse">
                    <h3 class="text-white box m-b-0"><i class="ti-home"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0"><?php echo $count[0]->tps; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah TPS</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-primary">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-primary"><?php echo $count[0]->saksi; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Petugas</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<div class="row">
    <div class="col-lg-12 col-xlg-12 col-md-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="tab-content a">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-xs-6 b-r"> <strong>Pemilihan</strong>
                                <br>
                                <p class="text-muted">
                                    <?php if ($pemilihan[0]->id_kategori_pemilihan == 1) { ?>
                                        PRESIDEN
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 2) { ?>
                                        DPR RI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 3) { ?>
                                        GURBERNUR
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 4) { ?>
                                        WALIKOTA
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 5) { ?>
                                        BUPATI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 6) { ?>
                                        DPRD PROVINSI
                                    <?php } else if ($pemilihan[0]->id_kategori_pemilihan == 7) { ?>
                                        DPRD KABUPATEN/KOTA
                                    <?php } ?>
                                </p>
                            </div>
                            <div class="col-md-2 col-xs-6 b-r"> <strong>Periode</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->tahun_pemilihan); ?></p>
                            </div>
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Nama Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_calon); ?></p>
                            </div>
                            <div class="col-md-5 col-xs-6"> <strong>Nama Wakil Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_wakil_calon); ?></p>
                            </div>           
                        </div>                                          
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Calon Pemilihan</h4>
                <h6 class="card-subtitle">Daftar Calon Pemilihan terkait Nama, Nomor Urut dll</h6>              
                <div class="table-responsive m-t-5">
                    <table id="tabel_calon_pemilihan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>                                                      
                                <th>Nomor Urut</th>  
                                <th>Nama Kandidat Calon</th> 
                                <th>Total Suara</th>                                
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($calon_pemilihan)) {
                                $i = 1;
                                foreach ($calon_pemilihan as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <b class="text-success">
                                                    <?php echo $value->nomor_urut; ?>
                                                </b>
                                            <?php } else { ?>
                                                <?php echo $value->nomor_urut; ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <b class="text-success">
                                                    <?php echo strtoupper($value->nama_calon); ?>/<?php echo strtoupper($value->nama_wakil_calon); ?>
                                                </b>
                                            <?php } else { ?>
                                                <?php echo strtoupper($value->nama_calon); ?>/<?php echo strtoupper($value->nama_wakil_calon); ?>
                                            <?php } ?>
                                        </td>       
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <span class="label label-success">Total-> <b><?php echo $value->total_suara; ?> Suara</b></span>
                                            <?php } else { ?>
                                                <span class="label label-info">Total-> <b><?php echo $value->total_suara; ?> Suara</b></span> 
                                            <?php } ?>
                                        </td> 
                                        <td>
                                            <?php if ($i != 1) { ?>
                                                <?php if ($usr['delete_prev'] == 1) { ?>
                                                    <a onclick="act_del_calon_pemilihan(<?php echo $value->id_calon_pemilihan; ?>, '<?php echo strtoupper($value->nama_calon); ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Pemilihan"><i class="ti-close" aria-hidden="true"></i></button></a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Pemilihan NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                                <?php } ?>
                                                <?php if ($usr['update_prev'] == 1) { ?>
                                                    <a href="<?php echo site_url('pemilihan/get_calon_pemilihan/' . $value->id_calon_pemilihan . '/' . $value->id_pemilihan); ?>"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit Pemilihan"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Pemilihan NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
                                                    <?php } ?>
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
    function act_del_calon_pemilihan(object, name) {
        //var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Calon " + name + " ?",
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
                    url: "<?php echo site_url("pemilihan/delete_calon_pemilihan") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Calon " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Calon " + name + " batal dihapus.", "error");
            }
        });
    }
</script>



