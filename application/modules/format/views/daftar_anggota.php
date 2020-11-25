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
                <a href="<?php echo site_url('format/formatcetak/daftar_format_pencarian'); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Buat Dapil</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Buat Dapil NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Buat Dapil</button>
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
                <h4 class="card-title">Daftar Semua Anggota</h4>
                <h6 class="card-subtitle">Daftar Semua Anggota terkait NIK, no KTA, nama dll</h6>
                <div class="col-md-12 row">
                    <div class="col-md-3 m-t-5">                          
                        <select name="label" class="form-control select2" id="label" required data-validation-required-message="Kolom ini wajib diisi!">
                            <option value="">Pilih label</option> 
                            <?php
                            if (!empty($label)) {
                                foreach ($label as $key => $value) {
                                    ?>
                                    <option value="<?php echo $value->id_format; ?>"><?php echo strtoupper($value->nama_alias); ?></option>                                     
                                    <?php
                                }
                            }
                            ?>      
                        </select>
                    </div>
                    <div class="col-md-9 m-t-5">                          
                        <small class="form-control-feedback">*centang checkbox data yang akan dipilih</small>
                    </div>
                    <div class="col-md-6 m-t-5" id="nama_label">                          
                    </div>  
                    <div class="col-md-6 m-t-5">                          
                    </div>  
                    <div class="col-md-12 m-t-10">    
                        <form class="pull-right" id="frm-pdf" target="_blank" action="<?php echo site_url('laporan/cetak_laporan_all'); ?>" method="POST">  
                            <input type="text" id="id_check_pdf" class="form-control" value="" name="data_check" style="display:none">                         
                            <div>
                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-success"><i class="fa fa-file-text"></i> Cetak Laporan.pdf</button>
                            </div>
                        </form>
                        <form class="pull-right" id="frm-kta-ktp" target="_blank" action="<?php echo site_url('laporan/cetak_kta_all'); ?>" method="POST">  
                            <input type="text" id="id_check_kta_ktp" class="form-control" value="" name="data_check" style="display:none">                         
                            <div>
                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-print"></i> Cetak KTA & KTP.pdf</button>
                            </div>
                        </form>
                        <form class="pull-right" id="frm-ktp" target="_blank" action="<?php echo site_url('laporan/cetak_kta_only_all'); ?>" method="POST">  
                            <input type="text" id="id_check_ktp" class="form-control" value="" name="data_check" style="display:none">                         
                            <div>
                                <button type="submit" class="btn waves-effect waves-light btn-xs btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-photo"></i> Cetak KTA.pdf</button>
                            </div>
                        </form>
                        <a href="<?php echo site_url('ktp/export_all_csv'); ?>" > 
                            <button type="button" class="btn waves-effect waves-light btn-xs btn-warning pull-right" style="margin-right: 10px;"><i class="fa fa-compress"></i> Export Semua Data.csv</button>
                        </a>

                    </div>
                </div>
                <div class="table-responsive m-t-10">
                    <table id="tabel_ktp2" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>                                
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>   
                                <th>Kecamatan</th>
                                <th>Kel./Desa</th>   

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td"></th>                                   
                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>                                
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
                                <th>Kecamatan</th>
                                <th>Kel./Desa</th>  

                            </tr>
                        </tfoot>
                    </table>
                    <form class="form-horizontal row m-b-10" id="frm-excel" target="_blank" action="<?php echo site_url('ktp/export_laporan'); ?>" method="POST">  
                        <div class="col-md-3 m-t-10">                          
                            <select name="tipe_laporan" class="form-control" required>
                                <option value="1">Laporan A</option> 
                                <option value="2">Laporan B</option> 
                            </select>
                        </div>
                        <input type="text" id="id_check_excel" class="form-control" value="" name="data_check" style="display:none">                         
                        <div class="col-md-2 m-t-10">                          
                            <select name="tipe_cetak" class="form-control" required>
                                <option value="csv">.csv</option> 
                                <option value="xls">.xls</option> 
                            </select>
                        </div>
                        <div class="col-md-8 m-t-10">                          
                        </div>
                        <div class="col-md-8">
                            <button type="submit" id="sub_lap" class="btn waves-effect waves-light btn-sm btn-warning"><i class="fa fa-file-text"></i> Export File</button>
                            <small class="form-control-feedback">*centang checkbox data yang akan dipilih</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var label;

        $("#label").change(function () {
            label = $(this).val();
            var url = "<?php echo site_url('format/formatcetak/get_ajax_label/'); ?>" + label;
            $('#nama_label').load(url);

            table2.ajax.url("<?php echo site_url('datatable/datatable/anggota_json/'); ?>" + $(this).val()).load();
            table2.ajax.reload();
        });

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
                "url": "<?php echo site_url('datatable/datatable/anggota_json/'); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "id_ktp", "name": "nik_ktp"},
                {"data": "view_ktp", "name": "nik_ktp"},
                {"data": "view_kta", "name": "nik_kta_baru"},
                {"data": "nama_ktp", "name": "nama_ktp"},
                {"data": "tmp_tgl_lahir", "name": "tmp_tgl_lahir"},
                {"data": "provinsi_asal", "name": "provinsi_asal"},
                {"data": "kabupaten_asal", "name": "kabupaten_asal"},
                {"data": "kecamatan_asal", "name": "kecamatan_asal"},
                {"data": "kelurahan_asal", "name": "kelurahan_asal"}

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

        $('#frm-excel').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_excel').value = rows_selected.join(",");
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
        $('#frm-kta-ktp').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_kta_ktp').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });
        $('#frm-ktp').on('submit', function (e) {
            var rows_selected = table2.column(0).checkboxes.selected();
            // Iterate over all selected checkboxes           
            document.getElementById('id_check_ktp').value = rows_selected.join(",");
            log.e(rows_selected.join(","));
            e.preventDefault();
        });
    });
</script>


