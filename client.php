<?php
	include_once'menu.php';
	if(!empty($_GET['etat']))
	$return=1; //echo substr(getURI_(),24,-1);

	$groupe=!empty($_GET['groupe'])?$_GET['groupe']:NULL;
	$etat=!empty($_GET['etat'])?$_GET['etat']:NULL;
	$sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
	$fiche1=!empty($_GET['fiche'])?$_GET['fiche']:NULL;
	$fiche2=!empty($_GET['fiche2'])?$_GET['fiche2']:NULL;
	$numresch=!empty($_GET['numresch'])?$_GET['numresch']:NULL;
	if($groupe==1)
	$fiche="fiche_groupe2.php";
	if($etat==1)
		{if($fiche1==1)
			$fiche="fiche.php";
		 if($fiche2==1)
			$fiche="fiche2.php";
		}
	if($sal==1) $fiche="FicheS.php";
	$nom=!empty($_GET['name'])?$_GET['name']:NULL;
	$prenoms= !empty($_GET['surname'])?$_GET['surname']:NULL;
	$contact= !empty($_GET['address'])?$_GET['address']:NULL;

//Titre : Calcul l'age à partir d'une date de naissance
// 	function age($date) {
// 			 $age = date('Y') - $date;
// 			if (date('md') < date('md', strtotime($date))) {
// 					return $age - 1;
// 			}
// 			return $age;
// 	}
//
// echo age('1988-07-08');


