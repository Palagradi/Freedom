<?php
include_once'menu.php';

	$req="SELECT * FROM clients WHERE Type='".$_SESSION['menuParenT1']."'";
	$reqsel=mysqli_query($con,$req);$nbre=1+mysqli_num_rows($reqsel);
	if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;


		if (isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=='Enrégistrer')&&(!empty($_POST['nomclt'])))
		{ $reference=(int)$_POST['reference'];  $nomclt=trim(ucfirst($_POST['nomclt'])); $adresse=trim($_POST['adresse']); $telephone=trim($_POST['telephone']); $email=trim($_POST['email']);
			$reqsel=mysqli_query($con,"SELECT NomClt FROM clients WHERE NomClt='".$nomclt."'");
			if(mysqli_num_rows($reqsel)>0)
				{	echo "<script language='javascript'>";
					echo 'alertify.error(" Attention : Ce client existe déjà ");';
					echo "</script>";
				}
			else
			{ $NumIFU=0; $RaisonSociale="";$NumIFUEn=0;$RCCMEn="";$AdresseEn="";$TelEn="";
			mysqli_query($con,"SET NAMES 'utf8'");
			$re="INSERT INTO clients VALUES(NULL,'".$reference."','".$nomclt."','".$adresse."','".$telephone."','".$email."','".$_SESSION['menuParenT1']."','".$NumIFU."','".$NumIFUEn."','".$RCCMEn."','".$RaisonSociale."','".$AdresseEn."','".$TelEn."')";
						$req=mysqli_query($con,$re);
						if ($req)
							{	//$msg="<span style='color:#EF332A;font-style:italic;'>L'enregistrement s'est effectu&eacute;e avec succ&egrave;s</span>";
								echo "<script language='javascript'>";
								echo 'alertify.success(" Client enregistr&eacute; avec succ&egrave;s ");';
								echo "</script>";


							} else
							{echo "<script language='javascript'>alert('Echec lors de l'ajout');</script>";

							}
			}

	 }
	 $update=isset($_GET['update'])?$_GET['update']:NULL; //$delete=isset($_GET['delete'])?$_GET['delete']:NULL; $ap=isset($_GET['ap'])?$_GET['ap']:NULL;
	if(isset($update)){
	    $sql="SELECT * FROM clients WHERE Num='".$update."' AND Type='".$_SESSION['menuParenT1']."'";
		$reqk=mysqli_query($con,$sql);
		while($dataP = mysqli_fetch_object($reqk)){
			$nbre = $dataP->Num2;$NomClt=$dataP->NomClt;$AdresseClt=$dataP->AdresseClt;$TelClt=$dataP->TelClt;$EmailClt=!empty($dataP->EmailClt)?$dataP->EmailClt:NULL;
			if(($nbre>=0)&&($nbre<=9)) $nbre="00000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="0000".$nbre ;else $nbre="00".$nbre ;
		}
	}
	if(isset($_POST['ENREGISTRER'])&& ($_POST['ENREGISTRER']=="Modifier")){
		$update=$_POST['update']; //$update=(int)$_POST['code'];
		$reference=(int)$_POST['reference'];  $nomclt=trim(ucfirst($_POST['nomclt'])); $adresse=trim($_POST['adresse']); $telephone=trim($_POST['telephone']); $email=trim($_POST['email']);

		$rek="UPDATE clients SET NomClt='".$nomclt."', AdresseClt='".$adresse."',TelClt='".$telephone."',EmailClt='".$email."' WHERE Num='".$update."' AND Type='".$_POST['menuParenT']."'";
		$query = mysqli_query($con,$rek) or die (mysqli_error($con));

		if($query){
		echo "<script language='javascript'>";
		echo 'alertify.success(" Modification effectuée avec succès !");';
		echo "</script>";
		echo '<meta http-equiv="refresh" content="1; url=createclt.php?menuParent='.$_SESSION['menuParenT'].'" />';
		}
	}
