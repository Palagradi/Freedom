<?php
require 'IrivenPhpCodeEncryption.php';
$encryption = new IrivenPhpCodeEncryption();
/**
* from file to file
*
*/
//==> SPECIFIC FILE NAME
$encryption->loadCode('index.php');
$encryption->compileDatas();
$encryption->save('encrypted.php');

//chained command method
$encryption->loadCode('index.php')->compileDatas()->save('encrypted.php');

//==> SAVE WITH AUTO-FILENAME
$encryption->loadCode('index.php');
$encryption->compileDatas();
$encryption->save();

//chained command method
$encryption->loadCode('index.php')->compileDatas()->save();

/**
* from file to memory
*
*/
$encryption->loadCode('index.php');
$encryption->compileDatas();
$encryption->getCode();
