<html>
    <head>
        <title><?php echo strtoupper($kartu_mandat[0]->nama_saksi); ?></title>
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
                                <!--<img width=323 height=7 src="<?php //echo './uploads/data';                         ?>/image008.png">-->
                            </span>
                            <span style='position:absolute;top:-90px;width:340px;height:9px;left:90px;font-size:12.0pt;'>
                                <b>KARTU MANDAT</b>
                            </span>
                        </span>

                        <span style='position:absolute;'>
                            <span style='position:absolute;top:-60px;width:120px;height:120px'>
                                <?php if ($kartu_mandat[0]->img_pas == "" or $kartu_mandat[0]->img_pas == NULL) { ?>
                                    <img width=96 height=96 src="<?php echo './uploads/data'; ?>/image020.jpg">
                                <?php } else { ?>
                                    <img width=96 height=96 src="<?php echo './' . $kartu_mandat[0]->img_pas; ?>">
                                <?php } ?>
                            </span>
                        </span>
                    </p>
                    <table class=MsoNormal style='position:relative;left:105px;top:25px;width:80%' >
                        <tr>
                            <td width="20%">Nama</td>
                            <td width="5%">:</td>
                            <td width="100%"><b><?php echo strtoupper($kartu_mandat[0]->nama_saksi); ?></b></td>                    
                        </tr>       
                        <tr>
                            <td>TTL</td>
                            <td>:</td>
                            <td width="30%"><?php echo strtoupper($kartu_mandat[0]->tempat_lahir); ?>, <?php echo $kartu_mandat[0]->tanggal_lahir; ?></td>                    
                        </tr> 
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td width="30%" ><?php echo strtoupper($kartu_mandat[0]->alamat_saksi); ?>, RT.<?php echo $kartu_mandat[0]->rt; ?>, RW.<?php echo $kartu_mandat[0]->rw; ?></td>                    
                        </tr> 
                        <tr>
                            <td>Kel.</td>
                            <td>:</td>
                            <td width="30%">
                                <?php
                                if (!empty($kel)) {
                                    foreach ($kel as $key => $val) {
                                        if ($val->id == substr($kartu_mandat[0]->id_asal_saksi, 6, 2) && $val->id_dati1 == substr($kartu_mandat[0]->id_asal_saksi, 0, 2) && $val->id_dati2 == substr($kartu_mandat[0]->id_asal_saksi, 2, 2) && $val->id_dati3 == substr($kartu_mandat[0]->id_asal_saksi, 4, 2)) {
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
                                        if ($val->id == substr($kartu_mandat[0]->id_asal_saksi, 4, 2) && $val->id_dati1 == substr($kartu_mandat[0]->id_asal_saksi, 0, 2) && $val->id_dati2 == substr($kartu_mandat[0]->id_asal_saksi, 2, 2)) {
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
                                        if ($val->id == substr($kartu_mandat[0]->id_asal_saksi, 2, 2) && $val->id_dati1 == substr($kartu_mandat[0]->id_asal_saksi, 0, 2)) {
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
                                        if ($val->id == substr($kartu_mandat[0]->id_asal_saksi, 0, 2)) {
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
                                <?php if ($kartu_mandat[0]->jenis_kelamin == 1) { ?>
                                    LAKI-LAKI                               
                                <?php } else { ?>
                                    PEREMPUAN  
                                <?php }
                                ?>
                            </td>                    
                        </tr>
                    </table>
                    <span class="MsoNormal" style='position:absolute; top: 162px; margin-left:0px'>
                        <div style='padding: 1px; border: 2px solid black; width:95px; text-align: center; font-size: 11px;'>
                            <?php if ($kartu_mandat[0]->nomor_tps != '' || $kartu_mandat[0]->nomor_tps != NULL) { ?>
                                <b>TPS <?php echo $kartu_mandat[0]->nomor_tps; ?></b>                            
                            <?php } else { ?>
                                <b>KOSONG</b>
                            <?php }
                            ?>
                            <br>
                            <b style="font-size: 9px;"><?php echo strtoupper(strtolower($kartu_mandat[0]->nama_kelurahan)); ?></b>
                        </div>
                    </span>
                    <span style='position:absolute; top: 165px; margin-left:120px'>
                        <img width=180 height=25 src="<?php echo './' . $kartu_mandat[0]->barcode; ?>">
                    </span>     
                    <span style='position:absolute; margin-top: -30px '>
                        <!--<img width=323 height=7 src="<?php //echo './uploads/data';                         ?>/image008.png">-->
                    </span>
                <td>
                <td>
                <td>
            </tr>
        </table>
    </body>
</html>
