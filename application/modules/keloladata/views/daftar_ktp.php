<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Kelola Daftar Anggota</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Kelola Anggota</a></li>
                <li class="breadcrumb-item active">Kelola Daftar Anggota</li>
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
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-info">
                    <h3 class="text-white box m-b-0"><i class="ti-id-badge"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->ktp; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah ID</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-danger">
                    <h3 class="text-white box m-b-0"><i class="ti-na"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-danger"><?php echo $count[0]->ktp_duplicate; ?></h3>
                    <h5 class="text-muted m-b-0">ID Duplikat</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-inverse">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0"><?php echo $count[0]->petugas; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Petugas</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-primary">
                    <h3 class="text-white box m-b-0"><i class="ti-location-pin"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-primary"><?php echo $count[0]->regional; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Region</h5></div>
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
                <h4 class="card-title">Kelola Daftar Semua Anggota</h4>
                <h6 class="card-subtitle">Kelola Daftar Semua Anggota terkait NIK, no KTA, nama dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_ktp2" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>

                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>
                                <th>Jenis Kel.</th>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>                               
                                <th>Aksi</th>
                                <?php if ($usr['role_admin'] == 0) { ?>
                                    <th><i class="fa fa-trash"></i></th> 
                                <?php } ?>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>

                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>
                                <th>Jenis Kel.</th>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
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
</div>

<script>
    $(document).ready(function () {

        $('#tabel_ktp2 tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Filter Data" />');
        });
        var table2 = $('#tabel_ktp2').DataTable({
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
                "url": '<?php echo site_url('datatable/datatable/kelola_anggota_json'); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "view_ktp", "name": "nik_ktp"},
                {"data": "view_kta", "name": "nik_kta_baru"},
                {"data": "nama_ktp", "name": "nama_ktp"},
                {"data": "tmp_tgl_lahir", "name": "tmp_tgl_lahir"},
                {"data": "jenis_kelamin", "name": "jenis_kelamin"},
                {"data": "provinsi_asal", "name": "provinsi_asal"},
                {"data": "kabupaten_asal", "name": "kabupaten_asal"},
                {"data": "view_button", "name": "id_ktp"},
                {"data": {status_data: "status_data", id_ktp: "id_ktp"}, "render": function (data, type, row) {
                        if (data.status_data == 1) {
                            return '<a onclick="ubah_status_ktp(' + data.id_ktp + ',0);" > <button type="button" class="btn waves-effect waves-light btn-xs btn-success" data-toggle="tooltip" data-original-title="Hapus Anggota Sementara" style="margin-right: 10px;"><i class="fa fa-check"></i></button></a>';
                        } else {
                            return '<a onclick="ubah_status_ktp(' + data.id_ktp + ', 1);" > <button type="button" class="btn waves-effect waves-light btn-xs btn-danger" data-toggle="tooltip" data-original-title="Restore Anggota" s style="margin-right: 10px;"><i class="fa fa-undo"></i></button></a>';
                        }
                    }, "name": "status_data"}
            ],
            order: []
        });
    });
</script>
<script type="text/javascript">
    function ubah_status_ktp(object, stat) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin mengubah status Anggota ini " + name + " ?",
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
                    url: "<?php echo site_url("ktp/ubah_status_ktp") ?>",
                    data: {id: object, status: stat},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terupdate!", "Status Anggota " + name + " telah diubah.", "success");
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
                swal("Dibatalkan", "Status Anggota " + name + " batal diubah.", "error");
            }
        });
    }
</script>

<script type="text/javascript">
    function act_del_ktp(object) {
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
