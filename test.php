<?php
  //invoice.php  
        require("mpdf/vendor/pdf/mpdf/mpdf.php");
 


$mpdf = new Mpdf('utf-8','A4','','Arial',0,0,0,0,0,0,'P');
ob_start();  // start output buffering
include 'chargejour.php';
$content = ob_get_clean(); // get content of the buffer and clean the buffer
$mpdf = new mPDF(); 
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($content); 
$mpdf->Output('x.pdf','I');
?>