//enregistrement
	if (isset($_POST['ok'])&& $_POST['ok']=='VALIDER')
		{  //echo $return;
			if ((isset($_POST['edit1']) && !empty($_POST['edit1'])) and (isset($_POST['edit2']) && !empty($_POST['edit2'])) and (isset($_POST['edit3']) &&!empty($_POST['edit3']))and
			(isset($_POST['edit4']) && !empty($_POST['edit4']))and (isset($_POST['edit5']) && $_POST['edit5']!='') and (isset($_POST['combo0']) && $_POST['combo0']!='')
			AND (isset($_POST['edit_13']) && !empty($_POST['edit_13']))AND (isset($_POST['edit_15']) && !empty($_POST['edit_15']))AND (isset($_POST['edit_16']) && !empty($_POST['edit_16']))
			AND (isset($_POST['ladate']) && !empty($_POST['ladate']))AND (isset($_POST['ladate2']) && !empty($_POST['ladate2']))AND (isset($_POST['edit_4']) && !empty($_POST['edit_4'])))
				{	$lieu=$_POST['edit4'];$lieu=addslashes($lieu);
					$num=$_POST['edit1'];$num=addslashes($num);
					$num=trim($num);
					$nom=$_POST['edit2'];$nom=addslashes($nom);//$nom= strtoupper($nom);
					$prenom=$_POST['edit3'];$prenom=addslashes($prenom);$prenom= ucfirst($prenom);
					$a=$_POST['edit_15'];$a=addslashes($a);
					$par=$_POST['edit_16'];$par=addslashes($par);
					$continent=$_POST['edit_5'];$continent=addslashes($continent);
					$adresse=$_POST['edit_4'];$adresse=addslashes($adresse);//$adresse=utf8_encode($adresse);

					$dateNaissance = isset($_POST['ladate'])?$_POST['ladate']:NULL;
					$dateDelivrance = isset($_POST['ladate2'])?$_POST['ladate2']:NULL;
					$dateExpiration = isset($_POST['Expire'])?$_POST['Expire']:NULL;
					$aujourdhui= $Jour_actuel ; // $aujourdhui = date("Y-m-d");
					$diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
					$ageClient=$diff->format('%y'); //Pour connaitre l'âge du client

					$sql="SELECT DATEDIFF('".$dateDelivrance."','".$aujourdhui."') AS DiffDate";$exec=mysqli_query($con,$sql);
					$row_Recordset1 = mysqli_fetch_assoc($exec);	 $Delivrance=$row_Recordset1['DiffDate'];  //Pour Vérifier si la date de délivrance est valide

					$sql="SELECT DATEDIFF('".$dateExpiration."','".$aujourdhui."') AS DiffDate";$exec=mysqli_query($con,$sql);
					$row_Recordset1 = mysqli_fetch_assoc($exec);	 $Expire=$row_Recordset1['DiffDate']; //Pour Vérifier si la date de d'expiration est valide

					mysqli_query($con,"SET NAMES 'utf8' ");
					$req=mysqli_query($con,"SELECT * FROM client WHERE numcli='".$_POST['edit1']."'");
					$reqi=mysqli_fetch_array($req);

					if($reqi)
					{
							echo "<script language='javascript'>";
							//echo " alert('Ce Numéro client existe déja.');";
							echo 'alertify.error("Ce Numéro client existe déja !");';
							echo "</script>";
					} else
					{
					$req1=mysqli_query($con,"SELECT * FROM client WHERE nomcli LIKE '$nom' AND prenomcli LIKE '$prenom'");
					$req2=mysqli_fetch_array($req1);

					if($req2)
					{
							echo "<script language='javascript'>";
							//echo " alert('Un client du m&egrave;me nom existe déja. Entrez un nouveau nom');";
							echo 'alertify.error("Un client du même nom existe déja !");';
							echo "</script>";
							//$msg="Un client du m&egrave;me <span style='color:red;'>Nom</span> existe déja. Faites un autre enregistrement";


					}else if($ageClient<18){
						echo "<script language='javascript'>";
						echo 'alertify.error("Désolé ! Le client n\'a pas encore atteint l\'âge de la majorité. ");';
						echo "</script>";
					}	else if($Delivrance>=1){
						echo "<script language='javascript'>";
						echo 'alertify.error("Désolé ! La date de délivrance de la pièce n\'est pas correcte.");';
						echo "</script>";
					}	else if(($Expire<1)&&($Expire!=0)){
						echo "<script language='javascript'>";
						echo 'alertify.error("Désolé ! La pièce présentée par le client est déja expirée.");';
						echo "</script>";
					}	else{

						// $reqse2=mysqli_query($con,"SELECT  DATEDIFF('".$Jour_actuel."',$_POST['ladate']) AS DiffDate ");
						// $data2=mysqli_fetch_assoc($reqse2);
						// echo $difference = $data2['DiffDate'];


					//$pays=$_POST['edit5'];$pays=addslashes($pays);
					$combo3=isset($_POST['combo3'])?$_POST['combo3']:NULL;					$combo2=isset($_POST['combo2'])?$_POST['combo2']:NULL;
					$combo1=isset($_POST['combo1'])?$_POST['combo1']:NULL;					$datnaiss=$combo3.'-'.$combo2.'-'.$combo1;

					$Tel=isset($_POST['tel'])?$_POST['tel']:0; $Email=isset($_POST['Email'])?$_POST['Email']:NULL;

					$NumIFU=isset($_POST['NumIFU'])?$_POST['NumIFU']:0;  $Expire=isset($_POST['Expire'])?$_POST['Expire']:NULL;
					if(empty($_POST['NumIFU'])) $NumIFU=0;

					$edit5=$_POST['edit5'];$edit_5=$_POST['edit_5'];
					mysqli_query($con,"SET NAMES 'utf8' ");
					$sql1 = mysqli_query($con,"SELECT continent FROM  continent WHERE id_continent='$continent'");
					$data =mysqli_fetch_assoc($sql1); $continent=$data['continent'];$continent=addslashes($continent);

					$sql2 = mysqli_query($con,"SELECT pays FROM  pays2 WHERE id_pays='$edit5' ");
					$data =mysqli_fetch_assoc($sql2);  $pays=$data['pays'];$pays=addslashes($pays);//$categorie="ordinaire";

						mysqli_query($con,"SET NAMES 'utf8' ");
						$ret="INSERT INTO client VALUES('$num','".$NumIFU."','$nom','$prenom','".$_POST['combo0']."','".$_POST['ladate']."','$lieu','".$_POST['sel1']."','".addslashes($_POST['edit_13'])."','".$_POST['ladate2']."','$a','$par','".$Expire."','$pays','$adresse','".$Tel."','".$Email."','$continent','$categorie','')";
						$req=mysqli_query($con,$ret);
						if ($req)
							{	$ret="INSERT INTO view_client VALUES('$num','".$NumIFU."','$nom','$prenom','".$_POST['combo0']."','".$_POST['ladate']."','$lieu','".$_POST['sel1']."','".addslashes($_POST['edit_13'])."','".$_POST['ladate2']."','$a','$par','".$Expire."','$pays','$adresse','".$Tel."','".$Email."','$continent','$categorie','')";
								$req=mysqli_query($con,$ret);
								$update=mysqli_query($con,"UPDATE configuration_facture SET num_client=num_client+1");
								echo "<script language='javascript'>";
								//echo " alert('Ce Client a été enrégistré avec succès');";
								echo 'alertify.success(" Client enrégistré avec succès !");';
								echo "</script>"; 	$nom="";$edit2="";
								if($_POST['edit70']==1) {
								$_SESSION['numcli']=$_POST['edit1'];$_SESSION['nomcli']=$_POST['edit2'];$_SESSION['prenomcli']=$_POST['edit3'];	$_SESSION['datenais']=$_POST['ladate'];
								$_SESSION['lieu']=$_POST['edit4'];$_SESSION['pays']=stripslashes($pays);$_SESSION['sexe']=$_POST['combo0'];	$_SESSION['piece']=$_POST['sel1'];
								$_SESSION['numpiece']=$_POST['edit_13'];$_SESSION['le']=$_POST['ladate2'];$_SESSION['a']=$_POST['edit_15'];	$_SESSION['par']=$_POST['edit_16'];
								$_SESSION['contact']=$_POST['tel'];
								//redirect_to("fiche.php");
								header('location:fiche.php?'.substr(getURI_(),24,-1));
								
/* 								if(isset($_SESSION['numreserv']))
									header('location:fiche.php?menuParent=Fichier&numreserv='.$_SESSION['numreserv']);
								else
									header('location:fiche.php?menuParent=Fichier');
*/								
								} 

								if($_POST['edit70']==2) {
								$_SESSION['numcli']=$_POST['edit1'];								$_SESSION['nomcli']=$_POST['edit2'];
								$_SESSION['prenomcli']=$_POST['edit3'];								$_SESSION['datenais']=$_POST['ladate'];
								$_SESSION['lieu']=$_POST['edit4'];								$_SESSION['pays']=stripslashes($pays);
								$_SESSION['sexe']=isset($_POST['combo0'])?$_POST['combo0']:NULL;
								$_SESSION['piece']=$_POST['sel1'];								$_SESSION['numpiece']=$_POST['edit_13'];
								$_SESSION['le']=$_POST['ladate2'];								$_SESSION['a']=$_POST['edit_15'];
								$_SESSION['par']=$_POST['edit_16'];							$_SESSION['contact']=$_POST['tel'];
								//redirect_to("fiche_groupe2.php");
								header('location:fiche_groupe2.php?menuParent=Fichier');
								}

/* 								if($_POST['edit70']==3) {
								$_SESSION['numcli']=$_POST['edit1'];							$_SESSION['nomcli']=$_POST['edit2'];
								$_SESSION['prenomcli']=$_POST['edit3'];							$_SESSION['datenais']=$_POST['ladate'];
								$_SESSION['lieu']=$_POST['edit4'];								$_SESSION['pays']=$_POST['edit5'];
								$_SESSION['sexe']=$_POST['combo0'];								$_SESSION['piece']=$_POST['sel1'];
								$_SESSION['numpiece']=$_POST['edit_13'];						$_SESSION['le']=$_POST['ladate2'];
								$_SESSION['a']=$_POST['edit_15'];								$_SESSION['par']=$_POST['edit_16'];	$_SESSION['contact']=$_POST['edit_4'];
								//redirect_to("info_reservation.php");
								header('location:info_reservation.php?menuParent=Fichier');} */

								if($_POST['edit70']==4) {
								$_SESSION['numcli']=$_POST['edit1'];							$_SESSION['nomcli']=$_POST['edit2'];
								$_SESSION['prenomcli']=$_POST['edit3'];							$_SESSION['datenais']=$_POST['ladate'];
								$_SESSION['lieu']=$_POST['edit4'];								$_SESSION['pays']=$_POST['edit5'];
								$_SESSION['sexe']=$_POST['combo0'];								$_SESSION['piece']=$_POST['sel1'];
								$_SESSION['numpiece']=$_POST['edit_13'];						$_SESSION['le']=$_POST['ladate2'];
								$_SESSION['a']=$_POST['edit_15'];								$_SESSION['par']=$_POST['edit_16'];	$_SESSION['contact']=$_POST['tel'];
								header('location:FicheS.php?menuParent=Location');}


								else
								{	if($_POST['fiche2']==1) {
									$_SESSION['numcli']=$_POST['edit1'];								$_SESSION['nomcli']=$_POST['edit2'];
									$_SESSION['prenomcli']=$_POST['edit3'];								$_SESSION['ladate']=$_POST['ladate'];
									$_SESSION['lieu']=$_POST['edit4'];									$_SESSION['pays']=stripslashes($pays);
									$_SESSION['sexe']=$_POST['combo0'];									$_SESSION['piece']=$_POST['sel1'];
									$_SESSION['numpiece']=$_POST['edit_13'];							$_SESSION['le']=$_POST['ladate2'];
									$_SESSION['a']=$_POST['edit_15'];									$_SESSION['par']=$_POST['edit_16'];		$_SESSION['contact']=$_POST['tel'];
									header('location:fiche2.php');}


									else echo '<meta http-equiv="refresh" content="1; url=client.php?menuParent=Fichier" />';
								}

							}
							else
							{
								echo "<script language='javascript'>";
								//echo " alert('Echec d'enregistrement');";
								echo 'alertify.error("Echec de l\'enregistrement !");';
								echo "</script>";
							}
						}
					}
				}
				else
				{
					echo "<script language='javascript'>";
					//echo " alert('Les champs en couleur sont vides');";
					echo 'alertify.error("Les champs en couleur sont vides !");';
					echo "</script>";
					if($_POST['edit2']=='') $etat_1=1; else $edit2=$_POST['edit2'];	if($_POST['edit3']=='') $etat1=1; else $edit3=$_POST['edit3'];if($_POST['edit4']=='') $etat2=1; else $edit4=$_POST['edit4'];
					if($_POST['edit_13']=='') $etat_13=1; else $edit_13=$_POST['edit_13'];if($_POST['ladate']=='') $etat4=1; else $ladate=$_POST['ladate'];	if($_POST['ladate2']=='') $etat5=1; else $ladate2=$_POST['ladate2'];
					if($_POST['edit_15']=='') $etat_5=1; else $edit_15=$_POST['edit_15'];if($_POST['edit_16']=='') $etat_6=1; else $edit_16=$_POST['edit_16'];if($_POST['combo0']=='') $etat_7=1; else $combo0=$_POST['combo0'];
					if($_POST['edit5']=='') $etat_8=1; else $edit5=$_POST['edit5'];	if($_POST['sel1']=='') $etat_9=1; else $sel1=$_POST['sel1'];if($_POST['edit_4']=='') $etat_90=1; else $edit_4=$_POST['edit_4'];
				}
		}

