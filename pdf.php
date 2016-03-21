<?php

require 'urlToPDF.php';

$pdf = new urlToPDF();
$pdf->displayPdf($_GET['url']);
