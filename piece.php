<?php
include_once 'connexion.php';
//session_start();
//$numfiche=isset($_GET['numfiche'])?$_GET['numfiche']:NULL;
//$numfiche="FA20610";
	$or="SELECT img_blob FROM images WHERE numfiche='FA20778' ";
	$or1=mysqli_query($con,$or);
	//$i=0;
	while ($ret=mysqli_fetch_array($or1)) 
	{//$i++;
	  header('Content-type: image/jpeg');
		echo $ret['img_blob'];
    //echo $image;
	}
	