<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Daftar & Tambah Dapil</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Dapil</a></li>
                <li class="breadcrumb-item active">Daftar & Tambah Dapil</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('format/formatcetak/daftar_data_anggota'); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Data Anggota Dapil</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Data Anggota Dapil NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Data Anggota Dapil</button>           
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
        <!-- Column -->
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Tambah Dapil</h4>
                <h6 class="card-subtitle">Tambah Dapil terkait nama, status, alamat dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('format/formatcetak/kirim_format'); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">
                        <div class="form-group col-md-3 m-t-5">
                            <label>Tingkat Kategori <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kategori_dapil" class="form-control" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <?php if ($usr['role_admin'] == 1) { ?>
                                        <option value="2" selected>DPD</option> 
                                        <option value="3">DPC</option>  
                                    <?php } else if ($usr['role_admin'] == 2) { ?>                                   
                                        <option value="3" selected>DPC</option>
                                    <?php } else { ?>
                                        <option value="1" selected>DPP</option> 
                                        <option value="2">DPD</option> 
                                        <option value="3">DPC</option>
                                    <?php } ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-9 m-t-5" >
                            <label>Nama Label <span class="text-danger">*</span></label>
                            <input type="text" name="nama_alias" class="form-control" placeholder="Isikan nama label" required data-validation-required-message="Kolom ini wajib diisi">
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="form-group col-md-4">
                            <label>Pilih Provinsi <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="provinsi" class="select2 form-control" style="width: 100%; height:36px;" id="provinsi" required data-validation-required-message="Kolom ini wajib diisi!">
                                    <option value="">Pilih Provinsi</option>
                                    <?php
                                    if (!empty($prov)) {
                                        foreach ($prov as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id; ?>"><?php echo $value->nama; ?></option>                                     
                                            <?php
                                        }
                                    }
                                    ?>                       
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Pilih Kabupaten <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kabupaten[]" class="select_kab form-control select2-multiple" multiple="multiple" style="width: 100%; height:36px;" id="kabupaten" required data-validation-required-message="Kolom ini wajib diisi!">
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group col-md-4" id="kec">
                            <label>Pilih Kecamatan <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <select name="kecamatan[]" class="select2 form-control select2-multiple" multiple="multiple" style="width: 100%; height:36px;" id="kecamatan"> 
                                       
                                </select>
                            </fieldset>
                        </div>   
                    </div>
                    <div class="form-group col-md-12 m-t-5">
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                        <button type="reset" onclick="history.back()" class="btn btn-inverse waves-effect waves-light">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">              
                <div class="table-responsive m-t-5">
                    <table id="tabel_petugas" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Alias</th>                            
                                <th>Provinsi</th> 
                                <th>Kabupaten</th> 
                                <th>Kecamatan</th>                                 
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Kategori</th>
                                <th>Nama Alias</th>                                
                                <th>Provinsi</th> 
                                <th>Kabupaten</th> 
                                <th>Kecamatan</th>                                                           
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
        var kategori_dapil = $('select[name="kategori_dapil"]');
        var prov = $('select[name="provinsi"]');
        var kab = $('select[name="kabupaten[]"]');
        var kec = $('select[name="kecamatan[]"]');

        var id_prov;
        var id_kab;
        var id_kat = kategori_dapil.val();

        $(function () {

            $(".select_kab").select2({
                maximumSelectionLength: 1000
            });

            if (<?php echo ($usr['role_admin']) ?> != 2) {
                document.getElementById("kec").hidden = true;
            }

            kategori_dapil.change(function () {
                id_kat = $(this).val();
                if ($(this).val() == 1) {
                    prov.val(null).trigger('change');
                    kab.val(null).trigger('change');
                    kec.val(null).trigger('change');
                    kec.prop('disabled', true);
                    $(".select_kab").select2({
                        maximumSelectionLength: 1000
                    });
                    document.getElementById("kec").hidden = true;
                } else if ($(this).val() == 2) {
                    prov.val(null).trigger('change');
                    kab.val(null).trigger('change');
                    kec.val(null).trigger('change');
                    kec.prop('disabled', true);
                    $(".select_kab").select2({
                        maximumSelectionLength: 1000
                    });
                    document.getElementById("kec").hidden = true;
                } else {
                    prov.val(null).trigger('change');
                    kab.val(null).trigger('change');
                    kec.prop('required', true);
                    kec.prop('disabled', false);
                    $(".select_kab").select2({
                        maximumSelectionLength: 1
                    });
                    document.getElementById("kec").hidden = false;
                }
            });
        });

        $("#provinsi").change(function () {
            id_prov = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('format/formatcetak/add_ajax_kab'); ?>",
                data: {id_prov: id_prov, id_kat: id_kat},
                success: function (msg)
                {
                    console.log(msg);
                    $('#kabupaten').html(msg);
                },
                error: function (msg)
                {
                    console.log(msg);
                }
            });
        })

        $("#kabupaten").change(function () {
            id_kab = $(this).val();
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('format/formatcetak/add_ajax_kec'); ?>",
                data: {id_prov: id_prov, id_kab: id_kab, id_kat: id_kat},
                success: function (msg)
                {
                    console.log(msg);
                    $('#kecamatan').html(msg);
                },
                error: function (msg)
                {
                    console.log(msg);
                }
            });
        })
    });
