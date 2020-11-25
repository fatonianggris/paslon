<html>
    <head>
        <title><?php echo strtoupper($kta[0]->nik_kta_baru); ?></title>
        <style type="text/css">
            /* Font Definitions */
            body{
                text-align: center;

            }
            #table_id {

                text-align: center;
            }

            #table_id td {
                width: 0%;
                float: left;
                text-align: center;
            }

            /* Style Definitions */
            .MsoNormal
            {margin-top:90px;                               
             font-size:7.0pt;
             font-family:"Helvetica",sans-serif;}

        </style>
    </head>
    <body lang=EN-ID>
        <table class="table_id">          
            <tr>
                <td>
                    <p class=MsoNormal>
                        <span style='position:relative;'>
                            <span style='position:absolute;top:-105px;height:9px;'>
                                <!--<img width=323 height=7 src="<?php //echo './uploads/data';      ?>/image008.png">-->
                            </span>
                            <span style='position:absolute;top:-90px;width:340px;height:9px;left:65px;font-size:12.0pt;'>
                                <b>KARTU TANDA ANGGOTA</b>
                            </span>
                        </span>

                        <span style='position:absolute;'>
                            <span style='position:absolute;top:-60px;width:120px;height:120px'>
                                <?php if ($kta[0]->nama_ktp == "" or $kta[0]->nama_ktp == NULL) { ?>
                                    <img width=96 height=96 src="<?php echo './uploads/data'; ?>/image020.jpg">
                                <?php } else { ?>
                                    <img width=96 height=96 src="<?php echo './' . $kta[0]->img_pas; ?>">
                                <?php } ?>
                            </span>
                        </span>
                    </p>
                    <table class=MsoNormal style='position:relative;left:105px;top:25px;width:90%' >
                        <tr>
                            <td width="20%">Nama</td>
                            <td width="5%">:</td>
                            <td width="100%"><b><?php echo strtoupper($kta[0]->nama_ktp); ?></b></td>                    
                        </tr>       
                        <tr>
                            <td>TTL</td>
                            <td>:</td>
                            <td width="30%"><?php echo strtoupper($kta[0]->tempat_lahir); ?>, <?php echo $kta[0]->tanggal_lahir; ?></td>                    
                        </tr> 
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td width="30%" ><?php echo strtoupper($kta[0]->alamat_ktp); ?>, RT.<?php echo $kta[0]->rt; ?>, RW.<?php echo $kta[0]->rw; ?></td>                    
                        </tr> 
                        <tr>
                            <td>Kel.</td>
                            <td>:</td>
                            <td width="30%">
                                <?php
                                if (!empty($kel)) {
                                    foreach ($kel as $key => $val) {
                                        if ($val->id == substr($kta[0]->id_asal, 6, 2) && $val->id_dati1 == substr($kta[0]->id_asal, 0, 2) && $val->id_dati2 == substr($kta[0]->id_asal, 2, 2) && $val->id_dati3 == substr($kta[0]->id_asal, 4, 2)) {
                                            ?>
                                            <?php echo strtoupper(strtolower($val->nama)); ?>                                    
                                            <?php
                                        }
                                    }
                                }
                                ?>    
                            </td>                    
                        </tr>
                        <tr>
                            <td>Kec.</td>
                            <td>:</td>
                            <td width="30%">
                                <?php
                                if (!empty($kec)) {
                                    foreach ($kec as $key => $val) {
                                        if ($val->id == substr($kta[0]->id_asal, 4, 2) && $val->id_dati1 == substr($kta[0]->id_asal, 0, 2) && $val->id_dati2 == substr($kta[0]->id_asal, 2, 2)) {
                                            ?>
                                            <?php echo strtoupper(strtolower($val->nama)); ?>                                    
                                            <?php
                                        }
                                    }
                                }
                                ?>    
                            </td>                    
                        </tr>
                        <tr>
                            <td>Kab.</td>
                            <td>:</td>
                            <td width="30%">
                                <?php
                                if (!empty($kab)) {
                                    foreach ($kab as $key => $val) {
                                        if ($val->id == substr($kta[0]->id_asal, 2, 2) && $val->id_dati1 == substr($kta[0]->id_asal, 0, 2)) {
                                            ?>
                                            <?php echo strtoupper(strtolower($val->nama)); ?>                                    
                                            <?php
                                        }
                                    }
                                }
                                ?> 
                            </td>                    
                        </tr>
                        <tr>
                            <td>Propinsi</td>
                            <td>:</td>
                            <td width="10%">
                                <?php
                                if (!empty($prov)) {
                                    foreach ($prov as $key => $val) {
                                        if ($val->id == substr($kta[0]->id_asal, 0, 2)) {
                                            ?>
                                            <?php echo strtoupper(strtolower($val->nama)); ?>                                    
                                            <?php
                                        }
                                    }
                                }
                                ?> 
                            </td>                    
                        </tr>
                        <tr>
                            <td>Kelamin</td>
                            <td>:</td>
                            <td width="30%">
                                <?php if ($kta[0]->jenis_kelamin == 1) { ?>
                                    LAKI-LAKI                               
                                <?php } else { ?>
                                    PEREMPUAN  
                                <?php }
                                ?>
                            </td>                    
                        </tr>
                    </table>

                    <span style='position:absolute; top: 165px; margin-left: 63px'>
                        <img width=200 height=30 src="<?php echo './' . $kta[0]->barcode; ?>">
                    </span>     
                    <span style='position:absolute; margin-top: -30px '>
                        <!--<img width=323 height=7 src="<?php //echo './uploads/data';      ?>/image008.png">-->
                    </span>
                <td>
                <td>

                <td>
            </tr>

        </table>
    </body>
</html>
