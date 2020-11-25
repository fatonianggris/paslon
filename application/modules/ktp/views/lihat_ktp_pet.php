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
                <a href="<?php echo site_url('ktp/tambah_ktp_pet/' . $pet[0]->id_petugas); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Anggota Petugas</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Anggota per Petugas NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Anggota per Petugas</button>
            <?php } ?>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('petugas/tambah_petugas'); ?>"> <button type="button" class="btn btn-success d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Petugas</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Petugas Anggota per NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Petugas </button>
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
                    <h3 class="text-white box m-b-0"><i class="ti-id-badge"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-info"><?php echo $count[0]->ktp; ?></h3>
                    <h5 class="text-muted m-b-0">Jumlah Anggota</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-6 col-md-6">
        <div class="card">
            <div class="d-flex flex-row">
                <div class="p-10 bg-danger">
                    <h3 class="text-white box m-b-0"><i class="ti-na"></i></h3></div>
                <div class="align-self-center m-l-20">
                    <h3 class="m-b-0 text-danger"><?php echo $count[0]->ktp_duplicate; ?></h3>
                    <h5 class="text-muted m-b-0">ID Anggota Duplikat</h5></div>
            </div>
        </div>
    </div>
    <!-- Column -->

</div>
<!-- Row -->
<div class="row">
    <div class="col-12">
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Anggota per Petugas "<?php echo ucwords($pet[0]->nama_petugas) ?>"</h4>
                <h6 class="card-subtitle">Daftar Anggota per petugas "<?php echo ucwords($pet[0]->nama_petugas) ?>" penduduk terkait NIK, no KK, nama dll</h6>
                <?php if ($usr['create_prev'] == 1) { ?>
                    <a data-target="#import" data-toggle="modal" > 
                        <button type="button" class="btn waves-effect waves-light btn-xs btn-info"><i class="fa fa-download"></i> Import Data.csv</button>
                    </a>
                <?php } else { ?>
                    <button type="button" class="btn waves-effect waves-light btn-xs btn-default" data-toggle="tooltip" data-original-title="Import CSV NonAktif (*hub petugas)"><i class="fa fa-download"></i> Import .csv</button>
                <?php } ?>

                <a href="<?php echo site_url('laporan/cetak_laporan_pet/' . $pet[0]->id_petugas); ?>" target="_blank"> 
                    <button type="button" class="btn waves-effect waves-light btn-xs btn-success pull-right"><i class="fa fa-print"></i> Cetak Laporan.pdf</button>
                </a>
                <form class="pull-right" id="frm-kta-ktp" target="_blank" action="<?php echo site_url('laporan/cetak_kta_pet/' . $pet[0]->id_petugas); ?>" method="POST">  
                    <input type="text" id="id_check_kta_ktp" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-print"></i> Cetak KTA & KTP.pdf</button>
                    </div>
                </form>
                <form class="pull-right" id="frm-ktp" target="_blank" action="<?php echo site_url('laporan/cetak_kta_only_pet/' . $pet[0]->id_petugas); ?>" method="POST">  
                    <input type="text" id="id_check_ktp" class="form-control" value="" name="data_check" style="display:none">                         
                    <div>
                        <button type="submit" class="btn waves-effect waves-light btn-xs btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-photo"></i> Cetak KTA.pdf</button>
                    </div>
                </form>
                <a href="<?php echo site_url('ktp/export_csv_pet/' . $pet[0]->id_petugas); ?>" > 
                    <button type="button" class="btn waves-effect waves-light btn-xs btn-warning pull-right" style="margin-right: 10px;"><i class="fa fa-file-text"></i> Export Data Petugas.csv</button>
                </a>
                <div class="table-responsive m-t-10">
                    <table id="tabel_ktp2" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>
                                <th>Jenis Kel.</th>
                                <th>Kab/Kota</th>
                                <th>Provinsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="clear-td"></th>                                   
                                <th>No. KTP</th>
                                <th>No. KTA</th>
                                <th>Nama</th>
                                <th>Tmp/Tgl Lahir</th>
                                <th>Jenis Kel.</th>
                                <th>Kab/Kota</th>
                                <th>Provinsi</th>
                                <th class="clear-td">Aksi</th>
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
                        <input type="text" id="id_check" class="form-control" value="" name="data_check" style="display:none">                         
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
    <div id="import" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="myModalLabel"><b>Import Data .csv </b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('ktp/upload_csv_pet/' . $pet[0]->id_petugas); ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-body">                  
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title text-danger">SEBELUM MENGUPLOAD DIHARAPKAN MENGEDIT FILE .CSV SESUAI CONTOH FORMAT HEADER & ISI CSV DIBAWAH INI  !!!</h5>
                                <img class="m-t-20"src="<?php echo base_url() . 'uploads/data/contoh_excel.png'; ?>" alt="user" height="70" width="700">
                                <p class="card-text m-t-5">Silahkan <b>MENGOSONGKAN ISI</b> kolom header pada daftar csv Anggota anda, jika header <b>TIDAK SESUAI</b> dengan file anda</p>
                                <div class="form-group col-md-12 m-t-5 text-left">
                                    <label>Nama Region Anggota <span class="text-danger">*</span></label>
                                    <select name="region_anggota" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="region_anggota" required>
                                        <?php
                                        if (!empty($admin_regional) && $pet[0]->id_admin != null) {
                                            foreach ($admin_regional as $key => $value) {
                                                if ($value->id_ref == $pet[0]->id_admin) {
                                                    ?>
                                                    <option value="<?php echo $pet[0]->id_admin; ?>" selected="">
                                                        <?php echo strtoupper($value->provinsi); ?>
                                                        <?php
                                                        if ($value->kabupaten != NULL) {
                                                            echo ' - ' . strtoupper($value->kabupaten);
                                                        }
                                                        ?>                                
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <?php if (empty($pet[0]->id_admin) or $pet[0]->id_admin == 0) {
                                            ?>
                                            <option value="" selected="">Pilih nama regional</option>
                                        <?php } ?>
                                    </select>
                                    <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                                </div>
                                <div class="form-group col-md-12 m-t-5 text-left">
                                    <label>Nama Petugas  <span class="text-danger">*</span></label>
                                    <select name="nama_petugas" class="select2 form-control custom-select" style="width: 100%; height:36px;" id="nama_petugas" required>
                                        <option value="<?php echo $pet[0]->id_petugas ?>"><?php echo ucwords($pet[0]->nama_petugas) ?></option>

                                    </select>
                                    <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                                </div>
                                <div class="form-group col-md-12 text-left">
                                    <label>Upload File .CSV</label>
                                    <input type="file" name="csv" class="form-control" required="" aria-invalid="false">
                                    <small class="form-control-feedback">*Gunakan Ukuran File Kurang Dari <b>10 Mb</b> ! </small>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info waves-effect" >Import Data</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="mutasi" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="myModalLabel"><b>Mutasi Anggota </b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form class="form-horizontal" action="<?php echo site_url('mutasi/mutasi_anggota_pet'); ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-body">                  
                        <div class="card text-center">
                            <div class="card-body">                               
                                <div class="form-group col-md-12 text-left">
                                    <label>Region Tujuan Mutasi<span class="text-danger">*</span></label>
                                    <select name="id_region_tujuan" class="select2 form-control custom-select" style="width: 100%; height:36px;" required="" data-validation-required-message="Kolom ini wajib diisi!" id="region_anggota">
                                        <option>Pilih region mutasi</option>
                                        <?php
                                        if (!empty($admin_mutasi)) {
                                            foreach ($admin_mutasi as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->id_ref; ?>">
                                                    <?php echo strtoupper($value->provinsi); ?>
                                                    <?php
                                                    if ($value->kabupaten != NULL) {
                                                        echo ' - ' . strtoupper($value->kabupaten);
                                                    }
                                                    ?>
                                                </option>                                     
                                                <?php
                                            }
                                        }
                                        ?>                       
                                    </select>
                                    <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                                </div>                                                               
                                <div class="form-group col-md-12 m-t-5 text-left">
                                    <input type="hidden" name="id_ktp" id="id_ktp" class="form-control">
                                    <input type="hidden" name="id_url" value="<?php echo $pet[0]->id_petugas; ?>" class="form-control">
                                    <label>Keterangan <span class="text-danger">*</span></label>
                                    <textarea name="keterangan" id="textarea" class="form-control" rows="5" placeholder="Isikan keterangan mutasi" aria-invalid="false"></textarea>
                                    <small class="form-control-feedback">*Kolom <b>Tidak</b> harus Diisi! </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success waves-effect" >Mutasi Anggota</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="disable_mutasi" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-danger" id="myModalLabel"><b>Pemberitahuan !</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">                  
                    <div class="card text-center">
                        <div class="card-body">                               
                            <h5 class="card-title text-danger">MOHON MAAF, ANGGOTA INI TELAH MENGIRIM PROSES MUTASI.</h5>
                            <p class="card-text m-t-5">Silahkan <b>MENGECEK/MELIHAT</b> daftar mutasi pada menu mutasi anggota. Terima Kasih.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                       
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function mutasi_anggota(id, id_mutasi) {
        if (id_mutasi == '' || id_mutasi == null) {
            $('#id_ktp').val(id);
            // Call Modal Edit
            $('#mutasi').modal('show');
        } else {
            $('#disable_mutasi').modal('show');
        }
    }
</script>
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
                "url": '<?php echo site_url('datatable/datatable/ktp_pet_json/' . $pet[0]->id_petugas); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "id_ktp", "name": "nik_ktp"},
                {"data": "view_ktp", "name": "nik_ktp"},
                {"data": "view_kta", "name": "nik_kta_baru"},
                {"data": "nama_ktp", "name": "nama_ktp"},
                {"data": "tmp_tgl_lahir", "name": "tmp_tgl_lahir"},
                {"data": "jenis_kelamin", "name": "jenis_kelamin"},
                {"data": "provinsi_asal", "name": "provinsi_asal"},
                {"data": "kabupaten_asal", "name": "kabupaten_asal"},
                {"data": "view_button", "name": "id_ktp"}
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

<script type="text/javascript">
    function act_del_ktp(object) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Anggota " + name + " ?",
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
