<?php
include_once'menu.php';

unset($_SESSION['choix1']);

if(isset($_POST['trie'])) { if($_POST['trie']==1) $trie="Famille"; else $trie="Fournisseur"; } else $trie="Num";

	if(isset($_POST['choix1']))
	{	if( !empty($_POST['choix'])){
				$choix ='';
				//on boucle
				for ($i=0;$i<count($_POST['choix']);$i++)
				{	//on concatène
					$choix .= $_POST['choix'][$i].'|';
					$explore = explode('|',$choix);
					if($explore[$i]!='')
						{  $explore[$i]."<br/>";
						}
				}

			}	//$reqselz=mysqli_query($con,"DELETE FROM Boncommande");
			if( !empty($_POST['choix1'])){
				$choix1 ='';
				for ($i=0;$i<count($_POST['choix1']);$i++)
				{	$choix1 .= $_POST['choix1'][$i].'|';
					$explore1 = explode('|',$choix1);
					if(($explore1[$i]!='')&& ($explore1[$i]>0))
						{	   //echo "<br/>".$explore1[$i]; //$QteCde=$explore1[$i];
						 	  $sql="SELECT composition FROM plat WHERE numero='".$_GET['plat']."' ";
								$reqselz=mysqli_query($con,$sql);	$dataz=mysqli_fetch_assoc($reqselz); $composition=$dataz['composition'];
								// if(mysqli_num_rows($reqselz)>0)	{
								// //$QteCde=$QteCde+$Qte;
								// $sql="DELETE FROM Boncommande WHERE Date='".$Jour_actuel."' AND NumPro='".$_GET['aj']."' AND NumFrs='".$_GET['Frs']."'";
								// $exec=mysqli_query($con,$sql);
								// }

								//$ListeProduits = explode("|",$dataz['ListeProduits']);
								//$composition="";
								$ListeComposition = explode("|",$dataz['composition']);
								$compositionT= array();$compositionT=str_split($dataz['composition']);
								$update=0;$composition="";
								for($j=0;$j<count($compositionT);$j++){
										if($compositionT[$j]==";"){
											if(($j-1>=0)&&($compositionT[$j-1]==$_GET['produit'])){
												$compositionT[$j+1]=$explore1[$i];$update=1;
											}
										}
								} //$composition=serialize($compositionT); //echo var_dump($compositionT);
								for($j=0;$j<count($compositionT);$j++){
									$composition.=$compositionT[$j];
								}
								if($update==0){
										$composition.=	"|".$_GET['produit'].";".$explore1[$i];
								}
								//echo $composition;

								// if(!empty($dataz['composition'])){
								// 	for($j=0;$j<count($ListeComposition);$j++)
								// 	{ $Produits = explode(";",$ListeComposition[$j]);
								// 		for($k=0;$k<count($Produits);$k++)
								// 		{	if(isset($Produits[0])&& ($Produits[0]==$_GET['produit']))
								// 			 {
								// 				 $Produits[1]=$explore1[$i]; //else echo $Produits[0];
								// 				 if($k==0) $composition.="|".$Produits[0].";".$Produits[1];
								// 			 }
								// 			 else {
								// 				 if($k==0) $composition.=	"|".$_GET['produit'].";".$explore1[$i];
								// 			 }
								// 		}//$composition.="|";
								// 	}
								// }else {
								// 	$composition.=	"|".$_GET['produit'].";".$explore1[$i];
								// }

							 //echo var_dump($composition);

								// if(empty($composition)) $composition.=	$_GET['produit'].";".$explore1[$i];
								// else
								// $composition.=	"|".$_GET['produit'].";".$explore1[$i];
								//if(isset($ListeComposition)) $composition=$ListeComposition;

								if(empty($plat))
									$sql="UPDATE plat SET composition='".$composition."' WHERE numero='".$_GET['plat']."' ";
								  $reqInsert = mysqli_query($con,$sql); unset($plat);
								if(isset($reqInsert)&&($reqInsert))
									{	echo "<script language='javascript'>";
										echo 'alertify.success(" Enrégistrement effectué avec succès");';
										echo "</script>";
										//echo '<meta http-equiv="refresh" content="0; url=EstimPortion.php?menuParent='.$_SESSION['menuParenT'].'" />';

								}

						}
				}
			}
	}
