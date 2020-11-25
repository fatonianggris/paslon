<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Semua Petugas Saksi</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Semua Petugas Saksi</a></li>
                <li class="breadcrumb-item active">Daftar Petugas Saksi</li>
            </ol>         
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_petugas_saksi/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Saksi </button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Saksi NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Saksi </button>
            <?php } ?>
            <a href="<?php echo site_url('pemilihan/daftar_pemilihan/'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Pemilihan</button></a> 
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
            <div class="tab-content">
                <!--second tab-->
                <div class="tab-pane active" id="profile" role="tabpanel">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Pemilihan</strong>
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
                            <div class="col-md-3 col-xs-6 b-r"> <strong>Periode</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->tahun_pemilihan); ?></p>
                            </div>
                            <div class="col-md-6 col-xs-6 b-r"> <strong>Nama Calon</strong>
                                <br>
                                <p class="text-muted"><?php echo strtoupper($pemilihan[0]->nama_calon); ?>/<?php echo strtoupper($pemilihan[0]->nama_wakil_calon); ?></p>
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
                <h4 class="card-title">Daftar Semua Petugas Saksi</h4>
                <h6 class="card-subtitle">Daftar Semua Petugas Saksi terkait Nama, No HP, Email dll</h6>   

                <form class="pull-right" id="frm-pdf" target="_blank" action="<?php echo site_url('laporan/laporanpemilihan/cetak_kartu_mandat_all/' . $pemilihan[0]->id_pemilihan); ?>" method="POST">  
                    <input type="text" id="id_check_pdf" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-file-text"></i> Cetak Kartu Mandat.pdf</button>
                    </div>
                </form>     

                <form class="pull-right" id="frm-csv" target="_blank" action="<?php echo site_url('laporan/laporanpemilihan/export_all_saksi_csv/' . $pemilihan[0]->id_pemilihan); ?>" method="POST">  
                    <input type="text" id="id_check_csv" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-warning pull-right" style="margin-right: 10px;"><i class="fa fa-compress"></i> Export Data.csv</button>
                    </div>
                </form>
                <div class="table-responsive m-t-5">
                    <table id="tabel_petugas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>          
                                <th style="width: 40px;"></th>
                                <th>Nama Petugas</th>  
                                <th>No KTP</th>  
                                <th>No HP</th> 
                                <th>Email Petugas</th>                                    
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>        
                                <th class="clear-td"></th> 
                                <th>Nama Petugas Saksi</th>  
                                <th>No KTP</th>  
                                <th>No HP</th> 
                                <th>Email Petugas</th>                                                                                      
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

        $('#tabel_petugas tfoot th').each(function () {
            $(this).html('<input type="text" placeholder="Filter Data" />');
        });

        var table2 = $('#tabel_petugas').DataTable({
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
                "url": "<?php echo site_url('datatable/datatable/daftar_saksi/' . $pemilihan[0]->id_pemilihan); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "id_saksi", "name": "id_saksi"},
                {"data": "nama_saksi", "name": "nama_saksi"},
                {"data": "nomor_ktp_saksi", "name": "nomor_ktp_saksi"},
                {"data": "nomor_hp_saksi", "name": "nomor_hp_saksi"},
                {"data": "email_saksi", "name": "email_saksi"},
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

        $('#frm-pdf').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_pdf').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });

        $('#frm-csv').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_csv').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });
    });
</script>
<script type="text/javascript">
    function act_del_saksi(object) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Petugas Saksi " + name + " ?",
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
                    url: "<?php echo site_url("pemilihan/delete_petugas_saksi") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Petugas Saksi " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Petugas Saksi " + name + " batal dihapus.", "error");
            }
        });
    }
</script>



