<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<?php $usr = $this->session->userdata("ktpapps"); ?>
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h4 class="text-themecolor">Dashboard </h4>
    </div>
    <div class="col-md-7 align-self-center text-right">
        <div class="d-flex justify-content-end align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item active">Dashboard Pemilihan</li>
            </ol>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_calon_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Calon</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Saksi NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Calon</button>
            <?php } ?>
            <?php if ($usr['create_prev'] == 1) { ?>
                <a href="<?php echo site_url('pemilihan/tambah_petugas_saksi/' . $pemilihan[0]->id_pemilihan); ?>"> <button type="button" class="btn btn-warning d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Tambah Saksi</button></a>
            <?php } else { ?>
                <button type="button" class="btn btn-default d-none d-lg-block m-l-15" readonly data-toggle="tooltip" data-original-title="Tambah Calon NonAktif (*hub petugas)"><i class="fa fa-plus-circle"></i> Tambah Saksi</button>
            <?php } ?>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- Row -->
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
    <h3 class="text-success"><i class="fa fa-check-circle"></i> Selamat Datang di Pemilihan "<?php echo ucwords($pemilihan[0]->nama_calon); ?> & <?php echo ucwords($pemilihan[0]->nama_wakil_calon); ?>"</h3>,Pemilihan <?php echo strtoupper($pemilihan[0]->nama_pemilihan); ?> Tahun <b><?php echo ucwords($pemilihan[0]->tahun_pemilihan); ?></b>  
