<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar TPS & Petugas</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">TPS & Petugas</a></li>
                <li class="breadcrumb-item active">Daftar TPS & Petugas</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_tps/' . $pemilihan[0]->id_pemilihan . '/' . $nama_wilayah[0]->id_wilayah); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah TPS </button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah TPS NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah TPS </button>
            <?php } ?>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_petugas_saksi/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Saksi </button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Saksi NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Saksi </button>
            <?php } ?>
            <a href="<?php echo site_url('pemilihan/daftar_region_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Regional</button></a> 
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
                            <div class="col-md-5 col-xs-6"> <strong>Provinsi/Kabupaten/Kecamatan/Kelurahan</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($nama_wilayah[0]->provinsi); ?>/<?php echo strtoupper($nama_wilayah[0]->kabupaten); ?>/<?php echo strtoupper($nama_wilayah[0]->kecamatan); ?>/<?php echo strtoupper($nama_wilayah[0]->kelurahan); ?></p>
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
                <h4 class="card-title">Daftar TPS</h4>
                <h6 class="card-subtitle">Daftar TPS terkait Nama, Wiliyah dll</h6>               
                <div class="table-responsive m-t-5">
                    <table id="tabel_tps" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>                               
                                <th>Nama TPS</th>  
                                <th>Nomor TPS</th>  
                                <th>Petugas</th> 
                                <th>Status Form C1</th>
                                <th>Jumlah Saksi</th> 
                                <th>Total Suara</th> 
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td"></th>                                   
                                <th>Nama TPS</th>      
                                <th>Nomor TPS</th>  
                                <th>Petugas</th>
                                <th>Status Form C1</th>
                                <th>Jumlah Saksi</th>   
                                <th>Total Suara</th>
                                <th class="clear-td">Aksi</th>
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

        function getJSON(url) {
            var resp;
            var xmlHttp;
            resp = '';
            xmlHttp = new XMLHttpRequest();

            if (xmlHttp != null)
            {
                xmlHttp.open("GET", url, false);
                xmlHttp.send(null);
                resp = xmlHttp.responseText;
            }

            return resp;
        }

        var json_pet = getJSON('<?php echo site_url('pemilihan/get_ajax_petugas_saksi'); ?>');

        function get_pet(data, type, row) {
            var text = '';
            var duce = jQuery.parseJSON(json_pet);
            var explode = data.split(",");
            for (i = 0; i < duce.length; i++) {
                if (explode.includes(duce[i].id_saksi)) {
                    text += '<span class="label label-info m-l-5"><b>' + duce[i].nama_saksi + ' [' + duce[i].nomor_ktp_saksi + ']</b></span>';
                }
            }
            return text;
        }

        $('#tabel_tps tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Filter Data" />');
        });

        var table2 = $('#tabel_tps').DataTable({
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
                "url": "<?php echo site_url('datatable/datatable/daftar_tps/' . $pemilihan[0]->id_pemilihan . '/' . $nama_wilayah[0]->id_wilayah); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "id_tps", "name": "id_tps"},
                {"data": "nama_tps", "name": "nama_tps"},
                {"data": "nomor_tps", "name": "nomor_tps"},
                {"data": "id_petugas_saksi", "render": get_pet, "name": "id_petugas_saksi"},
                {"data": "status_formulir_c1", "render": function (data, type, row) {
                        if (data == 1) {
                            return '<span class="label label-success"><b>TELAH DI SUBMIT</b></span>';
                        } else {
                            return '<span class="label label-warning"><b>BELUM DI SUBMIT</b></span>';
                        }
                    }, "name": "id_petugas_saksi"},
                {"data": "id_petugas_saksi", "render": function (data, type, row) {
                        return '<span class="label label-success">Total-> <b>' + (data.match(/\d+/g) || []).length + ' Petugas</b></span>';
                    }, "name": "id_petugas_saksi"},
                {"data": "total_suara", "render": function (data, type, row) {
                        var val = 0;
                        if (data == null) {
                            val = 0
                        } else {
                            val = data
                        }
                        return '<span class="label label-info">Total-> <b>' + val + ' Suara</b></span>';
                    }, "name": "total_suara"},
                {"data": "view_button", "name": "id_tps"}

            ],
            'columnDefs': [
                {
                    orderable: false,
                    targets: 0,
                    checkboxes: {
                        'selectRow': false
                    }
                }
            ],
            order: []
        });

    });
</script>
<script type="text/javascript">
    function act_del_tps(object) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus " + name + " ?",
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
                    url: "<?php echo site_url("pemilihan/delete_tps") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "" + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "" + name + " batal dihapus.", "error");
            }
        });
    }
</script>
