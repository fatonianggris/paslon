<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Edit Calon Pemilihan</h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"> Calon Pemilihan</a></li>
                <li class="breadcrumb-item active">Edit Calon Pemilihan</li>
            </ol>        
            <a href="<?php echo site_url('pemilihan/daftar_calon_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-list-ol"></i> Daftar Calon Pemilihan</button></a> 
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <!-- Column -->
        <div class="col-lg-12 col-md-12">
            <?php echo $this->session->flashdata('flash_message'); ?>
        </div>
        <!-- Column -->
        <div class="card">
            <div class="card card-body">
                <h4 class="card-title">Edit Calon Pemilihan</h4>
                <h6 class="card-subtitle">Edit calon pemilihan terkait nama, no urut dll</h6>               
                <form class="form-horizontal m-t-10 row" action="<?php echo site_url('pemilihan/edit_calon_pemilihan/' . $get_calon_pemilihan[0]->id_calon_pemilihan . '/' . $pemilihan[0]->id_pemilihan); ?>" enctype="multipart/form-data" method="post">          
                    <div class="col-md-12 row">
                        <div class="form-group col-md-2 m-t-5">
                            <label>Nomor Urut<span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="number" min="0" name="nomor_urut" value="<?php echo $get_calon_pemilihan[0]->nomor_urut; ?>" class="form-control" placeholder="Isikan nomor urut" required data-validation-required-message="Kolom ini wajib diisi">
                            </fieldset>
                            <small class="form-control-feedback">*Contoh <b>01, 02</b></small>
                        </div>
                        <div class="form-group col-md-5 m-t-5" >
                            <label>Nama Calon <span class="text-danger">*</span></label>
                            <fieldset class="controls">
                                <input type="text" name="nama_calon" value="<?php echo strtoupper($get_calon_pemilihan[0]->nama_calon); ?>" class="form-control" placeholder="Isikan calon" required data-validation-required-message="Kolom ini wajib diisi">
                            </fieldset>
                            <small class="form-control-feedback">*Kolom Ini Harus <b>Diisi</b> ! </small>
                        </div>
                        <div class="form-group col-md-5 m-t-5" >
                            <label>Nama Wakil Calon <span class="text-danger"></span></label>
                            <fieldset class="controls">
                                <input type="text" name="nama_wakil_calon" value="<?php echo strtoupper($get_calon_pemilihan[0]->nama_wakil_calon); ?>" class="form-control" placeholder="Isikan wakil calon" >
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
</div>
<!-- .row -->
<!-- Plugin JavaScript -->

<script>

    $(document).ready(function () {
        var kategori_pemilihan = $('select[name="kategori_pemilihan"]');
        var prov = $('select[name="provinsi"]');
        var kabu = $('select[name="kabupaten"]');

        var id_prov;
        var id_kat = kategori_pemilihan.val();

        $(function () {

            if (<?php echo ($usr['role_admin']) ?> == 0) {
                document.getElementById("prov").hidden = true;
                document.getElementById("kab").hidden = true;
                prov.prop('disabled', true);
                kabu.prop('disabled', true);
            } else if (<?php echo ($usr['role_admin']) ?> == 1) {
                document.getElementById("kab").hidden = true;
                kabu.prop('disabled', true);
            } else if (<?php echo ($usr['role_admin']) ?> == 2) {
                id_prov = <?php echo ($usr['id_ref']) ?>;
                var url = "<?php echo site_url('pemilihan/add_ajax_kab'); ?>/" + id_prov;
                $('#kabupaten').load(url);
            }

            kategori_pemilihan.change(function () {
                id_kat = $(this).val();

                if ($(this).val() == 1 || $(this).val() == 2) {
                    prov.prop('disabled', true);
                    kabu.prop('disabled', true);
                    document.getElementById("prov").hidden = true;
                    document.getElementById("kab").hidden = true;
                } else if ($(this).val() == 3 || $(this).val() == 6) {
                    prov.prop('disabled', false);
                    kabu.prop('disabled', true);
                    document.getElementById("prov").hidden = false;
                    document.getElementById("kab").hidden = true;
                } else if ($(this).val() == 4 || $(this).val() == 5 || $(this).val() == 7) {
                    prov.prop('disabled', false);
                    kabu.prop('disabled', false);
                    document.getElementById("prov").hidden = false;
                    document.getElementById("kab").hidden = false;
                }

            });
        });

        $("#provinsi").change(function () {
            id_prov = $(this).val();
            var url = "<?php echo site_url('pemilihan/add_ajax_kab'); ?>/" + id_prov;
            $('#kabupaten').load(url);
            return false;
        })
    });
</script>

