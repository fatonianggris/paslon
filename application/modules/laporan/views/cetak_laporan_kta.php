<html>
    <head>
        <title>Laporan Kartu Tanda Anggota</title>
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
             margin-bottom: 100px;
             font-size:7.0pt;
             font-family:"Helvetica",sans-serif;}


        </style>
    </head>
    <body lang=EN-ID>
        <table class="table_id">      
            <?php foreach ($kta as $val): ?>
                <tr>
                    <td>
                        <p class=MsoNormal>
                            <span style='position:relative;'>
                                <span style='position:absolute;top:-105px;height:9px;'>
                                    <!--<img width=323 height=7 src="<?php //echo './uploads/data';     ?>/image008.png">-->
                                </span>
                                <span style='position:absolute;top:-90px;width:340px;height:9px;left:65px;font-size:12.0pt;'>
                                    <b>KARTU TANDA ANGGOTA</b>
                                </span>
                            </span>

                            <span style='position:absolute;'>
                                <span style='position:absolute;top:-60px;width:120px;height:120px'>
                                    <?php if ($val->nama_ktp == "" or $val->nama_ktp == NULL) { ?>
                                        <img width=96 height=96 src="<?php echo './uploads/data'; ?>/image020.jpg">
                                    <?php } else { ?>
                                        <img width=96 height=96 src="<?php echo './' . $val->img_pas; ?>">
                                    <?php } ?>
                                </span>
                            </span>
                        </p>
                        <table class=MsoNormal style='position:relative;left:105px;top:25px;width:80%' >
                            <tr>
                                <td width="20%">Nama</td>
                                <td width="5%">:</td>
                                <td width="100%"><b><?php echo strtoupper($val->nama_ktp); ?></b></td>                    
                            </tr>       
                            <tr>
                                <td>TTL</td>
                                <td>:</td>
                                <td width="30%"><?php echo strtoupper($val->tempat_lahir); ?>, <?php echo $val->tanggal_lahir; ?></td>                    
                            </tr> 
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td width="30%" ><?php echo strtoupper($val->alamat_ktp); ?>, RT.<?php echo $val->rt; ?>, RW.<?php echo $val->rw; ?></td>                    
                            </tr> 
                            <tr>
                                <td>Kel.</td>
                                <td>:</td>
                                <td width="30%">
                                    <?php echo strtoupper(strtolower($val->kelurahan)); ?>  
                                </td>                    
                            </tr>
                            <tr>
                                <td>Kec.</td>
                                <td>:</td>
                                <td width="30%">
                                    <?php echo strtoupper(strtolower($val->kecamatan)); ?>  
                                </td>                    
                            </tr>
                            <tr>
                                <td>Kab.</td>
                                <td>:</td>
                                <td width="30%">
                                    <?php echo strtoupper(strtolower($val->kabupaten)); ?>  
                                </td>                    
                            </tr>
                            <tr>
                                <td>Propinsi</td>
                                <td>:</td>
                                <td width="10%">
                                    <?php echo strtoupper(strtolower($val->provinsi)); ?>  
                                </td>                    
                            </tr>
                            <tr>
                                <td>Kelamin</td>
                                <td>:</td>
                                <td width="30%">
                                    <?php if ($val->jenis_kelamin == 1) { ?>
                                        LAKI-LAKI                                
                                    <?php } else { ?>
                                        PEREMPUAN  
                                    <?php }
                                    ?>
                                </td>                    
                            </tr>
                        </table>
                        <span style='position:absolute; top: 165px; margin-left: 63px'>
                            <img width=200 height=30 src="<?php echo './' . $val->barcode; ?>">
                        </span>     
                        <span style='position:absolute; margin-top: -30px '>
                            <!--<img width=323 height=7 src="<?php //echo './uploads/data';     ?>/image008.png">--> 
                        </span>
                    <td>
                    <td>

                    <td>
                </tr>
            <?php endforeach; ?>
        </table>
    </body>
</html>
