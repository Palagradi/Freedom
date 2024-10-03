<?php
include 'config.php';
require ('vendor/autoload.php');

/* 	 // Instantiate the library class
	 $barcode = new \Com\Tecnick\Barcode\Barcode();
	 $dir = "qr-code/";

	 // Directory to store barcode
	 if (! is_dir($dir)) {
			 mkdir($dir, 0777, true);
	 }
	 // data string to encode
	 $source = "https://www.etutorialspoint.com/";

	 // ser properties
	 $qrcodeObj = $barcode->getBarcodeObj('QRCODE,H', $source, - 16, - 16, 'black', array(
			 - 2,
			 - 2,
			 - 2,
			 - 2
	 ))->setBackgroundColor('#f5f5f5');

	 // generate qrcode
	 $imageData = $qrcodeObj->getPngData();
	 $timestamp = time();

	 //store in the directory
	 file_put_contents($dir . $timestamp . '.png', $imageData);

		//Output image to the browser
		 //echo '<img src="'.$dir . $timestamp.'".png" width="200px" height="200px">';




 */
 
	
$table=(isset($_SESSION['Ntable'])&&(!empty($_SESSION['Ntable']))) ? $_SESSION['Ntable']:NULL; $num_facture=isset($_SESSION['numFact'])?$_SESSION['numFact']:NULL;
    if (isset($_GET['param0'])) {
        $param0 = $_GET['param0'];
		$req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.id='".htmlspecialchars($param0)."' ";
		$reqselRTables=mysqli_query($con,$req);
    } else if(isset($num_facture)) {
        echo $req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.num_facture=factureResto.num_facture AND factureResto.num_facture='".trim($num_facture)."' ";
		$reqselRTables=mysqli_query($con,$req);
    }	
	else
	{ 
	}
	
/* else
	{  $req="SELECT * FROM factureResto,tableEnCours WHERE tableEnCours.numTable=factureResto.numTable AND factureResto.numTable='".$table."' AND date_emission ='".$Jour_actuel."'  ";
	  //$reqselRTables=mysqli_query($con,$req);
		$reqselRTables=mysqli_query($con,"SELECT * FROM tableEnCours WHERE numTable='".$table."' AND Etat='Desactive' ");
	} */

	$factureResto=mysqli_query($con,$req);
	while($data1=mysqli_fetch_array($factureResto)){ $Net=$data1['montant_ttc']-$data1['Remise'];
	$SommePayee=$data1['somme_paye']; $monnaie=$SommePayee-$Net;$remise=$data1['Remise'];
	 $NomClient=!empty($data1['NomClient'])?$data1['NomClient']:"<i>Non renseigné</i>";
	 $heure=$data1['heure_emission'];$numRecu=$data1['num_facture'];
	}
$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");

