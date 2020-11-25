<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
<!-- Bootstrap popper Core JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/popper/popper.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- slimscrollbar scrollbar JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/js/perfect-scrollbar.jquery.min.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/js/custom.min.js"></script>
<!--c3 JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/d3/d3.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/c3-master/c3.min.js"></script>
<!-- Popup message jquery -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/toast-master/js/jquery.toast.js"></script>
<!-- Column -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/sweetalert/sweetalert.min.js"></script>
<!-- end - This is for export functionality only -->
<!-- Color Picker Plugin JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery-asColorPicker-master/libs/jquery-asColor.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery-asColorPicker-master/libs/jquery-asGradient.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
<!-- Date Picker Plugin JavaScript -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/moment/moment.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- jQuery file upload -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/tinymce/tinymce.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/jmask/dist/jquery.mask.min.js"></script>
<!-- This is data table -->
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/wizard/jquery.steps.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/wizard/jquery.validate.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/wizard/steps.js"></script>

<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/alertifyjs/alertify.min.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/dist/js/pages/validation.js"></script>
<script src="<?php echo base_url(); ?>main_assets/admin_asset/assets/node_modules/dropify/dist/js/dropify.min.js"></script>

<!-- start - This is for export functionality only -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<!-- Chart JS -->
<script>
    !function (window, document, $) {
        "use strict";
        $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
    }(window, document, jQuery);
</script>
<script>
    $(".colorpicker").asColorPicker();
</script>
<script>
    $(function () {
        "use strict";
        var chart = c3.generate({
            bindto: '#visitor',
            data: {
                columns: [
<?php
if (!empty($ktp_reg)) {
    foreach ($ktp_reg as $key => $value) {
        ?>
                            [
        <?php
        echo "'" . ucwords($value->nama_admin) . "'";
        ?>
                            ,
        <?php echo $value->jml_ktp; ?>
                            ],
        <?php
    }
}
?>
                ],
                type: 'donut',
                onclick: function (d, i) {
                    console.log("onclick", d, i);
                },
                onmouseover: function (d, i) {
                    console.log("onmouseover", d, i);
                },
                onmouseout: function (d, i) {
                    console.log("onmouseout", d, i);
                }
            },
            donut: {
                label: {
                    show: false
                },
                title: "Regional",
                width: 40,
            },
            legend: {
                hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']
            }
        });
        // ============================================================== 
        // Our Income
        // ==============================================================
        var chart = c3.generate({
            bindto: '#income',
            data: {
                x: 'x',
                columns: [
                    ['x',
<?php
$no = 1;
if (!empty($ktp_petugas)) {
    foreach ($ktp_petugas as $key => $value) {
        echo "'" . $no . "'";
        ?>
                                ,
        <?php
        $no++;
    }
}
?>
                    ],
                    ['Jumlah Anggota',
<?php
if (!empty($ktp_petugas)) {
    foreach ($ktp_petugas as $key => $value) {
        echo "'" . $value->jml_ktp . "'";
        ?>
                                ,
        <?php
    }
}
?>],
                ],
                type: 'bar'
            },
            bar: {
                space: 0.2,
                // or
                width: 40 // this makes bar width 100px
            },
            axis: {
                x: {
                    type: 'category',
                    tick: {centered: true},
                }
            },
            legend: {
                hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']
            },
            grid: {
                x: {
                    show: false
                },
                y: {
                    show: true
                }
            },
            size: {
                height: 290
            },
            color: {
                pattern: ['#7460ee', '#009efb']
            }
        });
        // Dashboard 1 Morris-chart
    });
</script>
<script>
    $('#tabel_ktp1 tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table1 = $('#tabel_ktp1').DataTable({
        order: []
    });

// Apply the search
    table1.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_regional tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table4 = $('#tabel_regional').DataTable({
        order: []
    });

// Apply the search
    table4.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_admin_prov tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table6 = $('#tabel_admin_prov').DataTable({
        order: []
    });

// Apply the search
    table6.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });


    $('#table_dashboard tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table7 = $('#table_dashboard').DataTable({
        order: []
    });

// Apply the search
    table7.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_admin_nas tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table8 = $('#tabel_admin_nas').DataTable({
        order: []
    });

// Apply the search
    table8.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_pemilihan tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table9 = $('#tabel_pemilihan').DataTable({
        order: []
    });

// Apply the search
    table9.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_pemilihan tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });
// DataTable
    var table10 = $('#tabel_saksi').DataTable({
        order: []
    });

// Apply the search
    table10.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change clear', function () {
            if (that.search() !== this.value) {
                that.search(this.value)
                        .draw();
            }
        });
    });

    $('#tabel_saksi tfoot th').each(function () {
        $(this).html('<input type="text"/>');
    });

    $('#tabel_suadmin').DataTable({
        "order": []
    });

    $('#tabel_calon_pemilihan').DataTable({
        "order": []
    });
</script>
<script>
    $(document).ready(function () {
        // Used events
        var drEvent = $('.dropify').dropify();
        drEvent.on('dropify.beforeClear', function (event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.errors', function (event, element) {
            console.log('Has Errors');
        });
    });
</script>
<script>
    $("#pemilihan_date").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years"
    });
    $('#mdate').bootstrapMaterialDatePicker({weekStart: 0, time: false, format: 'DD/MM/YYYY'});
    $('#mdate').bootstrapMaterialDatePicker('setDate', '01/01/2000').change()
    $('#mdate').val(null).change();
    $('#mdate_edit').bootstrapMaterialDatePicker({weekStart: 0, time: false, format: 'DD/MM/YYYY'});
    $('#mdate_kta').bootstrapMaterialDatePicker({weekStart: 0, time: false, format: 'DD/MM/YYYY'});
    $('#license_date').bootstrapMaterialDatePicker({weekStart: 0, time: false, format: 'DD/MM/YYYY'});

</script>
<script>
    $(document).ready(function () {
        $(".select2").select2();
        $('#peringatan_toko').modal('show');
        $('#peringatan_produk').modal('show');
    });
</script>
<script src="https://cdn.tiny.cloud/1/v9ah6qbhhksf2u889zmk775f79so4iq99na96p1pdwp26u3a/tinymce/5/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: 'textarea#blog',
        height: 500,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | image code | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ]
    });
    tinymce.init({
        selector: 'textarea#desc',
        height: 300,
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste code help wordcount'
        ],
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent',
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tiny.cloud/css/codepen.min.css'
        ]
    });
</script>
