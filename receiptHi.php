<?php
include 'config.php';	include 'chiffre_to_lettre.php'; //echo 125;
$reqsel=mysqli_query($con,"SELECT numrecu FROM configuration_facture");
$data=mysqli_fetch_object($reqsel);
$num_recu=isset($_GET['num_recu'])?$_GET['num_recu']:NumeroFacture($data->numrecu); $client=isset($_SESSION['cli'])?$_SESSION['cli']:NULL; $nature=isset($_SESSION['nature'])?$_SESSION['nature']:NULL; $avanceA=isset($_SESSION['avanceA'])?$_SESSION['avanceA']:0;  $Numch=isset($_SESSION['tch'])?$_SESSION['tch']:NULL;

	if(!isset($_SESSION['Numreserv'])){
		if(isset($_SESSION['code_reel']))
			{ 	$sql="SELECT mensuel_compte.ttc_fixe,count(mensuel_compte.ttc_fixe)  AS Nbre FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.numfichegrpe LIKE '".$_SESSION['code_reel']."' AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche AND mensuel_fiche1.etatsortie = 'NON' GROUP BY mensuel_compte.ttc_fixe";
				include ('others/Tnuite.inc');
			}else if(isset($_SESSION['num']))
				{$sql="SELECT mensuel_compte.ttc_fixe,count(mensuel_compte.ttc_fixe)  AS Nbre FROM client, mensuel_fiche1, chambre, mensuel_compte, view_client
				WHERE mensuel_fiche1.numcli_1 = client.numcli AND mensuel_fiche1.numcli_2 = view_client.numcli
				AND mensuel_fiche1.numfiche LIKE '".$_SESSION['num']."' AND chambre.numch = mensuel_compte.numch
				AND mensuel_compte.numfiche = mensuel_fiche1.numfiche AND mensuel_fiche1.etatsortie = 'NON' GROUP BY mensuel_compte.ttc_fixe";
				//include ('others/NomClients.inc');
				$n=$_SESSION['n'];
				$s=mysqli_query($con,"SELECT mensuel_compte.date AS dateD,mensuel_fiche1.datarriv AS datarriv FROM mensuel_fiche1, mensuel_compte WHERE mensuel_fiche1.numfiche=mensuel_compte.numfiche and mensuel_fiche1.numfiche='".$_SESSION['num']."'");
				$ret1=mysqli_fetch_object($s);
				if(!empty($ret1->dateD))
					{$date1=substr($ret1->dateD,0,2); $date2=substr($ret1->dateD,3,2); $date3=substr($ret1->dateD,6,4);
					 $d=date("d/m/Y", mktime(0,0,0,date($date2),date($date1),date($date3)));
					 $dp=date("d/m/Y", mktime(0,0,0,date($date2),date($date1)+$n,date($date3)));
					}
				else {$date1=substr($ret1->datarriv,0,4); $date2=substr($ret1->datarriv,5,2); $date3=substr($ret1->datarriv,8,2);
					  $d=date("d/m/Y", mktime(0,0,0,date($date2),date($date3),date($date1)));
					  $dp=date("d/m/Y", mktime(0,0,0,date($date2),date($date3)+$n,date($date1)));
					}
				}
			}
			else if(isset($_SESSION['Numreserv'])){
				 $query_Recordset1 = "SELECT DISTINCT reedition_facture.numrecu,nuite,montant FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.numrecu = reeditionfacture2.numrecu  AND reeditionfacture2.numrecu='".$_SESSION['Numreserv']."' AND reedition_facture.receptionniste='".$_SESSION['login']."' AND state='4'";
				 $queryT=mysqli_query($con,$query_Recordset1); 	$dataT=mysqli_fetch_object($queryT);
				 $d=substr($_SESSION['debut'],8,2).'/'.substr($_SESSION['debut'],5,2).'/'.substr($_SESSION['debut'],0,4) ;
				 $dp=substr($_SESSION['fin'],8,2).'/'.substr($_SESSION['fin'],5,2).'/'.substr($_SESSION['fin'],0,4) ;
				//$Date_actuel=$dataT->date_emission;$nature=$dataT->objet;$d=$dataT->du;$dp=$dataT->au;
				if(isset($_SESSION['avc'])) $avanceA=$_SESSION['avc'];
				//$somme=$dataT->montant_ttc;
			}
			else {  //Pour la réedition des factures
					if(isset($_GET['fact'])&&($_GET['fact']==1)) $sql=" AND TypeF ='1'  "; //Ticket
					else if(isset($_GET['fact'])&&($_GET['fact']==2)) $sql=" AND TypeF ='2'  "; //Facture ordinaire
					else  $sql=" AND TypeF ='3'  ";  //Facture normalisée
				 $query_Recordset1 = "SELECT * FROM reedition_facture, reeditionfacture2 WHERE reedition_facture.numrecu = reeditionfacture2.numrecu  AND reeditionfacture2.numrecu='".$_GET['numrecu']."' AND reedition_facture.receptionniste='".$_SESSION['login']."' ".$sql;
				 $queryT=mysqli_query($con,$query_Recordset1); 	$dataT=mysqli_fetch_object($queryT);
/* 				if (!$dataT) {
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}else { */
				$Date_actuel=substr($dataT->date_emission,8,2).'/'.substr($dataT->date_emission,5,2).'/'.substr($dataT->date_emission,0,4);$nature=$dataT->objet;$d=$dataT->du;$dp=$dataT->au; $avanceA=$dataT->somme_paye;$somme=$dataT->montant_ttc;
				//}
			}
			if(!isset($_SESSION['Numreserv'])){
			if(!isset($_GET['numrecu']))
			{	$query=mysqli_query($con,$sql); // or die(mysqli_error($con))
				if (!$query) {
					printf("Error: %s\n", mysqli_error($con));
					exit();
				}

			$numfiche = isset($_SESSION['num'])?$_SESSION['num']:NULL; if(!isset($taxe)) $taxe=0;  if(!isset($nomch)) $nomch="";
			$remise=isset($_SESSION['reduction'])?$_SESSION['reduction']:$_SESSION['remise']; $remise=!empty($remise)?$remise:0;
			$sql=mysqli_fetch_assoc(mysqli_query($con,"SELECT date FROM mensuel_compte WHERE numfiche='".$numfiche."'"));$tva =isset($_SESSION['tva'])? round($_SESSION['tva']):0;
			}
			}



