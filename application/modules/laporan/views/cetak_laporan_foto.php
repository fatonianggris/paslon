<!DOCTYPE html>
<html>
    <head>
        <title>Report Table</title>
        <style type="text/css">
            body{
                text-align: center;
                filter: grayscale(100%);
                -webkit-filter: grayscale(100%)
            }
            table{             
                width: 0%;
                display: inline-block;     
                text-align: center;
                filter: grayscale(100%);
                -webkit-filter: grayscale(100%)

            }
            img{
                margin-top: 25px;
                margin-left: 20px;
                text-align: center;
                filter: grayscale(100%);
                -webkit-filter: grayscale(100%);
            }
        </style>
    </head>
    <body>
        <h3><?php echo strtoupper($laporan[0]->header_laporan); ?></h3>       
        <?php foreach ($ktp as $val): ?>
            <table>
                <?php if ($val->img_thumb == '' or empty($val->img_thumb) or $val->img_thumb == NULL) { ?>
                    <img width="300px" height="170px" src="<?php echo './uploads/data/ktp_contoh.png'; ?>">
                <?php } else { ?>
                    <img width="300px" height="170px" src="<?php echo './' . $val->img_thumb; ?>">
                <?php } ?>
            </table>
        <?php endforeach; ?>
    </body>
</html>