?><html>
	<head>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<link rel="Stylesheet" href='css/table.css' />
		<style>
			.alertify-log-custom {
					background: blue;
				}
						#lien1:hover {
				text-decoration:underline;background-color: gold;font-size:1.1em;
			}

		</style>
		<script src="js/sweetalert.min.js"></script>
		</head>
	<body bgcolor='azure' style="margin-top:-20px;padding-top:0px;">
		<table align='center'>
			<tr>
			<td>
				<h2 style=' font-family:Cambria;color:Maroon;font-weight:bold;margin-bottom:50px;'>		<hr style=''/>QUANTIFICATION DES PRODUITS ALIMENTAIRES DANS UN PLAT	<hr style=''/></h2>
			</td>
		</tr>
	</table>
<?php
if(!isset($_GET['Cde'])) { ?>

	<form class="ajax" action="" method="get">
		<p align='center' style='margin-bottom:50px;'>
			<label style='font-size:22px;font-weight:bold; padding:3px;color:#B83A1B;font-family: Cambria, Verdana, Geneva, Arial;' for="q">Rechercher un plat
			<span style='font-size:15px;color:#777;'></span></label>
			 <input style='background-color:#EFFBFF;width:400px;padding:3px;border:1px solid #aaa;-moz-border-radius:7px;-webkit-border-radius:7px;border-radius:7px;height:25px;line-height:22px;' type="text" name="q" id="q" placeholder=" "/>
		</p>
	</form>
	<div id="resultsC">

	<table align='center' width='80%' border='0' cellspacing='0' style='margin-top:0px;border-collapse: collapse;font-family:Cambria;'>

<tr><td colspan='13' > <span style="float:left;font-family:Cambria;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:#4C767A;" >Liste des produits   </span>
	<?php
	//mysqli_query($con,"SET NAMES 'utf8'");
	//$result =   mysqli_query($con, 'SELECT *  FROM boisson	LIMIT 0,10' );
	$sql="SELECT * FROM produits p INNER JOIN fournisseurs f ON p.Fournisseur=f.NumFrs WHERE Type='".$_SESSION['menuParenT1']."' ORDER BY $trie ";
	$reqsel=mysqli_query($con,$sql);
	$nbrePalimentaire=mysqli_num_rows($reqsel);
	$PalimentairesParPage=25; //Nous allons afficher 5 contribuable par page.
	$nombreDePages=ceil($nbrePalimentaire/$PalimentairesParPage); //Nous allons maintenant compter le nombre de pages.

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
	 $premiereEntree=($pageActuelle-1)*$PalimentairesParPage;
	$res=mysqli_query($con,"SELECT * FROM produits WHERE Type='".$_SESSION['menuParenT1']."' LIMIT $premiereEntree, $PalimentairesParPage");
	$nbre1=mysqli_num_rows($res);

	$famille=isset($_POST['famille'])?$_POST['famille']:NULL;
	$plat=isset($_POST['plat'])?$_POST['plat']:NULL;
	$famille=isset($_GET['famille'])?$_GET['famille']:$famille;
	//$famille=isset($_GET['famille'])?$_GET['famille']:$famille;
	$plat=isset($_GET['plat'])?$_GET['plat']:$plat;
	//$plat=isset($_GET['plat'])?$_GET['plat']:$plat;
	$produit=isset($_GET['produit'])?urlencode($_GET['produit']):NULL;

	$sqlF=mysqli_query($con,"SELECT DISTINCT CategoriePlat FROM plat ");
	if(!empty($plat))
		$sqlPi=mysqli_query($con,"SELECT numero,designation FROM plat  WHERE numero='".$plat."'");
	//else
		$sqlP=mysqli_query($con,"SELECT numero,designation FROM plat  WHERE CategoriePlat='".$famille."'");


//echo
 ?>
</span>
	<form action="EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; //if(isset($produit)) echo "&produit=".$produit;  ?>" method="POST" id='chgdept1' >
<span style="float:right;font-family:Cambria;font-weight:bold;font-size:1em;margin-bottom:5px;color:#4C767A;" ><a href='<?php echo "EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&triep=1"; ?>' style='text-decoration:none;color:teal;'>  </a>

	<select name='plat' style='margin-bottom:8px;font-family:sans-serif;font-size:100%;border:0px solid teal;width:auto;' id='plat' onchange="document.forms['chgdept1'].submit();"  >
	<?php
	if((isset($_GET['plat']))&& (urldecode($_GET['plat'])==$plat))
	$plat=urldecode($_GET['plat']);
	else if((isset($_GET['plat']))&& (urldecode($_GET['plat'])!=$plat)) $plat=$_GET['plat'];
	else {}
//	echo "<option value ='".$plat."'> ".urldecode($_GET['plat'])."</option>";
	//else
	if(isset($sqlPi)&& mysqli_num_rows($sqlPi)>0) {$dataPi = mysqli_fetch_assoc($sqlPi);
	//if(isset($dataP['designation'])){
			echo "<option value ='".$dataPi['numero']."'> ".ucfirst($dataPi['designation'])."</option>";
	}
	else echo "<option value =''> </option>";
	while($dataP = mysqli_fetch_array($sqlP)){
	echo "<option value ='".$dataP['numero']."'> ".ucfirst($dataP['designation'])."</option>
		<option value =''>  </option>";

	}
	?>
	</select>

 </span>
  <span style="float:right;font-family:Cambria;font-weight:bold;font-size:1em;margin-bottom:5px;color:#4C767A;" >Catégorie(s) de plats: &nbsp;&nbsp;

	<span style="float:right;font-family:Cambria;font-weight:bold;font-size:1em;margin-bottom:5px;color:#4C767A;" >
		&nbsp;&nbsp;&nbsp;&nbsp;plat(s) : &nbsp;&nbsp;
  </span>
	<select name='famille' style='margin-bottom:8px;font-family:sans-serif;font-size:100%;border:0px solid teal;width:150px;' id='trie' onchange="document.forms['chgdept1'].submit();"  >
	  <?php
		echo "<option value ='".$famille."'> ".$famille."</option>";
		$data = mysqli_fetch_assoc($sqlF);
		echo "<option value ='".$dataF['CategoriePlat']."'> ".ucfirst($dataF['CategoriePlat'])."</option>
			<option value =''>  </option>";

		?>
	</select>
 </span>

</form>


	<form action="EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; if((isset($_GET['plat']))&& (urldecode($_GET['plat'])==$plat)) echo "&plat=".urldecode($_GET['plat']); else echo "&plat=".$plat; if(isset($_GET['famille'])) echo "&famille=".urlencode($_GET['famille']); if(isset($_GET['produit'])) echo "&produit=".urlencode($_GET['produit']);?>" method="POST" id='chgdept' >

<input type='hidden' name='triep' value='<?php if(isset($trie)) echo $trie;?>' >

<tr style='background-color:#3EB27B;color:white;font-size:1.2em; padding-bottom:5px;'>
	<td style="border-right: 2px solid #ffffff" align="center"><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">N° d'Enrég.<span style='font-size:0.8em;'></span></a></td>
	<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Famille<span style='font-size:0.8em;'></span></a></td>
	<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Désignation<span style='font-size:0.8em;'></span></a></td>
	<td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='Bar.php?menuParent=Restauration&trie=2' style='text-decoration:none;color:white;' title=''>Qté <span style='font-size:0.8em;'></span></a></td>
  <td style="border-right: 2px solid #ffffff" align="center" ><a class='info'  href='EstimUnites.php?menuParent=Restauration&trie=2' style='text-decoration:none;color:white;' title=''>Unité de <br/> Stockage <span style='font-size:0.8em;'></span></a></td>
		<td style="border-right: 2px solid #ffffff" align="center" ><a class='info' href='Bar.php?menuParent=Restauration&trie=1' style='text-decoration:none;color:white;' title="">Valeur en <br/>Unités<span style='font-size:0.8em;'></span></a></td>
	<td align="center" >Nbre de <br/> plats à servir</td>
</tr>
					<?php
							if((isset($_GET['plat']))&& ($_GET['plat']==$plat))
								//echo $sql="SELECT  * FROM plat WHERE CategoriePlat='".$famille."' AND designation='".urldecode($_GET['plat'])."'";
							//else if((isset($_GET['plat']))&& (urlencode($_GET['plat'])==$plat))
								//echo $sql="SELECT  * FROM plat WHERE CategoriePlat='".$famille."' AND designation='".urlencode($_GET['plat'])."'";
							//else
							$plat=$_GET['plat'];
								//echo $sql="SELECT  * FROM plat WHERE CategoriePlat='".$famille."' AND designation='".$plat."'";
								$sql="SELECT  * FROM plat WHERE numero='".$plat."'";
							$result=mysqli_query($con,$sql);$cpteur=1;
							while( $data = mysqli_fetch_array($result))
										{  if($cpteur == 1)
											{
												$cpteur = 0;
												$bgcouleur = "#DDEEDD";
											}
											else
											{
												$cpteur = 1;
												$bgcouleur = "#dfeef3";
											}
											$nbre=$data['numero'];

											if(isset($_GET['ListeProduits']))
												$ListeProduits =  explode("|",$_GET['ListeProduits']);
											else
												$ListeProduits = explode("|",$data['ListeProduits']);
											for($i=0;$i<count($ListeProduits);$i++)
											{
											//if($data['numero']==$ListeProduits[$i])
											{

											$sql2="SELECT  * FROM produits WHERE Num='".$ListeProduits[$i]."' ";
											$result2=mysqli_query($con,$sql2);
											while( $data2 = mysqli_fetch_object($result2))
											{$nbre=$data2->Num2;
											if(($nbre>=0)&&($nbre<=9)) $nbre="0000".$nbre ; else if(($nbre>=10)&&($nbre <=99)) $nbre="000".$nbre ;else $nbre="00".$nbre ;
													echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";?>
												<td align="center" style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $nbre;  ?> </td>
								 				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'><?php echo $data2->Famille; ?> </td>
								 				<td style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php echo $data2->Designation; ?></td>
												<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>
													<a href='#' class='info5' ><span>
												</span><?php echo 1; ?></a></td>
												 <?php //if($UnitStockage==1)  { ?> <td align='' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $data2->UniteStockage; ?></td><?php //} ?>
												<?php
													//echo " 	";

													$composition = explode("|",($data['composition']));
													 for($j=0;$j<count($composition);$j++)
													 { $composition2 = explode(";",($composition[$j]));
														if((isset($composition2[0]) && ($composition2[0]==$data2->Num2)))
																 {
																	 if(isset($composition2[1])) $QteCde=$composition2[1];
																 }
													}
													 ?>
													 <td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> <?php if(isset($QteCde)) echo $QteCde*4; else echo 0; ?></td>
													 <td align='center' style='border-top: 2px solid #ffffff'>
														 <input
													<?php
												 	 if(isset($_GET['ListeProduits'])&& ($_GET['produit']==$data2->Num2)){ echo "autofocus";?>
													 onblur="document.forms['chgdept'].submit();" <?php } else echo " readonly";  ?>
													 <?php if(isset($QteCde)&&($QteCde>0)) {echo "placeholder='"; echo $QteCde; echo "'"; }?>
													 value='<?php if(isset($QteCde)&&($QteCde>0)) { if(isset($_GET['aj']) && ($_GET['aj']==$data['numero'])) echo $QteCde; } ?>'
													 type='text' name='choix1[]' style='width:50px;<?php if(isset($_GET['aj']) && ($_GET['aj']==$data['numero'])) { }
														else echo "background-color:#E1E6FA;" ?>text-align:center;border-radius: 5px;-moz-border-radius: 5px;-webkit-border-radius: 5px;border:1px solid red;'  maxlength='3' onkeypress='testChiffres(event);'/>

													<?php echo "&nbsp;&nbsp;<a class='";
													if(isset($plat)&&!empty($plat)) echo "info2"; else echo "info";
													echo "' ";?>

													<?php echo "href='EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&ListeProduits=".$data['ListeProduits']."&produit=".$data2->Num2."&famille=".$famille; if(isset($_GET['plat'])) echo "&plat=".$_GET['plat']; else echo "&plat=".$plat; if(empty($plat)) echo "&fx=1"; echo "' style='color:gray;'>
													&nbsp;&nbsp;<i class='fa fa-plus-square'"; if(isset($QteCde)&&($QteCde>0)) echo "style='color:red;'"; echo "></i><span style='color:gray;font-size:1em;'>";

													if(isset($QteCde)&&($QteCde>0)) {echo "Modifier la quantité"; }
													 else {
														  if(isset($plat)&&!empty($plat))
															echo "Nbre de plats de : <font style='color:maroon;font-weight:bold;'>".$data['designation']."</font><br/>à servir avec un (1) ".$data2->UniteStockage." de : <font style='color:maroon;font-weight:bold;'>".$data2->Designation."</font>";
															else
															echo "Sélectionner d'abord <br/>le plat concerné";
													 }
													 echo "</span></a>
													</td>";
													echo " 	</tr> ";
											}$QteCde=0;
						}
					}
		}
					?>
					</form>
					 <tr><td colspan='13' ><br/> <span style='float:left;font-family:Cambria;font-size:1em;margin-bottom:5px;color:#4C767A;'>1/4 plat (repas) -> 1 Unité &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1/2 plat (repas) -> 2 Unités &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 plat (repas) complet -> 4 Unités</span></td></tr>
				</table>


			</div>
<?php }
else if(isset($_GET['mail']))
	{ 		echo "<script language='javascript'>";
				if(isset($_GET['email'])) echo "var email = '".$_GET['email']."';";
				echo "var id_param = '".$_GET['mail']."';";
				echo 'swal("Confirmation de l\'adresse électronique du Fournisseur", {
					  content: {
					  element: "input",
					  attributes: {
						value : ""+email,
					  },
					  },
					  })
						.then((value) => {
						  document.location.href="EstimPortion.php?menuParent='.$_SESSION['menuParenT'].'&Cde=1&mail="+id_param+"&email1="+email+"&email2="+value;
						}); ';

				echo "</script>";

		if(isset($_GET['email1'])||(isset($_GET['email2']))){
				$id_param = $_GET['mail']; $email = isset($_GET['email2'])?$_GET['email2']:$_GET['email1'];
			   	function create_my_pdf_data($id_param) {
				ob_start();
				include_once('purchaseOrder.php');
				//return $pdf->Output('Facture', 'S');
				}
				require_once 'vendor/vendor/autoload.php'; require_once 'credential.php';
					 $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
			        ->setUsername(EMAIL)
			        ->setPassword(PASSWORD)
			        ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));  //https://bugsdb.com/_en/debug/093fcffa336b6d9fe5a9dabdc90d712f
					$mailer = new Swift_Mailer($transport);
					$message = (new Swift_Message('Bon de Commande'))
				  ->setFrom([EMAIL => 'Entreprise '.$nomHotel])
				  ->setTo([EMAIL, 'akpovo@yopmail.com' => 'Palagradi'])
				  ->setBody('Bonjour Madame, Monsieur, <br/><br/>Par la présente, nous vous confirmons vouloir commander les articles qui figurent sur le présent bon de commande. Nous vous réglerons cette commande à la livraison des produits et à réception de facture.
					<br/>Tout en vous en souhaitant une bonne réception, nous vous adressons nos meilleures salutations.');

					$data = create_my_pdf_data($id_param);

					$attachment = new Swift_Attachment($data,'BonDeCommande.pdf', 'application/pdf');
					$message->attach($attachment);
					if (!$mailer->send($message)) {
					  echo 'Erreur ';

					} else {
						//echo 'email sent successfully';
						echo "<script language='javascript'>";
						echo 'alertify.success("Le mail est envoyé avec succès.");';
						echo "</script>";
						echo '<meta http-equiv="refresh" content="1; url=EstimPortion.php?menuParent='.$_SESSION['menuParenT'].'&Cde=1" />';
					}
				}

	//	}
