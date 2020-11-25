<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdfgenerator {

    public function generate($html, $filename = '', $stream = TRUE, $paper = 'folio', $orientation = "portrait", $path = '') {
     
        $dompdf = new DOMPDF();
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            $output = $dompdf->output();
            file_put_contents($path, $output);
        }
    }

}
