<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Kelola Daftar Petugas</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Petugas</a></li>
                <li class="breadcrumb-item active">Kelola Daftar Petugas</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('petugas/tambah_petugas'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Petugas Recruitment Baru</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Petugas Recruitment NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Petugas Recruitment Baru</button>           
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
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->petugas; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Petugas</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-map-alt"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->regional; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Regional</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Kelola Daftar Petugas</h4>
                <h6 class="card-subtitle">Kelola Daftar petugas terkait nama, status, alamat dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_petugas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Regional Petugas</th>
                                <th>Nama Petugas</th> 
                                <th>Email</th> 
                                <th>No. KTP</th> 
                                <th>Jumlah KTP</th> 
                                <th>Kode</th>   
                                <th>No. HP</th>  
                                <th>Aksi</th>
                                <?php if ($usr['role_admin'] == 0) { ?>
                                    <th><i class="fa fa-trash"></i></th> 
                                <?php } ?>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Regional Petugas</th>
                                <th>Nama Petugas</th>
                                <th>Email</th> 
                                <th>No. KTP</th>  
                                <th class="clear-td">Jumlah KTP</th> 
                                <th>Kode</th>   
                                <th>No. HP</th>  
                                <th class="clear-td">Aksi</th>
                                <?php if ($usr['role_admin'] == 0) { ?>
                                    <th class="clear-td"><i class="fa fa-trash"></i></th> 
                                <?php } ?>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="peringatan_produk" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="myModalLabel"><b>Perhatian !</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">                  
                    <div class="card text-center">
                        <div class="card-body">
                            <h4 class="card-title text-danger">HARAP HATI-HATI KETIKA MENGHAPUS DATA PETUGAS !!!</h4>
                            <p class="card-text">Diharapkan berhati-hati ketika <b>MENGHAPUS</b> data Petugas dikarenakan semua data Anggota & Regional yang terhubung dengan Petugas tersebut akan terhapus. Disarankan untuk <b>MENGGANTI</b> Petugas Regional Anggota terlebih dahulu sebelum menghapus data Petugas.</p>
                            <p class="card-text"><b> Terima Kasih... </b></p>
                            <a href="" class="btn btn-info" data-dismiss="modal">TUTUP</a>      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#tabel_petugas tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Filter Data" />');
        });

        $('#tabel_petugas').DataTable({
            initComplete: function () {
                // Apply the search
                this.api().columns().every(function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value)
                                    .draw();
                        }
                    });
                });
            },
            "searchable": true,
            "processing": true,
            //"serverSide": true,
            "ajax": {
                "url": '<?php echo site_url('datatable/datatable/kelola_petugas_json'); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "view_regional_petugas", "name": "regional_petugas"},
                {"data": "view_nama_petugas", "name": "nama_petugas"},
                {"data": "email_petugas", "name": "email_petugas"},
                {"data": "nomor_ktp", "name": "nomor_ktp"},
                {"data": "jml_ktp", "render": function (data, type, row) {
                        return '<span class="label label-info">Total-> <b>' + data + ' Anggota</b></span>';
                    }, "name": "jml_ktp"},
                {"data": "view_kode_petugas", "name": "kode_petugas"},
                {"data": "nomor_hp", "name": "nomor_hp"},
                {"data": "view_button", "name": "view_button"},
                {"data": {status_data: "status_data", id_petugas: "id_petugas"}, "render": function (data, type, row) {
                        if (data.status_data == 1) {
                            return '<a onclick="ubah_status_pet(' + data.id_petugas + ',0);" > <button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="tooltip" data-original-title="Hapus Anggota Sementara" style="margin-right: 10px;"><i class="fa fa-check"></i></button></a>';
                        } else {
                            return '<a onclick="ubah_status_pet(' + data.id_petugas + ', 1);" > <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-toggle="tooltip" data-original-title="Restore Anggota" s style="margin-right: 10px;"><i class="fa fa-undo"></i></button></a>';
                        }
                    }, "name": "id_petugas"}
            ],
            order: []
        });
    });

</script>

<script type="text/javascript">
    function act_del_petugas(object) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus anggota " + name + " ?",
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
                    url: "<?php echo site_url("petugas/delete_petugas") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Petugas " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Petugas " + name + " batal dihapus.", "error");
            }
        });
    }
</script>

<script type="text/javascript">
    function ubah_status_pet(object, stat) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin mengubah status Petugas ini " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, ubah!",
            cancelButtonText: "Tidak, batal!",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function (isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "post",
                    url: "<?php echo site_url("petugas/ubah_status_pet") ?>",
                    data: {id: object, status: stat},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terupdate!", "Status Petugas " + name + " telah diubah.", "success");
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
                swal("Dibatalkan", "Status Petugas " + name + " batal diubah.", "error");
            }
        });
    }
</script>