?>
<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="css/bootstrap.min.js"></script>
<script src="css/jquery-1.11.1.min.js"></script>
<link href="css/customize.css" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
<body onload="window.print();" style='background-color:#84CECC;'>
<div class="container">
	<div class="row" >
        <div class="receipt-main" style='margin:0px;'>
            <div class="row">
    			<div class="receipt-header">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="receipt-left">
								<img class="img-responsive" alt="iamgurdeeposahan" src="<?php if(!empty($logo)) echo $logo; ?>" style="width: 250px; border-radius: 43px;">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 text-right">
						<div class="receipt-right">
							<h5><?php 	if(!empty($nomHotel)) echo $nomHotel;  ?></h5>
							<?php
							if(empty($NumUFI) || ($NumUFI ='11111111111111')) {
							} else if(!empty($NumUFI))
								echo  "<p>N° IFU: ".$NumUFI." <i class='fa fa-phone'></i></p>  ";
							else if(!empty($NumBancaire))
								echo  "<p>Compte Bancaire: ".$NumBancaire." <i class='fa fa-phone'></i></p>  ";
							else {
							}
							?>
							<p><?php echo $telephone1; ?> <i class="fa fa-phone"></i></p>
							<p><?php echo $Email; ?>  <i class="fa fa-envelope-o"></i></p>
							<p> <i class="fa fa-location-arrow"></i></p>
						</div>
					</div>
				</div>
            </div>

			<div class="row">
				<div class="receipt-header receipt-header-mid">
					<div class="col-xs-8 col-sm-8 col-md-8 text-left">
						<div class="receipt-right">
							<h5><small><?php 	if(!empty($Date_actuel)) echo date('d')." ". $moisT[date('m')-1]." ".date('Y');  ?>  |  <?php echo $heure; ?></small></h5>
							<p>Client  &nbsp;&nbsp;&nbsp;&nbsp;:  <?php echo $NomClient; ?></p>
							<p>Caissier : <?php echo "<i>". $_SESSION["nom"]." ".$_SESSION["prenom"]."</i>"; ?> </p>
						</div>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4">
						<div class="receipt-left">
							<h4> Ticket N°: <?php echo $numRecu; ?> </h4>
						</div>
					</div>
				</div>
            </div>

            <div>
                <table class="table table-bordered">
                    <thead style='background-color:gray;'>
                        <tr>
							<th style='text-align:center;'>#</th>
                            <th>Désignation</th>
                            <th style='text-align:center;'>Prix </th>
							<th style='text-align:center;'>Qté</th>
                            <th style='text-align:center;'>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
					   if(isset($reqselRTables)){$total=0;$num=0;//$mt=0;
						while($data1=mysqli_fetch_array($reqselRTables)){ $num++;
						$mt=$data1['qte']*$data1['prix'];$total+=$mt;
							echo "<tr>
								<td align='center' class='col-md-3'> ".$num.".</td>
								<td class='col-md-9' >".ucfirst($data1['LigneCde'])." ".$data1['QteInd']."</td>
								<td align='center' class='col-md-3'> ".$data1['prix']."</td>
								<td align='center' class=''> ".$data1['qte']."</td>
								<td  align='right' class=''><i class='fa fa-inr'></i>  ".$mt."</td>
							</tr>";
						}
					   }
					     //$data1['montant_ttc']

						?>
              <?php

						  echo 	"<tr>
									<td  colspan='4' align='right'> <strong> Montant Total : </strong>  ";

									if($remise>0)
										echo "<br/><strong> Remise accordée : </strong>";

									echo "<br/><strong> Net à payer :</strong>
									<br/><strong> Somme payée :</strong> ";
									if($monnaie>0)
										echo "<br/><strong> Monnaie : </strong> </td>";
										?>
										<td align='right' style=''><strong><i class="fa fa-inr"></i> <?php echo $total;?>
										<br/><?php echo $Net;?><br/>	<?php echo $SommePayee;?></strong>									

									<?php
									if($remise>0)
										echo " <br/><strong><i class='fa fa-inr'></i> ". $remise."</strong> ";

									if($monnaie>0)
										echo "<br/><strong><i class='fa fa-inr'></i> ". $monnaie."</strong> </td>

							    </tr>";


									//QRcode::png('code data text', 'filename.png'); // creates file
									//QRcode::png('some othertext 1234'); // creates code image and outputs it directly into browser
					     ?>
                    <tr>
                        <td colspan='4' class="text-right"><h4><strong>Total encaissé : </strong></h4></td>
                        <td align='right' style='color:maroon;'><h4><strong><i class="fa fa-inr"></i> <?php echo $total." ".substr($devise,0,1);?></strong></h4></td>
                    </tr>
                </tbody>
                </table>
            </div>

			<div class="">

							<div style='float:left;border:1px solid maroon;'>
							<?php
							//echo '<img style="" src="'.$dir . $timestamp.'".png" width="100px" height="100px">';
							//echo $_SESSION["nom"]." ".$_SESSION["prenom"];?></div>
							<!--<h5 style="color: rgb(140, 140, 140);">Merci pour la visite!</h5> !-->
							<div style=''>&nbsp;&nbsp;&nbsp;&nbsp; MECeF NIM :
							<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;MECeF Compteurs :
							<br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;MECeF Heure :
							&nbsp;&nbsp;&nbsp;&nbsp;ISF : <?php echo $_SESSION['ISF']; ?>
						</div>
        </div>

        </div>
	</div>
</div>
</body>
﻿<?php
//$Query="UPDATE tableEnCours SET Etat='Desactive' WHERE Etat='active'"; $exec=mysqli_query($con,$Query);