/* 		if(!isset($_GET['email2'])&& ($_GET['email2']=='null')){
			echo "<script language='javascript'>";
			echo 'alertify.error("Echec d\'envoi du mail");';
			echo "</script>";
		} */
	} else if(isset($_GET['id_param'])){
		echo "<div style='margin : 0 auto;' >
		<iframe align='center' src='purchaseOrder.php"; echo "?id_param=".$_GET['id_param']; echo "' width='1000' height='800' ></iframe>
		</div>";
	}
else {
				if($date==$Jour_actuel)	$date=$Jour_actuel;
				$idr2 = isset($_POST['ladate'])?$_POST['ladate']:$date;

				if(isset($_GET['update'])) {
					//echo $_GET['update'];
				}
				if(isset($_GET['delete'])) {
					//echo $_GET['delete'];
				}

				?>
 <form action="EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['upd'])) echo "&upd=".$_GET['upd']; if(isset($_GET['upd'])) echo "&upd=".$_GET['upd'];?>&Cde=1" method="POST" id="chgdept" name=''>
		<table align="center" width="950" border="0" cellspacing="0" style="">
		<tr><td align='center'><hr style='width:100%'/></td> </tr>
			<tr><td align='left'> <span style="font-family:Cambria;font-weight:bold;font-size:1.5em;color:maroon;" >Liste des bons de Commande
		<span style='color:black;font-size:0.7em;font-weight:normal;'>
		<?php
		if(!isset($_GET['state'])){
		echo "&nbsp;&nbsp;&nbsp;&nbsp;<span style='font-size:1.1em;color:teal;font-style:italic;font-weight:bold;'>[".substr($idr2,8,2).'-'.substr($idr2,5,2).'-'.substr($idr2,0,4)."]</span>";
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a class='info2'  href="EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&state=1&Cde=1" onMouseOver="window.status='Date Picker';return true;" onMouseOut="window.status='';return true;">
		<img src="logo/cal.gif" style="border:1px solid #ffebcd;" alt="Calendrier" title=""><span style='font-size:0.8em;color:maroon;'>Calendrier</span></a>
		<?php }else {
		?>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	 <input required type='date' name='ladate' id='' style='border-radius: 15px;margin-bottom:2px;' onchange="document.forms['chgdept'].submit();">
		<?php } ?>

		</span>
		</span>	</td> </tr><tr><td align='center'><hr style='width:100%;margin-bottom:-15px;'/></td> </tr>
		</table><br/>
</form>
		<?php
				  mysqli_query($con,"SET NAMES 'utf8'");
					$rz="SELECT DISTINCT boncommande.NumFrs AS NumFrs,RaisonSociale,email FROM boncommande,fournisseurs WHERE boncommande.NumFrs=fournisseurs.NumFrs AND Date ='".$idr2."'";
					$req=mysqli_query($con,$rz); //$Liste = array(); $i=0;//$j=0;
					while($dataT=mysqli_fetch_array($req))
					{	$id_param=$idr2."_".$dataT['NumFrs'];$email=$dataT['email'];
						//$i++; //$j++;
						//$Liste[$i]=$dataT['RaisonSociale'];
					?>
				<table align="center" width="950" border="0" cellspacing="0" style="margin-top:10px;border-collapse: collapse;font-family:Cambria;">
				<tr><td colspan='6' >
					<span style="float:right;font-size:1.1em;" >
					 <form action="EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; if(isset($_GET['upd'])) echo "&upd=".$_GET['upd']; if(isset($_GET['upd'])) echo "&upd=".$_GET['upd'];?>&Cde=1" method="POST" id="chgdept" name=''>

					</span>
					<span style="float:right;" >

					</span>

					</td></tr>
					<?php
					//if(!isset($_GET['state']))
					//{ if(!isset($_GET['upd'])){
						echo "<tr><td align='left' colspan='6'><span style='font-size:1.1em;color:maroon;'>Fournisseur : "
							.$dataT['RaisonSociale'].
							"</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span style='display:block;float:right;font-weight:normal;margin-bottom:5px;'>
							<a href='EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&Cde=1&id_param=".$id_param."' class='info1' style='text-decoration:none;'>
							<span style='font-weight:normal;color:black;font-size:0.8em;'>Imprimer</span><img src='logo/pdf_small.gif'/>
							<a/>";
							echo "<a class='info2' href='EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&Cde=1&mail=".$id_param."&email=".$email."'>
							&nbsp;&nbsp;<img src='logo/mail.png' alt='' title='' width='23' height='23' border='0' style='margin-bottom:-3px;'><span style='font-size:0.9em;'>Envoyer par mail</span></a>
							</span></td></tr>";
					?>
					<!-- <a class='info' href='EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&upd=1&Cde=1'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a class='info' href='EstimPortion.php?menuParent=<?php echo $_SESSION['menuParenT']; ?>&upd=1&Cde=1'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='font-size:0.8em;color:red;'>Supprimer</span></a>
					!-->
					<?php //}

					//}
					//else  {
						?>

					<?php //}
					?>


					<tr style=" background-color:silver;color:black;font-size:1.1em; ">
						<td style="border: 2px solid #ffebcd" align="center" >N°</td>
						<td style="border: 2px solid #ffebcd" align="center" >Désignation</td>
						<td style="border: 2px solid #ffebcd" align="center" >Qté Stock</td>
						<td style="border: 2px solid #ffebcd" align="center" >Prix de Livraison</td>
						<td style="border: 2px solid #ffebcd" align="center" >Qté commandée</td>
						<td style="border: 2px solid #ffebcd" align="center" >Actions</td>
					</tr>
					<?php
					   $query_Recordset1 = "SELECT DISTINCT produits.Designation AS designation,Qte_Stock,PrixFrs,RaisonSociale,boncommande.QteCde AS QteCde,boncommande.Date,boncommande.NumFrs,fournisseurs.Email AS email FROM produits,fournisseurs,boncommande WHERE boncommande.NumPro=produits.Num AND fournisseurs.NumFrs=produits.Fournisseur AND produits.Type='".$_SESSION['menuParenT1']."' AND boncommande.NumFrs='".$dataT['NumFrs']."' AND Date ='".$idr2."'";
					   $Recordset_2 = mysqli_query($con,$query_Recordset1);
							$cpteur=1;$dataT=""; $j=0;
							while($data=mysqli_fetch_array($Recordset_2))
							{  $j++;
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

								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$j.".</td>";
								echo " 	<td align='' style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>&nbsp;".$data['designation']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['Qte_Stock']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['PrixFrs']."</td>";
								echo " 	<td align='center'style='border-right: 2px solid #ffebcd; border-top: 2px solid #ffebcd;'>".$data['QteCde']."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffebcd;border-top: 2px solid #ffebcd;'>";
									//if(!isset($_GET['upd'])){		}	else{		}
									echo " &nbsp;<a class='info' href='EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&update=".$id_param."&Cde=1'><img src='logo/b_edit.png' alt='' width='16' height='16' border='0'><span style='font-size:0.8em;'>Modifier</span></a>";
									echo " 	&nbsp;&nbsp;&nbsp;&nbsp;";
									echo " 	<a class='info2' href='EstimPortion.php?menuParent=".$_SESSION['menuParenT']."&delete=".$id_param."&Cde=1'><img src='logo/b_drop.png' alt='Supprimer' width='16' height='16' border='0'><span style='font-size:0.8em;color:red;'>Supprimer</span></a>";
									echo " 	</td>";
									echo " 	</tr> ";
							}
						 echo "<tr></tr>
						</table>";
						}
					?>


			<?php }
			?>
	</body>
</html>