//http://forum.phpfrance.com/faq-tutoriels/formulaires-listes-deroulantes-dynamiques-liees-t4562.html
$idr = isset($_POST['edit_5'])?$_POST['edit_5']:null;$edit2 = isset($_POST['edit2'])?$_POST['edit2']:null;$edit3=isset($_POST['edit3'])?$_POST['edit3']:null;
$edit4=isset($_POST['edit4'])?$_POST['edit4']:null;$edit_13=isset($_POST['edit_13'])?$_POST['edit_13']:null;$ladate=isset($_POST['ladate'])?$_POST['ladate']:null;
$ladate2=isset($_POST['ladate2'])?$_POST['ladate2']:null;$edit_15=isset($_POST['edit_15'])?$_POST['edit_15']:null;$edit_16=isset($_POST['edit_16'])?$_POST['edit_16']:null;
$combo0=isset($_POST['combo0'])?$_POST['combo0']:null;$edit5=isset($_POST['edit5'])?$_POST['edit5']:null;$sel1=isset($_POST['sel1'])?$_POST['sel1']:null;
$edit_4=isset($_POST['edit_4'])?$_POST['edit_4']:null;
$edit70=isset($_POST['edit70'])?$_POST['edit70']:null;$fiche2=isset($_POST['fiche2'])?$_POST['fiche2']:null;$tel=isset($_POST['tel'])?$_POST['tel']:null;$Email=isset($_POST['Email'])?$_POST['Email']:null;
$NumIFU = isset($_POST['NumIFU'])?$_POST['NumIFU']:null;  $Expire = isset($_POST['Expire'])?$_POST['Expire']:null;
//$fiche2 $edit70 $return $groupe $numresch $sal $_GET['fiche2']
$sal=isset($_POST['sal'])?$_POST['sal']:null;$return=isset($_POST['return'])?$_POST['return']:null;
$groupe=isset($_POST['groupe'])?$_POST['groupe']:null; $numresch=isset($_POST['numresch'])?$_POST['numresch']:null;


