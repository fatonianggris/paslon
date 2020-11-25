<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Admin Kabupaten</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Admin Kabupaten</a></li>
                <li class="breadcrumb-item active">Daftar Admin Kabupaten</li>
            </ol>
            <a href="<?php echo site_url('akun/tambah_admin_kabupaten'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Admin Kabupaten</button></a>
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
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->admin_kab; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Admin Kabupaten</h5></div>
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
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->petugas_kab; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Petugas Kabupaten</h5></div>
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
                <h4 class="card-title">Daftar Admin Kabupaten</h4>
                <h6 class="card-subtitle">Daftar admin kabupaten terkait nama, foto, alamat dll</h6>
                <div class="table-responsive m-t-10">
                    <table id="tabel_admin_kab" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Hak Akses</th>
                                <th>Nama Admin</th> 
                                <th>Provinsi</th>  
                                <th>Kabupaten</th>  
                                <th>Masa Lisensi</th>
                                <th>Jml Anggota</th>   
                                <th>Jml Petugas</th>                                
                                <th>Status</th>   
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td">Hak Akses</th>
                                <th>Nama Admin</th> 
                                <th>Provinsi</th>  
                                <th>Kabupaten</th>  
                                <th>Masa Lisensi</th> 
                                <th>Jml Anggota</th>   
                                <th>Jml Petugas</th>    
                                <th>Status</th> 
                                <th class="clear-td">Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function act_del_admin_kab(object) {
        var name = $('#' + object).val();
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
                    url: "<?php echo site_url("akun/delete_admin_kabupaten") ?>",
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
<script>
    $(document).ready(function () {
        $('#tabel_admin_kab tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Filter Data" />');
        });

        $('#tabel_admin_kab').DataTable({
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
                "url": '<?php echo site_url('datatable/datatable/akun_kab_json'); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": {create: "create_prev", read: "read_prev", update: "read_prev", delete: "delete_prev"}, "render": function (data, type, row) {
                        var crud = '';
                        if (data.create_prev == 1) {
                            crud += '<span class="label label-info"><b>C</b></span>';
                        }
                        if (data.read_prev == 1) {
                            crud += '<span class="label label-info  m-l-5"><b>R</b></span>';
                        }
                        if (data.update_prev == 1) {
                            crud += '<span class="label label-info  m-l-5"><b>U</b></span>';
                        }
                        if (data.delete_prev == 1) {
                            crud += '<span class="label label-info  m-l-5"><b>D</b></span>';
                        }
                        return crud;
                    }
                },
                {"data": "nama_admin", "name": "nama_admin"},
                {"data": "provinsi", "name": "provinsi"},
                {"data": "kabupaten", "name": "kabupaten"},
                {"data": "license_exp", "render": function (data, type, row) {
                        var hasil = expiryDate(data);
                        var exp = '';
                        if (hasil > 10) {
                            exp = '<span class="label label-success"><b>' + hasil + '</b> hari lagi</span>';
                        } else if (hasil <= 10 && hasil > 0) {
                            exp = '<span class="label label-warning"><b>' + hasil + '</b> hari lagi</span>';
                        } else if (hasil <= 0) {
                            exp = '<span class="label label-danger"><b>Expired</b></span>';
                        }
                        return exp;
                    }, "name": "license_exp"},
                {"data": "jml_ktp", "render": function (data, type, row) {
                        return '<span class="label label-info">Total-> <b>' + data + ' Anggota</b></span>';
                    }, "name": "jml_ktp"},
                {"data": "jml_pet", "render": function (data, type, row) {
                        return '<span class="label label-info">Total-> <b>' + data + ' Petugas</b></span>';
                    }, "name": "jml_pet"},
                {"data": "status", "render": function (data, type, row) {
                        if (data == 1) {
                            return '<span class="label label-success"><b>AKTIF</b></span>';
                        } else {
                            return '<span class="label label-danger"><b>NON-AKTIF</b></span>';
                        }
                    }, "name": "status"},
                {"data": "view_button", "name": "id_user"}
            ],

            order: []
        });
    });

    function expiryDate(date_string) {

        var expiration = moment(date_string).format("YYYY-MM-DD");
        var current_date = moment().format("YYYY-MM-DD");
        var days = moment(expiration).diff(current_date, 'days');

        return days;
    }

</script>