</div>
<div class="card-group">
    <!-- card -->
    <div class="card col-lg-3">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h4 class="card-title m-b-0 align-self-center">Suara per Provinsi</h4>
                <div class="ml-auto">

                </div>
            </div>
            <div id="prov_donut" style="height:250px; width:100%;"></div>
        </div>
    </div>
    <!-- card -->
    <!-- card -->
    <div class="card col-lg-3">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h4 class="card-title m-b-0 align-self-center">Suara per Kabupaten/Kota</h4>
                <div class="ml-auto">

                </div>
            </div>
            <div id="kab_donut" style="height:250px; width:100%;"></div>
        </div>
    </div>
    <!-- card -->
    <!-- card -->
    <div class="card col-lg-3">
        <div class="card-body">
            <div class="d-flex m-b-30 no-block">
                <h4 class="card-title m-b-0 align-self-center">Suara per Kecamatan</h4>
                <div class="ml-auto">

                </div>
            </div>
            <div id="kec_donut" style="height:250px; width:100%;"></div>
        </div>
    </div>
    <!-- card -->
    <div class="card col-lg-3">
        <div class="p-20 p-t-25 ">
            <h4 class="card-title">Total Suara</h4>
        </div>
        <div class="d-flex no-block p-15 align-items-center">
            <div class="round round-info"><i class="icon-user font-16"></i></div>
            <div class="m-l-10 ">
                <h3 class="m-b-0"><?php echo $count[0]->calon_pemilihan; ?> Calon</h3>
                <a href="<?php echo site_url('pemilihan/daftar_calon_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>">
                    <h6 class="text-blue font-light m-b-0">lihat daftar calon *klik</h6>
                </a>
            </div>
        </div>
        <hr>
        <div class="d-flex no-block p-15 align-items-center">
            <div class="round round-primary"><i class="icon-user-follow font-16"></i></div>
            <div class="m-l-10">
                <h3 class="m-b-0"><?php echo $count[0]->saksi; ?> Saksi</h3>
                <a href="<?php echo site_url('pemilihan/daftar_petugas_saksi/' . $pemilihan[0]->id_pemilihan); ?>">
                    <h6 class="text-blue font-light m-b-0">lihat daftar saksi*klik</h6>
                </a>
            </div>
        </div>
        <hr>
        <div class="d-flex no-block p-15 m-b-15 align-items-center">
            <div class="round round-danger"><i class="icon-home font-16"></i></div>
            <div class="m-l-10">
                <h3 class="m-b-0"><?php echo $count[0]->tps; ?> TPS</h3>
                <a href="<?php echo site_url('pemilihan/daftar_region_pemilihan/' . $pemilihan[0]->id_pemilihan); ?>">
                    <h6 class="text-blue font-light m-b-0">lihat daftar Regional *klik</h6>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Suara TPS</h4>
                <h6 class="card-subtitle">Daftar Total Suara TPS disemua Regional</h6>
                <div class="table-responsive m-t-20">
                    <table class="table table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <th>Nama & Nomor TPS</th>                                                     
                                <th>Status Form C1</th>
                                <th>Suara Sah</th>
                                <th>Suara Tidak Sah</th>                    
                            </tr>
                        </thead>                          
                        <tbody>
                            <?php
                            if (!empty($tps)) {
                                $i = 1;
                                foreach ($tps as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <b>
                                                <?php echo $value->nomor_tps; ?>/<?php echo $value->nama_tps; ?>
                                            </b>
                                        </td>
                                        <td>
                                            <?php if ($value->status_formulir_c1 == 0) { ?>
                                                <span class="label label-warning"> <b>BELUM TERISI</b></span> 
                                            <?php } else { ?>
                                                <span class="label label-success"> <b>SUDAH TERISI</b></span> 
                                            <?php } ?>
                                        </td>      
                                        <td>
                                            <span class="label label-info">Total-> <b><?php echo $value->total_suara_sah; ?> Suara</b></span> 
                                        </td>          
                                        <td>
                                            <span class="label label-info">Total-> <b><?php echo $value->total_suara_tidak_sah; ?> Suara</b></span> 
                                        </td>                                         
                                    </tr>      
                                    <?php
                                    $i++;
                                }  //ngatur nomor urut
                            }
                            ?>            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Suara Calon</h4>
                <h6 class="card-subtitle">Daftar Suara Calon TPS disemua Regional</h6>
                <div class="table-responsive m-t-20">
                    <table class="table table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <th style="width: 40px;">No. Urut</th>
                                <th>Nama Calon</th>                     
                                <th>Suara Sah</th>                                     
                            </tr>
                        </thead>                        
                        <tbody>
                            <?php
                            if (!empty($calon_pemilihan)) {
                                $i = 1;
                                foreach ($calon_pemilihan as $key => $value) {
                                    ?> 
                                    <tr>
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <b class="text-success">
                                                    <?php echo $value->nomor_urut; ?>
                                                </b>
                                            <?php } else { ?>
                                                <?php echo $value->nomor_urut; ?>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <b class="text-success">
                                                    <?php echo strtoupper($value->nama_calon); ?>
                                                </b>
                                            <?php } else { ?>
                                                <?php echo strtoupper($value->nama_calon); ?>
                                            <?php } ?>
                                        </td>       
                                        <td>
                                            <?php if ($i == 1) { ?>
                                                <span class="label label-success">Total-> <b><?php echo $value->total_suara; ?> Suara</b></span>
                                            <?php } else { ?>
                                                <span class="label label-info">Total-> <b><?php echo $value->total_suara; ?> Suara</b></span> 
                                            <?php } ?>
                                        </td>                                         
                                    </tr>      
                                    <?php
                                    $i++;
                                }  //ngatur nomor urut
                            }
                            ?>            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        "use strict";
        var chart = c3.generate({
            bindto: '#prov_donut',
            data: {
                columns: [
<?php
if (!empty($provinsi_suara)) {
    foreach ($provinsi_suara as $key => $value) {
        ?>
                            [
        <?php echo "'" . ucwords($value->provinsi) . " (" . $value->total_suara . ")'";
        ?>
                            ,
        <?php echo $value->total_suara; ?>
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
                title: "Provinsi",
                width: 40,
            },
            legend: {
                hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']
            }
        });
    });
</script>
<script>
    $(function () {
        "use strict";
        var chart = c3.generate({
            bindto: '#kab_donut',
            data: {
                columns: [
<?php
if (!empty($kabupaten_suara)) {
    foreach ($kabupaten_suara as $key => $value) {
        ?>
                            [
        <?php echo "'" . strtoupper($value->adm) . '-' . ucwords($value->kabupaten) . " (" . $value->total_suara . ")'";
        ?>
                            ,
        <?php echo $value->total_suara; ?>
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
                title: "Kabupaten",
                width: 40,
            },
            legend: {
                hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']
            }
        });
    });
</script>
<script>
    $(function () {
        "use strict";
        var chart = c3.generate({
            bindto: '#kec_donut',
            data: {
                columns: [
<?php
if (!empty($kecamatan_suara)) {
    foreach ($kecamatan_suara as $key => $value) {
        ?>
                            [
        <?php echo "'" . ucwords($value->kecamatan) . " (" . $value->total_suara . ")'";
        ?>
                            ,
        <?php echo $value->total_suara; ?>
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
                title: "Kecamatan",
                width: 40,
            },
            legend: {
                hide: true
                        //or hide: 'data1'
                        //or hide: ['data1', 'data2']
            }
        });
    });
</script>