/* if(isset($_POST['ok']) && isset($_POST['edit5']) && $_POST['edit5'] != "")
	{	$continent_selectionnee = $_POST['edit_5'];
		$dept_selectionne = $_POST['edit5'];
	} */
	mysqli_query($con,"SET NAMES 'utf8' ");
    $sql1 = "SELECT `id_continent`, `continent`".
    " FROM `continent`".
    " ORDER BY `id_continent`";
    $rech_continents = mysqli_query($con,$sql1);
    $code_continent = array();
    $continent = array();
    /* On active un compteur pour les régions */
    $nb_continents = 0;
    if($rech_continents != false)
    {
        while($ligne = mysqli_fetch_assoc($rech_continents))
        {
            array_push($code_continent, $ligne['id_continent']);
            array_push($continent, $ligne['continent']);

            /* On incrémente de compteur */
            $nb_continents++;
        }
    }

?>
<html>
	<head>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
		<link rel="Stylesheet" href='css/table.css' />
		<meta name="viewport" content="width=device-width">
		<style>
			.alertify-log-custom {
				background: blue;
			}
			td {
			  padding: 8px 0;
			}
		</style>
	</head>
	<body bgcolor='azure' style="">
	<div align="" style="" >
	<table align='center'  id="tab" >
		<tr>
			<td>
				<fieldset  style='margin-left:auto; margin-right:auto;border:0px solid white;background-color:#D0DCE0;font-family:Cambria;width:800px;'>
						<legend align='center' style='font-size:1.3em;color:#3EB27B;'>	<h3 style="text-align:center; font-family:Cambria;color:maroon;font-weight:bold;"></h3></legend>

							<h3 style='text-align:center; font-family:Cambria;color:maroon;font-weight:bold;'>ENREGISTREMENT DES CLIENTS</h3><br/>
							<!-- <span style='font-style:italic;font-size:0.8em;color:#d10808;'> Tous les champs sont obligatoires </span>  !-->
						<form action="<?php echo getURI_();
						//echo "?menuParent=Hébergement"; if(isset($etat)) echo "&etat=1"; if(isset($fiche)) echo "&fiche=1"; ?>"  method="post" id="chgdept">
							<table style='float:left;margin-left:60px;'>
								<tr>
									<td colspan="3"  > N° d'enrég. : </td>
									<td colspan="" >
									<?php
										if(($num_client>=0)&&($num_client<=9)) $num_client="CL000".$num_client ;
										if(($num_client>=10)&&($num_client <=99)) $num_client="CL00".$num_client ;
										if(($num_client>=100)&&($num_client <1000)) $num_client="CL0".$num_client ;
										if($num_client>=1000) $num_client="CL".$num_client ;
										echo " <input type='text' name='edit1'  readonly size='26' value='".$num_client."'/>";
									?>
									</td>
								</tr>
								<tr>
									<td colspan="3"  > Numéro IFU : </td>
									<td colspan="" >
									 <input type='text' name='NumIFU' maxlength='13' onkeypress='testChiffres(event);' value='<?php  if(isset($NumIFU)) echo $NumIFU; ?>'/>

									</td>
								</tr>
								<tr>
									<td colspan="3" style=""> Nom : </td> <?php $etat_1=!empty($etat_1)?$etat_1:NULL;  $etat1=!empty($etat1)?$etat1:NULL; $etat4=!empty($etat4)?$etat4:NULL; $etat2=!empty($etat2)?$etat2:NULL;
									$etat_90=!empty($etat_90)?$etat_90:NULL; $etat_8=!empty($etat_8)?$etat_8:NULL;$etat_9=!empty($etat_9)?$etat_9:NULL;$etat_13=!empty($etat_13)?$etat_13:NULL;$etat_5=!empty($etat_5)?$etat_5:NULL;
									$etat5=!empty($etat5)?$etat5:NULL;$etat_6=!empty($etat_6)?$etat_6:NULL;$etat_2=!empty($etat_2)?$etat_2:NULL; $etat_7=!empty($etat_7)?$etat_7:NULL;?>
									<td colspan="" style=''> <input required='required' type='text' name='edit2' id='edit2' size="26" maxlength="50" value="<?php  if(isset($nom)) echo $nom; else if($etat_1!=1) echo $edit2; else { }?>" style='<?php if($etat_1==1) echo"background-color:#FDF1B8";?>' onkeyup='this.value=this.value.toUpperCase()'/> </td>
								</tr>
								<input type='hidden' name='edit70' 	value="<?php
								if(!empty($edit70)) echo $edit70;
								else if(!empty($_GET['etat'])) echo $_GET['etat']; else if(!empty($_GET['groupe']))
								echo 2;	else if(!empty($numresch)) echo 3; else if(!empty($_GET['sal'])) echo 4; else {}?>"	readonly size="26" />
								<tr><input type='hidden' name='fiche2' value="<?php if($fiche2!='') echo $fiche2; else echo isset($_GET['fiche2'])?$_GET['fiche2']:null;?>" readonly size="26"/>
									<td colspan="3" style="" >  Prénoms : </td>
									<td> <input required='required'type='text' name='edit3'size="26" maxlength="50" value="<?php if(isset($prenoms)) echo $prenoms; else if($etat1!=1) echo $edit3; else { }?>" style='<?php if($etat1==1)echo"background-color:#FDF1B8";?>' onKeyup="ucfirst(this)"/></td>
								</tr>
								<tr>
								<td colspan="3" style="" >  Date de Naissance : </td>
								<td style=" border: 0px solid black;"> <input required='required' type="date" name="ladate" style='width:210px;' id="" size="26" value="<?php if($etat4!=1) echo $ladate;?>" style='<?php if($etat4==1)echo"background-color:#FDF1B8";?>'/>
								</td>
								</tr>
								<tr> <td colspan="3" style="" >  Sexe : </td>
									<td>
										<select required='required' name='combo0' style='width:210px;font-size:0.9em;<?php if($etat_7==1)echo"background-color:#FDF1B8";?>'>
											<option value='<?php if($etat_7!=1) echo $combo0;?>'> <?php if(isset($combo0)&&($combo0=='F')) echo "Féminin"; else if(isset($combo0)&&($combo0=='M')) echo "Masculin";  else echo " "; ?></option>
											<option value='F'> Féminin </option>
											<option value=''>  </option>
											<option value='M'> Masculin </option>
										</select>
									</td>
							 </tr>
								<tr>
									<td colspan="3" style="" > Lieu de naissance : </td>
									<td> <input required='required' type='text' name='edit4'size="26"  value="<?php if($etat2!=1) echo $edit4;?>" style='<?php if($etat2==1)echo"background-color:#FDF1B8";?>' onKeyup="ucfirst(this)"/> </td>
								</tr>
								<tr>
									<td colspan="3" style="" > Adresse : </td>
									<td> <input required='required' type='text' autocomplete='OFF' name='edit_4'size="26" value="<?php if($etat_2!=1) echo $edit_4; else { }?>" style='<?php if($etat_90==1)echo"background-color:#FDF1B8";?>' /> </td>
								</tr>

								<tr>
									<td colspan="3" style="" > Téléphone : </td>
									<td> <input type='text' name='tel' size="26" required value="<?php if(isset($tel)) echo $tel; else if(isset($contact)) echo $contact; else { } //if($etat_2!=1) echo $tel;?>" style='<?php if($etat_90==1)echo"background-color:#FDF1B8";?>' onkeypress='testChiffres(event);'/> </td>
								</tr>
							</tr>
							</table>
							<table style=''>
								<tr>
									<td colspan="3" style="" > &nbsp;&nbsp;&nbsp;&nbsp;Continent : </td>
									<td>
										<select required='required' name="edit_5" style='width:210px;font-size:0.9em;<?php if($etat_8==1)echo"background-color:#FDF1B8";?>' onblur="Aff();" id="continent" onchange="document.forms['chgdept'].submit();">
										  <option value="-1"></option>
											<?php
											for($i = 0; $i < $nb_continents; $i++)
											{
										?>
										  <option value="<?php echo($code_continent[$i]); ?>"<?php echo((isset($idr) && $idr == $code_continent[$i])?" selected=\"selected\"":null); ?>><?php echo($continent[$i]); ?></option>
										  <option value=''>  </option>
										<?php
											}
											?>
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="3" style="" > &nbsp;&nbsp;&nbsp;&nbsp;Pays d'origine : </td>
									<td>
									<select required='required' name="edit5" id="pays" style='width:210px;font-size:0.9em;<?php if($etat_8==1)echo"background-color:#FDF1B8";?>'>
									<option value=''></option>
										<?php
										mysqli_free_result($rech_continents);
										/* On commence par vérifier si on a envoyé un numéro de région et le cas échéant s'il est différent de -1 */

										if(isset($idr) && ($idr != -1) && ($idr!='') )
										{	mysqli_query($con,"SET NAMES 'utf8' ");
											/* Cération de la requête pour avoir les départements de cette région */
											$sql2 = "SELECT `id_pays`, `pays`".
											" FROM `pays2`".
											" WHERE `id_continent` = ". $idr ."".
											" ORDER BY `pays` ASC";
											//if($connexion != false)
											//{
												$rech_dept = mysqli_query($con, $sql2);
												/* Un petit compteur pour les départements */
												$nd = 0;
												/* On crée deux tableaux pour les numéros et les noms des départements */
												$code_dept = array();
												$nom_dept = array();
												/* On va mettre les numéros et noms des départements dans les deux tableaux */
												while($ligne_dept = mysqli_fetch_assoc($rech_dept))
												{
													array_push($code_dept, $ligne_dept['id_pays']);
													array_push($nom_dept, $ligne_dept['pays']);
													$nd++;
												}
												/* Maintenant on peut construire la liste déroulante */
												?>

												<?php
												for($d = 0; $d<$nd; $d++)
												{$i=$d+1;
													?>
													<option value="<?php echo($code_dept[$d]); ?>"<?php echo((isset($dept_selectionne) && $dept_selectionne == $code_dept[$d])?" selected=\"selected\"":null); ?>><?php echo($nom_dept[$d]."&nbsp; (". $i .")"); ?></option>
													 <option value=''>  </option>
													<?php
												}
									?>
									</select>
									<?php
											}
											/* Un petit coup de balai */
											//mysqli_free_result($rech_dept);
										//}
									?>

									</td>
								</tr>
											<tr>
													<td colspan="3" style="" >  &nbsp;&nbsp;&nbsp;&nbsp;Type de pièce : </td>
													<td>
														<select required='required' name='sel1' style='width:210px;font-size:0.9em;<?php if($etat_9==1)echo"background-color:#FDF1B8";?>'> >
														<option value='<?php if($etat_9!=1) echo $sel1;?>'> <?php if($etat_9!=1) echo $sel1; else echo " "; ?></option>
															<option value='cin'> Carte d'Idendité Nationale </option>
															<option value=''>  </option>
															<option value='passeport'> Passeport </option>
															<option value=''>  </option>
															<option value='Permis'>Permis de Conduire</option>
															<option value=''>  </option>
															<option value='cartepro'>Carte Professionnele </option>
															<option value=''>  </option>
															<option value='cartepro1'>Autres </option>
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="3" style="" >  &nbsp;&nbsp;&nbsp;&nbsp;Numéro de pièce : </td>
													<td> <input required='required' type='text' name='edit_13'size="26"value="<?php if($etat_13!=1) echo $edit_13;?>" style='<?php if($etat_13==1)echo"background-color:#FDF1B8";?>'/> </td>

												</tr>
												<tr>	<td colspan="3" style="" > &nbsp;&nbsp;&nbsp;&nbsp;Délivrée le : </td>
											<td style=" border: 0px solid black;"> <input required='required' type="date" name="ladate2" id="" size="26"  style='width:210px;' value="<?php if($etat5!=1) echo $ladate2;?>" style='<?php if($etat5==1)echo"background-color:#FDF1B8";?>'  />
											</td>

												</tr>
												<tr>
													<td colspan="3" style="" >  &nbsp;&nbsp;&nbsp;&nbsp;<span style='color:#D0DCE0;'>Délivrée</span> à : </td>
													<td> <input required='required' type='text' name='edit_15'size="26"value="<?php if($etat_5!=1) echo $edit_15;?>" style='<?php if($etat_5==1)echo"background-color:#FDF1B8";?>' onKeyup="ucfirst(this)"/>  </td>
												</tr>
												<tr>
													<td colspan="3" style="" >  &nbsp;&nbsp;&nbsp;&nbsp;<span style=''>Délivrée</span> par : </td>
													<td> <input required='required' type='text' name='edit_16'size="26"value="<?php if($etat_6!=1) echo $edit_16;?>" style='<?php if($etat_6==1)echo"background-color:#FDF1B8";?>' onKeyup="ucfirst(this)"/>  </td>
												</tr>
												<tr>
													<td colspan="3" style="" >  &nbsp;&nbsp;&nbsp;&nbsp;<span style=''>Expire</span> le  : </td>
													<td> <input required='required' type='date' name='Expire' size="26" value="<?php  if(isset($Expire)) echo $Expire; ?>" style='<?php if($etat_6==1)echo"background-color:#FDF1B8";?>' />  </td>
												</tr>
												<tr>
													<td colspan="3" style="" > &nbsp;&nbsp;&nbsp;&nbsp;Adresse Email : </td>
													<td> <input type='email' name='Email'size="26" value="<?php if($Email!='') echo $Email;?>" style='width:210px;height:20px;border :1px solid gray;	border-radius: 4px;	-webkit-box-sizing:border-box;-moz-box-sizing:border-box;
													-mos-box-sizing:border-box;		box-sizing: border-box;		font: 15px "Times New Roman", Times, serif,Georgia;<?php if($etat_90==1) echo"background-color:#FDF1B8";?>' onkeyup='this.value=this.value.toLowerCase()'/> </td>
												</tr>
								<tr>
									<td  colspan="4" align=''> &nbsp; </td>
								</tr>
								<tr>
									<td  align='left'><table align='left' style="clear:both;">
										<tr>
											<td  align='center'><input type='submit' name='ok' value='VALIDER' class='bouton2' style=""/> </td>
										</tr></table>
									</td>
								</tr>
							</table>
								</td>
								</tr>
							</table>
						</div>
						</form>
					</fieldset>


		<?php 			echo "<table align='center' style='border:0px solid black;'> <tr> <td style='font-weight:bold;'></br>

			 </td></tr></table>";

		?>

	<script type="text/javascript">
		//uppercase first letter
			function ucfirst(field) {
				field.value = field.value.substr(0, 1).toUpperCase() + field.value.substr(1);
			}
		function action2(event){
		  var xhr = getXhr();
				xhr.onreadystatechange = function(){
				leselect=xhr.responseText;
					if(xhr.readyState == 4 && xhr.status == 200){
						document.getElementById('edit9').value = leselect;
					}
				}
				xhr.open("POST","pays.php",true);
				xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				sel = document.getElementById('edit6');
				sh2=sel.options[sel.selectedIndex].value;
				sel1 = document.getElementById('ladate');
				sh1=sel1.value;
				sh_1 = document.getElementById('ladate2');
				sh = sh_1.value;
				xhr.send("nom="+sh2+"&date1="+sh1+"&date2="+sh);
				//xhr.send("nom="+sh+"&date="+sh1);
		}
	</script>
	</body>
</html>