?>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<meta name="viewport" content="width=device-width">
		<style>
		.alertify-log-custom {
				background: blue;
			}
					#lien1:hover {
			text-decoration:underline;background-color: gold;font-size:1.1em;
		}
		.bouton2 {
			border-radius:12px 0 12px 0;
			background: white;
			border:2px solid #B1221C;
			color:#B1221C;
			font:bold 12px Verdana;
			height:auto;font-family:cambria;font-size:0.9em;
		}
		.bouton2:hover{color:white;
			cursor:pointer;background-color: #B1221C;border:2px solid #B1221C;
		}
		</style><script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<script src="js/sweetalert.min.js"></script>
	</head>
	<div align="" >
	<?php
		if(isset($_GET['state']))
			{ echo "<iframe src='stateClt.php' width='1000' height='800' style='margin-left:10%;'></iframe>";
			}
		else{

			if(!empty($_GET['delete'])){ $_SESSION['delete']=$_GET['delete'];
			echo "<script language='javascript'>";
			echo 'swal("Cette action est irréversible. Voulez-vous continuer ?", {
			  dangerMode: true, buttons: true,
			}).then((value) => { var Es = value;  document.location.href="createclt.php?menuParent='.$_SESSION['menuParenT'].'&test="+Es;
			}); ';
			echo "</script>";
		}  //https://sweetalert.js.org/docs/#configuration
		if(!empty($_GET['test'])&& ($_GET['test']=='true')){
			//$rz="SELECT * FROM produits WHERE num='".$_SESSION['aj']."' AND Type='".$_SESSION['menuParenT1']."'"; $req=mysqli_query($con,$rz);
			//$data=mysqli_fetch_object($req);  $Qte_initial= $data->Qte_Stock; $Qte_Stock=$Qte_initial+$_SESSION['delete'];$update=$data->Num2 ;
		 	$rek="DELETE FROM clients WHERE Num='".$_SESSION['delete']."' AND Type='".$_SESSION['menuParenT1']."'";
			$query = mysqli_query($con,$rek) or die (mysqli_error($con)); //$ref="PRIN".$update ;  $service=" "; $designationOperation ='Mise à jour Produits';
			if($query){
			//$re="INSERT INTO operation VALUES(NULL,'".$ref."','".$designationOperation."','".$update."','".$Qte_initial."','".$_SESSION['delete']."','".$Qte_Stock."','".$Jour_actuel."','".$Heure_actuelle."','','".$_SESSION['qte']."')";
			//$req=mysqli_query($con,$re);
			echo "<script language='javascript'>";
			echo 'alertify.success(" Opération effectuée avec succès !");';
			echo "</script>";
			}
		} if(!empty($_GET['test'])&& ($_GET['test']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error(" L\'opération a été annulée !");';
			echo "</script>";
		}
	?>
		<div align="center" style="padding-top:25px;">
				<form action="createclt.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>" method="POST">
					<table align='center'width="800" height="350" border="0" cellpadding="0" cellspacing="0" id='tab' >
					<tr>
						<td colspan="2">
							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'> <?php  if(isset($update)) echo "MISE A JOUR - INFORMATIONS - CLIENT"; else { ?> ENREGISTREMENT - DES CLIENTS <?php } ?></h3>
						</td>
					</tr>
					<tr>
						<td style="padding-left:100px;">N° d'enrég.  : <span style="font-style:italic;font-size:0.9em;color:red;"></span></td>
						<td>&nbsp;&nbsp;<input type="text" id="reference" name="reference" readonly value="<?php if(isset($nbre))echo $nbre;?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td style="padding-left:100px;"> Nom du client : <span style="font-style:italic;font-size:0.9em;color:red;">*</span></td>
						<td>&nbsp;&nbsp;<input type="text" id="nomclt" name="nomclt" required='required'  value="<?php if(isset($NomClt))echo $NomClt;?>"  placeholder=" Personne physique ou morale" style="width:200px;"/> </td>
					</tr>

					<tr>
						<td style="padding-left:100px;"> Adresse du client: <span style="font-style:italic;font-size:0.9em;color:red;"></span></td>
						<td>&nbsp;&nbsp;<input type="text" id="adresse" name="adresse"   value="<?php if(isset($AdresseClt))echo $AdresseClt;?>" style="width:200px;"/> </td>
					</tr>
					<tr>
						<td  style="padding-left:100px;" >Numéro de Téléphone :&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td >&nbsp;&nbsp;<input type="tel" id="telephone" name="telephone"   value="<?php if(isset($TelClt))echo $TelClt;?>" onkeypress='testChiffres(event);' style="width:200px;height:22px;font-family:sans-serif;font-size:80%;"/> </td>
					</tr>
					<tr>
						<td  style="padding-left:100px;" >Adresse électronique :&nbsp;&nbsp;&nbsp;<span class="rouge"></span></td>
						<td >&nbsp;&nbsp;<input type="email" id="" name="email"  value="<?php if(isset($EmailClt))echo $EmailClt;?>" style="width:200px;height:22px;font-family:sans-serif;font-size:80%;" placeholder=' Email' value="" /></td>
					</tr>
					<tr>
						<td colspan='2' align='center' ><br/><input type="submit"   value="<?php if(isset($update)) echo "Modifier"; else echo "Enrégistrer";?>" id="" class="bouton2"  name="ENREGISTRER" style=""/>
						&nbsp;&nbsp;<input type="reset" value="Annuler" class="bouton2"  name="Annuler" style=""/> </td>
					</tr>

				</table>  <?php if(isset($update)) echo "<input type='hidden'  name='update' readonly value='".$update."'/> ";
												 echo "<input type='hidden'  name='menuParenT' readonly value='".$_SESSION['menuParenT1']."'/>"; ?>
		</div>
			<?php
			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'>";
		    if(isset($msg)) echo $msg;
			 echo "</td></tr></table>";
			?>
				<table align="center" width="800" border="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;font-family:Cambria;">
				<tr><td colspan='6' > <span style="align:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste de tous les Clients
						<span style='color:black;font-size:0.7em;font-weight:normal;'><?php
					$reqsel=mysqli_query($con,"SELECT * FROM clients WHERE Type='".$_SESSION['menuParenT1']."' ORDER BY Num2 ASC ");
					$nbre_clts=mysqli_num_rows($reqsel);
					$CltsParPage=25; //Nous allons afficher 5 contribuable par page.
					$nombreDePages=ceil($nbre_clts/$CltsParPage); //Nous allons maintenant compter le nombre de pages.

					if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
					{
						  $pageActuelle=intval($_GET['page']);

						 if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
						 {
							   $pageActuelle=$nombreDePages;
						 }
					}
					else // Sinon
					{
						  $pageActuelle=1; // La page actuelle est la n°1
					}
					 $premiereEntree=($pageActuelle-1)*$CltsParPage;

					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='color:red;'>Page :</span> "; //Pour l'affichage, on centre la liste des pages
						for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
						{
							 //On va faire notre condition
							 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
							 {
								 echo ' [ '.$i.' ] ';
							 }
							 else //Sinon...
							 {
								  if(!empty($fiche))
									echo ' <a href="createclt.php?menuParent='.$_SESSION['menuParenT1'].'&page='.$i.'">'.$i.'</a> ';
								  else
									echo ' <a href="createclt.php?menuParent='.$_SESSION['menuParenT1'].'&page='.$i.'">'.$i.'</a> ';
							 }
						}
					?>
					</span></span>
					 <span style="float:right;font-weight:normal;font-size:1em;color:#4C767A;font-style:italic;" >
					<a href="createclt.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&state=1" style="text-decoration:none;color:teal;">Edition de la liste en pdf,<img src="logo/pdf_small.gif"style=""/> <a/></span>
					</td></tr>
					<tr style=" background-color:#3EB27B;color:white;font-size:1.2em; ">
						<td style="border-right: 2px solid #ffffff" align="center" >N° d'Enrég.</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Nom du client</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Adresse</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Téléphone</td>
						<td style="border-right: 2px solid #ffffff" align="center" >Email</td>
						<td align="center" >Actions</td>
					</tr>
					<?php
						  mysqli_query($con,"SET NAMES 'utf8'");
					   $query_Recordset1 = "SELECT * FROM clients WHERE Type='".$_SESSION['menuParenT1']."' ORDER BY Num2 ASC LIMIT $premiereEntree, $CltsParPage";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;$dataT="";
							while($data=mysqli_fetch_array($Recordset_2))
							{
								if($cpteur == 1)
								{
									$cpteur = 0;
									$bgcouleur = "#DDEEDD";
								}
								else
								{
									$cpteur = 1;
									$bgcouleur = "#dfeef3";
								}
								$nbre=$data['Num2'];

								$ecrire=fopen('txt/client.txt',"w");
								$dataT.=$nbre.';'.$data['NomClt'].';'.$data['AdresseClt'].';'.$data['TelClt'].';'.$data['EmailClt']."\n";
								$ecrire2=fopen('txt/client.txt',"a+");
								fputs($ecrire2, $dataT);

								if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;

								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$nbre."</td>";
								echo " 	<td align=''      style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['NomClt']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['AdresseClt']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['TelClt']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff;'>".$data['EmailClt']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff;border-top: 2px solid #ffffff;'>";
									echo " 	<a class='info' href='createclt.php?menuParent=".$_SESSION['menuParenT']."&update=".$data['Num']."'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style=''>Modifier</span></a>";
									echo " 	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
									echo " 	<a class='info' href='createclt.php?menuParent=".$_SESSION['menuParenT']."&delete=".$data['Num']."'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style=''>Supprimer</span></a>";

										echo " 	</td>";
									echo " 	</tr> ";
							}
						//}
					?>
					<tr></tr>
				</table>
			</form>

<?php
 }
 ?>
</div>
</html>
