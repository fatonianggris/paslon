<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Pekerjaan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Pekerjaan</a></li>
                <li class="breadcrumb-item active">Daftar Pekerjaan Anggota</li>
            </ol>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="ol-lg-4 col-md-4">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-briefcase"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->pekerjaan; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Pekerjaan</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4 col-md-4">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->anggota; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Anggota</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="ol-lg-4 col-md-4">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-warning">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-warning"><?php echo $count[0]->regional_admin; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Regioanal Admin</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Row -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-12 col-md-12">
        <?php echo $this->session->flashdata('flash_message'); ?>
    </div>
    <!-- Column -->
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pekerjaan</h4>
                <h6 class="card-subtitle">Daftar pekerjaan terkait jenis pekerjaan dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_regional" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pekerjaan</th> 
                                <th>Tanggal Post</th>                                
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td">No.</th>
                                <th>Jenis Pekerjaan</th> 
                                <th>Tanggal Post</th>                         
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (!empty($pekerjaan)) {
                                $i = 1;
                                foreach ($pekerjaan as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>

                                        <td>
                                            <b><?php echo strtoupper($value->job); ?></b>
                                        </td>

                                        <td>
                                            <?php echo ucwords($value->tgl_post); ?>
                                        </td>                                       
                                        <td>
                                            <?php if ($usr['delete_prev'] == 1) { ?>
                                                <a onclick="act_del_pekerjaan(<?php echo $value->id; ?>, '<?php echo strtoupper($value->job); ?>')" ><button type="button" class="btn btn-danger btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Hapus Provinsi"><i class="ti-close" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Hapus Provinsi NonAktif (*hub petugas)"><i class="ti-close" aria-hidden="true"></i></button>
                                            <?php } ?>
                                            <?php if ($usr['update_prev'] == 1) { ?>
                                                <a data-target="#pekerjaan<?php echo $value->id ?>" data-toggle="modal"><button type="button" class="btn btn-info btn-sm btn-icon btn-pure btn-outline delete-row-btn " data-toggle="tooltip" data-original-title="Edit Provinsi"><i class="ti-pencil" aria-hidden="true"></i></button></a>
                                            <?php } else { ?>
                                                <button type="button" class="btn btn-default btn-sm btn-icon btn-pure btn-outline delete-row-btn" readonly data-toggle="tooltip" data-original-title="Edit Provinsi NonAktif (*hub petugas)"><i class="ti-pencil" aria-hidden="true"></i></button>
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
    <div class="col-6">
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Formulir Tambah Pekrjaan</h4>
                <h6 class="card-subtitle"> Silahkan mengisi formulir tambah pekerjaan yang sesuai </h6>
                <form class="form-horizontal m-t-20 row" action="<?php echo site_url('pekerjaan/kirim_pekerjaan'); ?>" enctype="multipart/form-data" method="post" novalidate>          
                    <div class="form-group col-md-12 m-t-10" >
                        <label>Jenis Pekerjaan Anggota <span class="text-danger">*</span></label>
                        <fieldset class="controls">
                            <input type="text" name="job" class="form-control" placeholder="Isikan nama pekerjaan " required data-validation-required-message="Kolom ini wajib diisi">
                        </fieldset>
                    </div>
                    <div class="form-group col-12 m-t-10">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <button type="reset" onclick="history.back()" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($pekerjaan)) {
    foreach ($pekerjaan as $key => $value) {
        ?> 
        <div id="pekerjaan<?php echo $value->id ?>" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-danger" id="myModalLabel"><b>Pekerjaan Anggota </b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form class="form-horizontal" action="<?php echo site_url('pekerjaan/edit_pekerjaan/' . $value->id); ?>" enctype="multipart/form-data" method="post">
                        <div class="modal-body">                  
                            <div class="card text-center">
                                <div class="card-body">                               
                                    <div class="form-group col-md-12 text-left">
                                        <label>Jenis Pekerjaan Anggota<span class="text-danger">*</span></label>
                                        <fieldset class="controls">
                                            <div class="input-group">                            
                                                <input type="text" value="<?php echo $value->job; ?>" name="job" class="form-control" placeholder="Isikan Nama Pekerjaan" required  data-validation-required-message="Kolom ini wajib diisi!">
                                            </div>
                                        </fieldset>
                                        <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                                    </div>                                                                                                
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success waves-effect" >Kirim</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
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
    function act_del_pekerjaan(object, name) {
        //var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Pekerjaan " + name + " ?",
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
                    url: "<?php echo site_url("pekerjaan/delete_pekerjaan") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Pekerjaan " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Pekerjaan " + name + " batal dihapus.", "error");
            }
        });
    }
</script>
