<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>LAPORAN TPS <?php echo strtoupper($get_nama_wilayah[0]->provinsi); ?> <?php echo strtoupper($get_nama_wilayah[0]->kabupaten); ?> <?php echo strtoupper($get_nama_wilayah[0]->kecamatan); ?> <?php echo strtoupper($get_nama_wilayah[0]->kelurahan); ?></title>
        <style type="text/css">

            @font-face {
                font-family: Calibrib;
                font-style: normal;
                font-weight: bold;
                src: url("<?php echo base_url(); ?>/main_assets/fonts/Calibrib.ttf") format("truetype");
            }

            @font-face {
                font-family: Calibri;
                font-weight: normal;
                font-style: normal;
                src: url("<?php echo base_url(); ?>/main_assets/fonts/Calibri.ttf") format("truetype");
            }

            .clearfix:after {
                content: "";
                display: table;
                clear: both;
            }

            a {
                color: #5D6975;
                text-decoration: underline;
            }

            body {
                position: relative;
                margin: 0 auto; 
                color: #001028;
                background: #FFFFFF; 
                font-family: Calibri; 
                font-size: 12px;                
            }

            header {
                padding: 10px 0;              
            }

            #logo {
                text-align: center;
                margin-bottom: 5px;
            }

            #logo img {
                width: 110px;
            }

            h1 {
                border-top: 1px solid  #5D6975;
                border-bottom: 1px solid  #5D6975;
                color: #5D6975;
                font-size: 2.4em;
                line-height: 1em;
                font-weight: bold;
                text-align: center;
                margin: 0 0 10px 0;

            }

            #project {
                display: inline-block;
                float: left;
                font-size: 1.1em;
            }

            #project span {
                color: #000;
                text-align: left;                
                width: 100px;
                margin-right: 10px;

                font-size: 1.1em;
            }

            .bold{
                font-family: Calibrib;
            }

            #company {
                float: right;
                text-align: right;
                font-size: 1em; 
            }

            #company span {
                text-align: right;
                color: #5D6975;
                width: 52px;
                margin-right: 10px;              
                font-size: 0.8em;
            }

            #project div,
            #company div {
                white-space: nowrap;        
            }

            .judul-calon{
                margin-bottom: 5px;
                text-align: center;
                margin-top: 5px;
                font-family: Calibrib;
            }

            .judul-table{
                margin-bottom: -35px;
                margin-top: 10px;
                font-family: Calibrib;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                font-family: Calibri;
                margin-bottom: 20px;
                margin-top: 40px;
            }          

            table tr:nth-child(2n-1) td {
                background: #F5F5F5;
            }

            table th,
            table td {
                text-align: center;
            }

            table th {
                padding: 5px 5px;
                color: #000;
                border-top: 1px solid #C1CED9;
                border-bottom: 1px solid #C1CED9;
                white-space: nowrap;        
                font-weight: normal;
            }

            table .service,
            table .desc {
                text-align: left;
            }

            table td {
                padding: 5px;
                text-align: center;
            }

            table td.service,
            table td.desc {
                vertical-align: top;
            }

            table td.paslon {
                vertical-align: top;
                font-size: 1.6em;
            }

            table td.unit,
            table td.qty,
            table td.total {
                font-size: 1em;
            }

            table td.grand {
                border-top: 1px solid #5D6975;;
            }

            #notices .notice {
                color: #000;
                font-size: 0.8em;
            }

        </style>
    </head>
    <body>
        <header class="clearfix">
            <div id="logo">
                <img src="<?php echo './' . $nama_pemilihan[0]->foto_calon_thumb; ?>">
            </div>
            <h3 class="judul-calon"><?php echo strtoupper($nama_pemilihan[0]->nomor_urut); ?> - <?php echo strtoupper($nama_pemilihan[0]->nama_calon); ?>/<?php echo strtoupper($nama_pemilihan[0]->nama_wakil_calon); ?></h3>
            <h1 class="bold"><?php echo strtoupper($nama_pemilihan[0]->nama_pemilihan); ?>-<?php echo strtoupper($nama_pemilihan[0]->tahun_pemilihan); ?></h1>
            <div id="company" >              
                <div><?php echo date("d/m/Y"); ?></div>
            </div>
            <div id="project">
                <div><span>PROVINSI  :</span> <?php echo strtoupper($get_nama_wilayah[0]->provinsi); ?></div>
                <div><span>KABUPATEN :</span> <?php echo strtoupper($get_nama_wilayah[0]->kabupaten); ?></div>
                <div><span>KECAMATAN :</span> <?php echo strtoupper($get_nama_wilayah[0]->kecamatan); ?></div>
                <div><span>KELURAHAN :</span> <?php echo strtoupper($get_nama_wilayah[0]->kelurahan); ?></div>
            </div>
        </header>

        <h3 class="judul-table">A. DATA PEMILIH & PENGGUNA HAK PILIH</h3>
        <table>
            <thead>
                <tr>
                    <th class="service" rowspan="2">NO</th>
                    <th class="desc" rowspan="2">NAMA TPS</th>
                    <th colspan="7">DATA PEMILIH (DP)</th>
                    <th colspan="7">PENGGUNA HAK PILIH (PHP)</th>
                </tr>
                <tr>
                    <th>DPT(Lk)</th>
                    <th>DPT(Pr)</th>
                    <th>DPPH(Lk)</th>
                    <th>DPPH(Pr)</th>
                    <th>DPTB(Lk)</th>
                    <th>DPTB(Pr)</th>
                    <th>TOTAL DP</th>
                    <th>DPT(Lk)</th>
                    <th>DPT(Pr)</th>
                    <th>DPPH(Lk)</th>
                    <th>DPPH(Pr)</th>
                    <th>DPTB(Lk)</th>
                    <th>DPTB(Pr)</th>
                    <th>TOTAL PHP</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($hasil_pemilihan as $value):
                    ?>
                    <tr>
                        <td class="service"><?php echo $no; ?></td>
                        <td class="desc"><?php echo strtoupper($value->nama_tps); ?>-<?php echo $value->nomor_tps; ?></td>
                        <td class="unit"><?php echo $value->dp_dpt_laki_laki; ?></td>
                        <td class="qty"><?php echo $value->dp_dpt_perempuan; ?></td>
                        <td class="total"><?php echo $value->dp_dpph_laki_laki; ?></td>
                        <td class="unit"><?php echo $value->dp_dpph_perempuan; ?></td>
                        <td class="qty"><?php echo $value->dp_dptb_laki_laki; ?></td>
                        <td class="total"><?php echo $value->dp_dptb_perempuan; ?></td>
                        <td class="unit"><?php echo $value->dp_total; ?></td>
                        <td class="qty"><?php echo $value->php_dpt_laki_laki; ?></td>
                        <td class="unit"><?php echo $value->php_dpt_perempuan; ?></td>
                        <td class="qty"><?php echo $value->php_dpph_laki_laki; ?></td>
                        <td class="unit"><?php echo $value->php_dpph_perempuan; ?></td>
                        <td class="qty"><?php echo $value->php_dptb_laki_laki; ?></td>
                        <td class="unit"><?php echo $value->php_dptb_perempuan; ?></td>
                        <td class="qty"><?php echo $value->php_total; ?></td>
                    </tr>
                    <?php
                    $no++;
                endforeach;
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td colspan="6" class=" total"></td>
                    <td colspan="1" class=" total"><?php echo $get_tambah_nama_wilayah[0]->jumlah_dp; ?></td>  
                    <td colspan="6" class=" total"><b>+</b></td>
                    <td colspan="1" class=" total"><?php echo $get_tambah_nama_wilayah[0]->jumlah_php; ?></td>
                </tr>
                <tr>
                    <td colspan="9" class="grand total"></td>
                    <td colspan="6" class="grand total">TOTAL KESELURUHAN SUARA</td>
                    <td class="grand total"><?php echo $get_tambah_nama_wilayah[0]->tambah_jumlah_php_dp; ?></td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div>KETERANGAN:</div>
            <div class="notice"> Laki-laki(Lk).</div>
            <div class="notice"> Perempuan(Pr).</div>
            <div class="notice"> Daftar Pemilih Tetap (DPT).</div>
            <div class="notice"> Daftar Pemilih Pindahan (DPPh).</div>
            <div class="notice"> Daftar Pemilih Tambahan (DPTb)/ Pengguna KTP Elektronik atau Surat Keterangan.</div>
        </div>

        <h3 class="judul-table">B. RINCIAN PEROLEHAN SUARA SAH & TIDAK SAH</h3>
        <table>
            <thead>
                <tr>
                    <th class="service" rowspan="2">NO</th>
                    <th class="desc" rowspan="2">NAMA TPS</th>
                    <?php
                    $length = 1;
                    foreach ($calon as $val):
                        ?>
                        <th colspan="1"><?php echo strtoupper($val->nomor_urut); ?>-<?php echo strtoupper($val->nama_calon); ?></th>
                        <?php
                        $length++;
                    endforeach;
                    ?>                   
                    <th colspan="1" rowspan="2">TOTAL SUARA SAH</th>
                    <th colspan="1" rowspan="2">TOTAL SUARA TIDAK SAH</th>
                </tr>
                <tr>         
                    <?php
                    foreach ($calon as $val):
                        ?>
                        <th>JUMLAH SUARA</th>
                        <?php
                    endforeach;
                    ?>    
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                foreach ($hasil_pemilihan as $value):
                    ?>
                    <tr>
                        <td class="service"><?php echo $nomor; ?></td>
                        <td class="desc"><?php echo strtoupper($value->nama_tps); ?>-<?php echo $value->nomor_tps; ?></td>
                        <?php
                        if (!empty($calon)) {
                            $stat = FALSE;
                            foreach ($calon as $c_val):
                                foreach ($suara_calon as $values):
                                    if ($c_val->id_calon_pemilihan == $values->id_calon_pemilihan) {
                                        if ($value->id_tps == $values->id_tps) {
                                            ?>
                                            <td class="unit"><?php echo $values->suara_sah; ?></td>   
                                            <?php
                                            $stat = TRUE;
                                        }
                                    }
                                endforeach;
                                if (!$stat) {
                                    ?>
                                    <td class="unit">0</td>  
                                    <?php
                                }
                            endforeach;
                        }
                        ?>
                        <td class="total"><?php echo $value->total_suara_sah; ?></td>
                        <td class="unit"><?php echo $value->total_suara_tidak_sah; ?></td>
                    </tr>   
                    <?php
                    $nomor++;
                endforeach;
                ?>
                <tr>
                    <td colspan="<?php echo $length; ?>" class="grand"></td>
                    <td colspan="1" class="grand total">TOTAL SUARA</b></td>
                    <td colspan="1" class="grand total"><?php echo $get_tambah_nama_wilayah[0]->jumlah_suara_sah; ?></td>
                    <td colspan="1" class="grand total"><?php echo $get_tambah_nama_wilayah[0]->jumlah_suara_tidak_sah; ?></td>
                </tr>
            </tbody>
        </table>
        <div id="notices">
            <div>KETERANGAN:</div>
            <div class="notice">Tabel tersbut merupakan total suara sah & tidak sah antar calon.</div>
        </div>
    </body>
</html>