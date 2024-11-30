<?php
require 'phpqrcode/qrlib.php';

// Assurez-vous qu'aucune sortie ne précède l'image
ob_clean();  // Vide le buffer de sortie

// Définir le type de contenu comme image PNG
header('Content-Type: image/png');

// Les données à encoder dans le QR code
//$data = 'F;TS01000378;TESTFQV74OMVUQRIZMPZDRTP;1201408333100;20241115173751';
$data=$_GET['QRCODE_MCF'];

// Générer le QR code directement en sortie
QRcode::png($data, false, QR_ECLEVEL_L, 10, 2);