</script>

<script type="text/javascript">
    function act_del_format(object) {
        var name = $('#' + object).val();
        swal({
            title: "Apakah anda yakin?",
            text: "Apakah anda yakin ingin menghapus Dapil " + name + " ?",
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
                    url: "<?php echo site_url("format/formatcetak/delete_format") ?>",
                    data: {id: object},
                    dataType: 'html',
                    success: function (result) {
                        swal("Terhapus!", "Dapil " + name + " telah terhapus.", "success");
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
                swal("Dibatalkan", "Dapil " + name + " batal dihapus.", "error");
            }
        });
    }
</script>

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

        var json_kab = getJSON('<?php echo site_url('format/formatcetak/get_ajax_kab'); ?>');
        var json_kec = getJSON('<?php echo site_url('format/formatcetak/get_ajax_kec'); ?>');

        function get_kab(data, type, row) {
            var text = '';
            var duce = jQuery.parseJSON(json_kab);
            var explode = data.split(",");
            for (i = 0; i < duce.length; i++) {
                if (explode.includes(duce[i].kab_con)) {
                    text += '<span class="label label-info m-l-5"><b>' + duce[i].nama + ' [' + duce[i].administratif + ']</b></span>';
                }
            }
            return text;
        }

        function get_kec(data, type, row) {
            var text = '';
            var duce = jQuery.parseJSON(json_kec);
            var explode = data.split(",");
            for (i = 0; i < duce.length; i++) {
                if (explode.includes(duce[i].kec_con)) {
                    text += '<span class="label label-warning m-l-5"><b>' + duce[i].nama + '</b></span>';
                }
            }
            return text;
        }

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
                "url": '<?php echo site_url('datatable/datatable/format_json'); ?>',
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columns": [
                {"data": "kategori_dapil", "render": function (data, type, row) {
                        if (data == 1) {
                            return '<span class="label label-success"><b>DPP</b></span>';
                        } else if (data == 2) {
                            return '<span class="label label-warning"><b>DPD</b></span>';
                        } else if (data == 3) {
                            return '<span class="label label-danger"><b>DPC</b></span>';
                        }
                    }, "name": "kategori_dapil"},
                {"data": "nama_alias", "name": "nama_alias"},
                {"data": "provinsi_nama", "render": function (data, type, row) {
                        return '<span class="label label-success"><b>' + data + '</b></span>';
                    }, "name": "provinsi_nama"},
                {"data": "kabupaten", "render": get_kab, "name": "kabupaten"},
                {"data": "kecamatan", "render": get_kec, "name": "kecamatan"},
                {"data": "view_button", "name": "view_button"}
            ],

            order: []
        });
    });

</script>



