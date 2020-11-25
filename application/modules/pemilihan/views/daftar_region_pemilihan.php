<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar Regional Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Regional Pemilihan</a></li>
                <li class="breadcrumb-item active">Daftar Regional Pemilihan</li>
            </ol>
            <a href="<?php echo site_url('pemilihan/daftar_pemilihan'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Pemilihan</button></a> 
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
                <div class="p-10 bg-success">
                    <h3 class="text-white box m-b-0"><i class="ti-book"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-success"><?php echo $count[0]->tps; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah TPS</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-warning">
                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-warning"><?php echo $count[0]->saksi; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Petugas/Saksi</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<div class="row">
    <div class="col-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Regional Pemilihan</h4>
                <h6 class="card-subtitle">Daftar regional pemilihan terkait provinsi, kabupaten, kecamatan dll</h6>
                <form class="pull-right" id="frm-pdf" target="_blank" action="<?php echo site_url('laporan/laporanpemilihan/cetak_tps_all/' . $pemilihan[0]->id_pemilihan); ?>" method="POST">  
                    <input type="text" id="id_check_pdf" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-file-text"></i> Cetak Laporan.pdf</button>
                    </div>
                </form>     
                <form class="pull-right" id="frm-csv" target="_blank" action="<?php echo site_url('laporan/laporanpemilihan/export_all_tps_csv/' . $pemilihan[0]->id_pemilihan); ?>" method="POST">  
                    <input type="text" id="id_check_csv" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-warning pull-right" style="margin-right: 10px;"><i class="fa fa-compress"></i> Export Data.csv</button>
                    </div>
                </form>                   
                <form class="pull-right" id="frm-zip" target="_blank" action="<?php echo site_url('laporan/laporanpemilihan/zip_data_tps/' . $pemilihan[0]->id_pemilihan); ?>" method="POST">  
                    <input type="text" id="id_check_zip" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-warning pull-right" style="margin-right: 10px;"><i class="fa fa-compress"></i> Arsipkan Data.zip</button> 
                    </div>
                </form>
                <div class="table-responsive m-t-10">
                    <table id="tabel_regional_pemilihan" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan/Desa</th>
                                <th>Jumlah TPS</th>
                                <th>Jumlah Petugas</th>  
                                <th>Total Suara</th>  
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td"></th>                                   
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Kecamatan</th>
                                <th>Kelurahan/Desa</th>
                                <th>Jumlah TPS</th>
                                <th>Jumlah Petugas</th> 
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

        $('#tabel_regional_pemilihan tfoot th').each(function () {

            $(this).html('<input type="text" placeholder="Filter Data" />');
        });

        var table2 = $('#tabel_regional_pemilihan').DataTable({
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
                "url": '<?php echo site_url('datatable/datatable/wilayah_pemilihan/' . $pemilihan[0]->id_pemilihan . '/' . $pemilihan[0]->id_kategori_pemilihan . '/' . $pemilihan[0]->id_regional_pemilihan); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "id_wilayah", "name": "id_wilayah"},
                {"data": "provinsi", "name": "provinsi"},
                {"data": "kabupaten", "name": "kabupaten"},
                {"data": "kecamatan", "name": "kecamatan"},
                {"data": "kelurahan", "name": "kelurahan"},
                {"data": "jumlah_tps", "render": function (data, type, row) {
                        return '<span class="label label-info">Total-> <b>' + data + ' TPS</b></span>';
                    }, "name": "jumlah_tps"},
                {"data": "jumlah_saksi", "render": function (data, type, row) {
                        return '<span class="label label-success">Total-> <b>' + data + ' Petugas</b></span>';
                    }, "name": "jumlah_saksi"},
                {"data": "total_suara", "render": function (data, type, row) {
                        var val = 0;
                        if (data == null) {
                            val = 0
                        } else {
                            val = data
                        }
                        return '<span class="label label-warning">Total-> <b>' + val + ' Suara</b></span>';
                    }, "name": "total_suara"},
                {"data": "view_button", "name": "id_wilayah"}
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

        $('#frm-csv').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_csv').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });
        $('#frm-zip').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_zip').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });


        $('#frm-pdf').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_pdf').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });
    });
</script>