?>
<html>
	<head>
	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' />
	<style type="text/css">
		@media print { .noprt {display:none} }
		@page {size: portrait; }
		hr {
		height: none;
		border: none;
		border-top: 2px dashed grey;width:37%;
		}
		u {
       border-bottom: 1px dotted #000;
       text-decoration: none;
		}
	</style>
<link href="bootstrap/3.0.0/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="bootstrap/3.0.0/bootstrap.min.js"></script>
<script src="bootstrap/3.0.0/jquery-1.11.1.min.js"></script>
</head>
<body onload="window.print();" style='background-color:#84CECC;  height: auto; margin: 0; padding: 0;'>
<!------ Include the above in your HEAD tag ----------    https://bootsnipp.com/snippets/featured/receipt -->   <!------  <a href="javascript:window.print();" >Imprimer le pdf </a>  -->

<div class="container">
    <div class="row" style='margin-left:10%;'>
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong><?php echo $nomHotel ?></strong>
                        <br>
                       <?php if(isset($Apostale)) echo $Apostale ?>
                        <br> Tél:
                       <?php if(isset($telephone1)) echo $telephone1 ?>
                        <br>Email: <?php if(isset($Email)) echo $Email ?>
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em> <?php  echo "Cotonou le, ".$Date_actuel; ?></em>
                    </p>
                    <p>
                        <em>Reçu N°  : <?=$num_recu ?></em>
                    </p>
					<p>
                        <em>Nature : <?=$nature ?></em>
                    </p>
                </div>
            </div>

			<?php  echo " <table
						<tr>
							<td colspan='2' > <font size='4'><u >Client </u>:&nbsp;</font>";  $client=isset($_SESSION['code_reel'])?$_SESSION['groupe']:$client; echo $client;  echo "</td>
						</tr>
						<tr>
							<td colspan='2' > &nbsp;</td>
						</tr>
						<tr>";
							echo "<td align=''><u>Période </u> : ";
						//if(isset($_SESSION['code_reel'])){

						//}else{
								  echo $d;  echo "  au ";  echo $dp;

						//}
							echo "</td>
						</tr> </table";
			?>

            <div class="row">
                <div class="text-center">
                    <h4> <u > Détails de Facturation</u> </h4>
                </div>
                </span>
                <table class="table table-hover" style='border-top:1px solid green;'>
                    <thead>
                        <tr style='background-color:beige;'>
                            <th class="text-left">Désignation</th>
                            <th class="text-center">Nuitée</th>
                            <th class="text-right">Prix TTC</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
							<?php $i=0;$somme=0;  $query_Recordset1;
								if(isset($_GET['numrecu']) || isset($_SESSION['Numreserv'])){
								$query=mysqli_query($con,$query_Recordset1);//echo mysqli_num_rows($query);
								while($data=mysqli_fetch_array($query)){ ?>
								 <tr>
								<?php // $data['ttc']; 
									if($i==0){ $nbch=$_SESSION['nbch'];
										echo "<td class='col-md-9'><em>(".$nbch.") Chambre(s)</em></h4></td>";
									}
									else { $nbch=1;
										echo "<td class='col-md-9'><em> &nbsp;</em></h4></td>";
									}
								?>
								<td class="col-md-1" style="text-align: center"><?php echo $data['nuite']; ?></td>
								<td class="col-md-1 text-right"><?=$data['montant']; ?></td>
								<td class="col-md-1 text-right"><?php echo $sum=$data['nuite']*$data['montant']*$nbch; ?></td>
							     </tr>
								<?php 	$i++;$somme+=$sum;
								}

								}
								else {
								while($data=mysqli_fetch_array($query))
								{
							if(empty($_SESSION['Numreserv'])){ $TypeFacture=0;  //Changement d'etat au cas ou c'est exoneree
							$req2="INSERT INTO reeditionfacture2 VALUES (NULL,'1','".$num_recu."','".$numfiche."','Chambre $nomch','".$Numch."','".$_SESSION['occup']."','".$TypeFacture."','".$_SESSION['tarif']."','".$n."','".$data['ttc_fixe']."')"; $tu=mysqli_query($con,$req2);
							}

								?>
								 <tr>
								<?php
									if($i==0)
										echo "<td class='col-md-9'><em>Chambre(s)</em></h4></td>";
									else
										echo "<td class='col-md-9'><em> &nbsp;</em></h4></td>";
								?>
								<td class="col-md-1" style="text-align: center"><?php echo $Nbre=$data['Nbre']*$n; ?></td>
								<td class="col-md-1 text-right"><?=$data['ttc_fixe']; ?></td>
								<td class="col-md-1 text-right"><?php echo $sum=$data['ttc_fixe']*$Nbre; ?></td>
							     </tr>
								<?php
								$i++; $somme+=$sum;
								}
								if(empty($_SESSION['Numreserv'])){ $objet="Hébergement"; $state=0;
								echo $req1="INSERT INTO reedition_facture VALUES (NULL,'".$state."','".$Jour_actuel."','".$Heure_actuelle."','".$_SESSION['login']."','".$num_recu."','0','0','','".$client."','".$objet."','".$d."','".$dp."','$taxe','$tva','".$somme."','".$remise."','".$_SESSION['modulo']."','".$_SESSION['modulo']."')"; $tu=mysqli_query($con,$req1);}
								//$rit=mysqli_query($con,'UPDATE utilisateur SET montant_encaisse=montant_encaisse+"'.$avanceA.'" WHERE login="'.$_SESSION['login'].'"');
								}  //$_SESSION['sommePayee']
								?>
                        <tr>
                            <td><hr/></td>
                            <td rowspan='3' align='left'><br/> </td>
							<td rowspan='3' align='left'><br/><?php //echo $devise; ?>    </td>
                            <td class="" colspan='3' align='right'>

                                <strong>Montant Total : <?=$somme ?></strong>

                           <br/>

                                <strong>Avance payée : <?=$avanceA ?></strong>

                            <br/>
                            <strong> <?php $Reste = $somme - $avanceA; if($Reste<0) echo "Arrhes : "; else echo "Reste à payer :"; $Reste=abs($Reste);?>
                           <span style='color:maroon;'> <?=$Reste ?></span></strong></td>
                        </tr>
						<?php
						//if(isset($signature)) Merci pour votre visite !  
							echo "
							<tr>
								<td align='right' colspan='4'>"; //echo "<img src='logo/signature.png' alt='' title='' width='150' height='100' border='0'>	";
								echo "<br/><br/>";
								//.$signataireFordinaire.
								//echo "Le réceptionniste"; 
								echo  $_SESSION['nom']." ".$_SESSION['prenom'];
								echo "</td>
							</tr>";
						?>


                    </tbody>
                </table>

                <!-- <button type="button" class="btn btn-success btn-lg btn-block" id='button-imprimer' class='noprt' title='Imprimer' style='clear:both;'>
                    <span class="glyphicon glyphicon-chevron-left"></span>  La satisfaction du client est notre priorité !  <span class="glyphicon glyphicon-chevron-right"></span>
                </button>  !-->
            </div>
        </div>
    </div>
 </div>
 <script type="text/javascript">
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
 	</body>
</html>
<?php
unset($_SESSION['pre']); unset($_SESSION['npp']);unset($_SESSION['db']);
