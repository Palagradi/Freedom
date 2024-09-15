<?php
	include_once'menu.php'; 
	$val=!empty($_GET['val'])?$_GET['val']:NULL; $_SESSION['Visualiser']=0; unset($_SESSION['Fusion']);

	$et=!empty($_GET['et'])?$_GET['et']:NULL;//unset($_SESSION['modulo']);
	unset( $_SESSION['remise']); unset($_SESSION['req1']);unset($_SESSION['req2']);unset($_SESSION['retro']);unset($_SESSION['sal']);unset($_SESSION['chambre']);unset($_SESSION['view']);

/* 	$mois=(int)(date('m'));$annee=(int)(date('Y'));$date=date('Y-m-d');
	$reqsel=mysqli_query($con,"SELECT etat FROM payement_loyer  WHERE mois_payement='$mois' AND annee_payement='$annee'");
	$Trouver=mysqli_num_rows($reqsel);
	if($Trouver<=0)
	{  $ret="INSERT INTO payement_loyer VALUES('$date','$mois','$annee','100000','84745.7627','15254.237286','Npaye')";
		$req=mysql_query($ret);
	}



	$mois=(int)(date('m'));$annee=(int)(date('Y'));$date=date('Y-m-d');
	$reqsel=mysqli_query($con,"SELECT etat FROM payement_loyer  WHERE mois_payement='$mois' AND annee_payement='$annee'");
	$Trouver=mysqli_num_rows($reqsel);
	if($Trouver<=0)
	{  $ret="INSERT INTO payement_loyer VALUES('$date','$mois','$annee','100000','84745.7627','15254.237286','Npaye')";
		$req=mysql_query($ret);
	}
	$trouver='NON';
	$reqselP=mysqli_query($con,"SELECT mois_payement,annee_payement  FROM payement_loyer  WHERE Etat='Npaye'");
	$nbre_result=mysqli_num_rows($reqselP);
	if($nbre_result<=0)
		{	$montant_ttc=100000;
			 $montant_ht=84.7458;
			 $montant_tva=$montant_ttc*0.18;
			 $trouver='OUI';
		 }
				 */
				 
	//echo $_SESSION["path"];
	
	$query="DELETE FROM produitsencours  WHERE `Etat` = '4'";
	$res1=mysqli_query($con,$query);

?>
<html>
		<head>
		<script type="text/javascript" src="date-picker.js"></script>
		<script type="text/javascript" src="js/verifyCheckBoxes1.js"></script>
		<script type="text/javascript" src="js/fonctions_utiles.js"></script>
		<link rel="Stylesheet" type="text/css"  href='css/input.css' />
		<link rel="Stylesheet" href='css/table.css' />
		<link rel="Stylesheet" type="text/css"  href='css/input2.css' />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.core.css" />
		<link rel="stylesheet" href="js/alertify.js/themes/alertify.default.css" id="toggleCSS" />
			<style>
			.alertify-log-custom {
				background: blue;
			}
				td {
				  padding: 8px 0;
				}
			</style>
			<script src="js/sweetalert.min.js"></script>
			<script src="js/sweetalert2/sweetalert2@10.js"></script>
			<script src="js/jquery-3.3.1.min.js"></script>
			<script src="js/sweetalert2/sweetalert.min.js"></script>

			<script type="text/javascript" >
					function confirmation1(){
/* 						{ 	alertify.confirm("Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?",function(e){
								if(e) {
								$('#form').submit();
								return true;
							} else {
								return false;
							}

							});
						} */
						
						var confirmed = confirm("Normaliser la facture sans Encaisser. Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?");
						return confirmed;
					}

					function confirmation2(){
						var confirmed = confirm("Encaisser & Normaliser la facture. Veuillez noter que cette action est irréversible. Voulez-vous vraiment continuer ?");
						return confirmed;
					}
					function confirmation3(){
						var confirmed = confirm("Cette facture est déjà normalisée. Vous êtes sur le point de l'encaisser. Voulez-vous vraiment continuer ?");
						return confirmed;
					}
			</script>
	</head>
	<body bgcolor='azure' style="margin-top:2px;font-family:Cambria;">
	<form action='encaissement.php?menuParent=Consulation&<?php if(isset($_GET['solde'])) echo "&solde=".$_GET['solde']; if(isset($_GET['cham'])) echo "&cham=".$_GET['cham']; if(isset($_GET['impaye'])) echo "&impaye=".$_GET['impaye'];if(isset($_GET['Nd'])) echo "&Nd=".$_GET['Nd'];if(isset($_GET['Numclt'])) echo "&Numclt=".$_GET['Numclt'];if(isset($_GET['numfiche'])) echo "&numfiche=".$_GET['numfiche'];if(isset($_GET['Mtotal'])) echo "&Mtotal=".$_GET['Mtotal']; if(isset($_GET['groupe'])) echo "&groupe=".$_GET['groupe'];if(isset($_GET['Totalpaye'])) echo "&Totalpaye=".$_GET['Totalpaye'];if(isset($_GET['ttc_fixe'])) echo "&ttc_fixe=".$_GET['ttc_fixe'];if(isset($_GET['checkTVA'])) echo "&checkTVA=".$_GET['checkTVA'];if(isset($_GET['Periode'])) echo "&Periode=".$_GET['Periode'];?>' method='post' name='Impaye' id="form">
	<br/>
	<center>
	<div align="" style="">
		<table  width="1100" border="0" cellspacing="0" style="border:0px solid white;border-collapse: collapse;font-family:Cambria;">
			<tr>
				<td colspan='6'>
						<h3  style="text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;color:#444739;"> <?php if($val==1) echo "Liste des montants impayés de Chambre"; else echo "Liste des montants à faire valoir pour Chambre";?></h3>
				</td>
			</tr>
			<tr style=" background-color:<?php if($val==1) echo "#008b8b"; else echo "#3EB27B";?>;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border: 2px solid #ffffff" align="center" >N° d'ordre</td>
				<td style="border: 2px solid #ffffff" align="center" >N° Fiche</td>
				<td style="border: 2px solid #ffffff" align="center" >Nom & Pr&eacute;noms</td>
				<td style="border: 2px solid #ffffff" align="center" >Contact</td>
				<td style="border: 2px solid #ffffff" align="center" > Chambre(s) occupée(s)</td>
				<td style="border: 2px solid #ffffff" align="center" >Date d'arrivée</td>
				<td style="border: 2px solid #ffffff" align="center" >Date de sortie</td>
				<td style="border: 2px solid #ffffff" align="center" > Montant</td>
				<?php if($et!=1) echo "<td style='border: 2px solid #ffffff' align='center' >Actions</td>";?>
			</tr>
			<?php
				mysqli_query($con,"SET NAMES 'utf8'");$ans=date('Y');$mois=date('m');
				
				if($val==1)
					$query_Recordset1 = "select fiche1.numfiche AS numfiche,Periode from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND compte.due>0";
				else
					$query_Recordset1 = "select fiche1.numfiche AS numfiche,Periode from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND compte.due<0";
								
				$Recordset_2 = mysqli_query($con,$query_Recordset1);
				$numfiche=array(""); $m=0; $j=0;
				while($row=mysqli_fetch_array($Recordset_2)){
				$numfiche[$m]=$row['numfiche'];$m++;
				} 
				for($a=0;$a<count($numfiche);$a++){  				
				
				if($val==1)
					$query_Recordset1 = "select Periode from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfiche='".$numfiche[$a]."'";
				else
					$query_Recordset1 = "select Periode from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.numfiche='".$numfiche[$a]."'";
				
				
				$Recordset_2 = mysqli_query($con,$query_Recordset1);
				$ListePeriode0=array();$k=0;
				while($row1=mysqli_fetch_array($Recordset_2))
					{	 $ListePeriode0[$k]=$row1['Periode'];$k++;
					} 

				for($k=0;$k<count($ListePeriode0);$k++){ $j++;
				
				if($val==1)
				{
				$query_Recordset1 = "select ttc_fixeR,compte.ttva,fiche1.numfiche AS numero,compte.somme as somme,fiche1.codegrpe as codegrpe,client.Telephone AS Telephone, client.nomcli AS nom,client.prenomcli AS prenoms,chambre.nomch AS nomch, fiche1.datarriv1 AS Arrivee,fiche1.datsortie AS Sortie,
				compte.due AS due,compte.ttc_fixe AS ttc_fixe,client.sexe AS sexe,client.numcli AS numcli from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND fiche1.numfiche='".$numfiche[$a]."' AND compte.due>0 AND Periode='".$ListePeriode0[$k]."'";
				}
				else{
				 $query_Recordset1 = "select ttc_fixeR,compte.ttva,fiche1.numfiche AS numero,compte.somme as somme,fiche1.codegrpe as codegrpe,client.Telephone AS Telephone, client.nomcli AS nom,client.prenomcli AS prenoms,chambre.nomch AS nomch, fiche1.datarriv1 AS Arrivee,fiche1.datsortie AS Sortie,
				compte.due AS due,compte.ttc_fixe AS ttc_fixe,client.sexe AS sexe,client.numcli AS numcli from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND codegrpe='' AND chambre.numch=compte.numch AND fiche1.numfiche='".$numfiche[$a]."' AND compte.due<0 AND Periode='".$ListePeriode0[$k]."'";
				}

				$Recordset_2 = mysqli_query($con,$query_Recordset1);
					$cpteur=1;	
					$data="";//
					while($row=mysqli_fetch_array($Recordset_2))
					{   if($row['codegrpe']=='') {
							$name=$row['nom'].' '.$row['prenoms']; $nom_p=substr($name,0,15);
						}
						else
							{
							$name=$row['codegrpe']; $nom_p=substr($name,0,15);
						}
						if($row['due']<0) $due=-$row['due']; else $due=$row['due'];
						if($val==1)
						$ecrire=fopen('impayes.txt',"w");
						else
						$ecrire=fopen('valoir.txt',"w");
						$data.=$row['numero'].';'.$nom_p.';'.$row['nomch'].';'.substr($row['Arrivee'],8,2).'-'.substr($row['Arrivee'],5,2).'-'.substr($row['Arrivee'],0,4).';'.
						substr($row['Sortie'],8,2).'-'.substr($row['Sortie'],5,2).'-'.substr($row['Sortie'],0,4).';'.$due."\n";
						if($val==1)
						$ecrire2=fopen('impayes.txt',"a+");
						else
						$ecrire2=fopen('valoir.txt',"a+");
						fputs($ecrire2, $data);
						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						}
						
						$Rnumfiche = $row['numero'] ;
/* 						if(!empty($row['codegrpe'])){
							$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$row['codegrpe']."'";
							$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
							$datap=mysqli_fetch_object($req0);
							$Rnumfiche = $datap->code_reel;
						} */
						$sql="SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."' AND Periode='".$ListePeriode0[$k]."'";
						$s=mysqli_query($con,$sql);
						$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;
						if($nbreresult=mysqli_num_rows($s)>0)
							{	while($retA=mysqli_fetch_array($s))
									{ 	$ListeConnexe[$i]=$retA['code'];
										$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
										$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
										//$MontantPaye =$retA['MontantPaye'];
										$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
										$Ttotal+=$Ttotali;
									}$due+=$Ttotal;
							}
							
								$Arrivee=$row['Arrivee'];
								$Sortie=$row['Sortie'];   $checkTVA=$row['ttva'];//A revoir dans le cas d'un groupe
								$sexe=$row['sexe'];$Telephone=$row['Telephone'];
								
								$Arriveei=substr($Arrivee,8,2).'-'.substr($Arrivee,5,2).'-'.substr($Arrivee,0,4);
								$Sortiei=substr($Sortie,8,2).'-'.substr($Sortie,5,2).'-'.substr($Sortie,0,4);
								
								//$dueT=$due+$Ttotal;
								$name=addslashes($name);
								$sql="SELECT numFactNorm,e_mecef.id_request FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = ('".$name."') AND du ='".$Arriveei."' AND montant_ttc='".$due."' ";
								//$sql="SELECT numFactNorm,e_mecef.id_request FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = ('".$name."') AND du ='".$Arriveei."' AND au ='".$Sortiei."' AND montant_ttc='".$due."' ";//echo ".</br>";
								$query=mysqli_query($con,$sql);
									if (!$query) {
									printf("Error: %s\n", mysqli_error($con));
									exit();
								}
								$dataR=mysqli_fetch_object($query);	
								
								if(isset($dataR->numFactNorm))	{ $bgcouleur = "#f4debc";  } 
								
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
					            echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$j.".</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$row['numero']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$nom_p."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$row['Telephone']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$row['nomch']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".substr($row['Arrivee'],8,2).'-'.substr($row['Arrivee'],5,2).'-'.substr($row['Arrivee'],0,4)."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".substr($row['Sortie'],8,2).'-'.substr($row['Sortie'],5,2).'-'.substr($row['Sortie'],0,4)."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>";
								
								if($Ttotal>0){
									echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='#'> [+]<span>";
									//echo " <b style='color:red;'>[+]</b>";
								echo "<span>Détails sur le montant TTC &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;font-weight:bold;'>";
								if($val!=1)
									echo "Location de salle"; 
								else echo "Hébergement"; 
								echo " :&nbsp;".$row['due']." - Frais connexes :&nbsp;".$Ttotal;
								for($i=0;$i<count($ListeConnexe);$i++)
									{
									echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
									echo $i+1; echo "-&nbsp;&nbsp;".$ListeConnexe[$i]." :&nbsp;".$PrixConnexe[$i];
									echo "</center>";
									}
								echo "</span></a>";
								}
												
								echo $due ;	
								
								echo "</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff'>";
								if($et!=1){
								$Arrivee=$row['Arrivee'];
								$Sortie=$row['Sortie'];   $checkTVA=$row['ttva'];//A revoir dans le cas d'un groupe
								$sexe=$row['sexe'];$Telephone=$row['Telephone'];

								if(empty($row['codegrpe']))	 $file="encaissement"; else $file="encaissement2";

								if($val==1) {  
								  
								  if($row['ttc_fixeR']>0) $ttc_fixe=$row['ttc_fixeR']; else $ttc_fixe=$row['ttc_fixe'];
								  
								  if($ttc_fixe!=0) $Nd=$row['due']/$ttc_fixe;  //onclick='edition7();return false;'

								if(!isset($dataR->numFactNorm)) 
								{echo " 	<a class='info1'";  echo "href='"; echo $file.".php?menuParent=Consultation&solde=0&cham=1&impaye=1&Nd=".$Nd."&Numclt=".$row['numcli']."&numfiche=".$row['numero']."&Mtotal=".$due."&groupe=".$row['codegrpe']."&Totalpaye=".$row['somme']."&ttc_fixe=".$ttc_fixe."&checkTVA=".$checkTVA."&Periode=".$ListePeriode0[$k]."&Connexe=".$Ttotal;   
								echo "'";  echo 'onclick="return confirmation1();"'; echo "style='text-decoration:none;'>
								&nbsp;<img src='logo/cal.gif' alt='' title='' width='16' height='16' style='border:1px solid red;' ><span style='font-size:0.9em;color:red;'>Normaliser sans <br/>Encaisser la facture</span></a>";
								}							
								echo "<a class='info2'"; if(!isset($dataR->numFactNorm)) echo 'onclick="return confirmation2();"';  else echo 'onclick="return confirmation3();"';
								echo "href='"; echo $file.".php?menuParent=Consultation&solde="; if(!isset($dataR->numFactNorm)) echo 1; else echo 2; echo "&cham=1&impaye=1&Nd=".$Nd."&Numclt=".$row['numcli']."&numfiche=".$row['numero']."&Mtotal=".$due."&groupe=".$row['codegrpe']."&Totalpaye=".$row['somme']."&ttc_fixe=".$ttc_fixe."&checkTVA=".$checkTVA."&Periode=".$ListePeriode0[$k]."&Connexe=".$Ttotal;
								echo "'>&nbsp;&nbsp;&nbsp;<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:maroon;'>Encaisser ";
								
								if(!isset($dataR->numFactNorm)) echo "et <br/>Normaliser la facture"; else echo "la Facture";
								
								echo "</span> </a>";
								
								echo " <a class='info2' href='#' style='text-decoration:none;'>
								&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'><span style='font-size:0.9em;'>Envoyer une lettre de relance </span></a>";
								}
								else {
									echo " 	<a class='info2' href='";
									echo "fiche.php?menuParent=Consultation&numfiche=".$row['numero']."'>
									<img src='logo/more.png' alt='' title='Valoir' width='16' height='16' border='0'></a>";}
								}
								echo " 	</tr> "; 
						}
					}
				}
			//echo $j;
			//echo "select DISTINCT fiche1.numfichegrpe AS numfichegrpe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch  AND compte.due>0";
			if($val==1)
			{    //echo "select DISTINCT fiche1.numfichegrpe AS numfichegrpe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND codegrpe<>''";
				$sql="select DISTINCT fiche1.numfichegrpe AS numfichegrpe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND codegrpe<>''";
				//echo "<br/>";
				$sql2=mysqli_query($con,$sql);
				$numfichegrpe=array("");
				$i=0; $cpteur=1;
				while($row=mysqli_fetch_array($sql2)){
				$numfichegrpe[$i]=$row['numfichegrpe'];$i++;
				} 
				for($i=0;$i<count($numfichegrpe);$i++){  
				{	
					 $sql="select Periode from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfichegrpe='".$numfichegrpe[$i]."' GROUP BY Periode";
					$query_Recordset1 =mysqli_query($con,$sql);$ListePeriode=array();$b=0;
					while($row1=mysqli_fetch_array($query_Recordset1))
					{	 
						 $ListePeriode[$b]=$row1['Periode'];$b++;
					} 
				
				$ListeNumfiche=array(); $b=0;
				
				for($k=0;$k<count($ListePeriode);$k++){ 
					$sql="select sum(compte.due) AS due,chambre.numch AS numch from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfichegrpe='".$numfichegrpe[$i]."' AND Periode='".$ListePeriode[$k]."'";
					$query_Recordset2 =mysqli_query($con,$sql);
					$row2=mysqli_fetch_object($query_Recordset2);
					$due=$row2->due; 	$j++;	

					
					//echo "<br/>".
					$sql="select numfiche from fiche1  WHERE fiche1.numfichegrpe='".$numfichegrpe[$i]."' AND Periode='".$ListePeriode[$k]."'";
					//echo "<br/>";
					$query_Recordset2 =mysqli_query($con,$sql);
					$row2=mysqli_fetch_object($query_Recordset2);
					$ListeNumfiche[$b]=$row2->numfiche;	 $b++;
					//echo $numfichegrpe[$i];
					
					$query_Recordset1 =mysqli_query($con,"select sum(compte.somme) AS somme from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfichegrpe='$numfichegrpe[$i]' AND Periode='".$ListePeriode[$k]."'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ $somme=$row1['somme'];
					}

					$query_Recordset1 =mysqli_query($con,"select sum(compte.ttc_fixeR ) AS ttc_fixeR,sum(compte.ttc_fixe ) AS ttc_fixe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfichegrpe='$numfichegrpe[$i]' AND Periode='".$ListePeriode[$k]."'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ 	//$ttc_fixe=$row1['ttc_fixe'];
						if($row1['ttc_fixeR']>0) $ttc_fixe=$row1['ttc_fixeR']; else $ttc_fixe=$row1['ttc_fixe'];
					}
					//echo  $numfichegrpe[0]; echo count($numfichegrpe)>0;
					
					if((count($numfichegrpe)>0)&& !empty($numfichegrpe[0])){ //echo $numfichegrpe;
					 $sql= "select DISTINCT fiche1.numfichegrpe AS numero,Periode,fiche1.codegrpe AS codegrpe,groupe.contactgrpe AS contactgrpe,fiche1.datarriv1 AS Arrivee,fiche1.datsortie AS Sortie,
					compte.due AS due from fiche1,compte,client,chambre,groupe WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND groupe.code_reel=fiche1.numfichegrpe AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.numfichegrpe='".$numfichegrpe[$i]."' AND Periode='".$ListePeriode[$k]."'";
					$query_Recordset2 =mysqli_query($con,$sql);
					while($row2=mysqli_fetch_array($query_Recordset2))
					{$numero=!empty($row2['numero'])?$row2['numero']:NULL;
					 $codegrpe=$row2['codegrpe'];
					 $Sortie=$row2['Sortie'];
					 $contactgrpe=isset($row2['contactgrpe'])?$row2['contactgrpe']:NULL;
					}
					$codegrpe=!empty($codegrpe)?$codegrpe:NULL;
					
					$sql="select min(fiche1.datarriv1) AS Arrivee from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due>0 AND fiche1.codegrpe='".$codegrpe."'  AND Periode='".$ListePeriode[$k]."' ";
 					$query_Recordset1=mysqli_query($con,$sql);
						if (!$query_Recordset1) {
						printf("Error: %s\n", mysqli_error($con));
						exit();
					}
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ $Arrivee=$row1['Arrivee'];
					}
						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						}
						
						$Rnumfiche = $row2['numero'] ;
						if(isset($codegrpe))
						{
							$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$codegrpe."'";
							$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
							$datap=mysqli_fetch_object($req0);
							$Rnumfiche = $datap->code_reel;
						}

						$s=mysqli_query($con,"SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."' AND Periode='".$ListePeriode[$k]."'");
						$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$p=0; $Ttotal=0;
						if($nbreresult=mysqli_num_rows($s)>0)
							{	while($retA=mysqli_fetch_array($s))
									{ 	$ListeConnexe[$p]=$retA['code'];
										$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
										$PrixConnexe[$p]=$Unites*$MontantUnites; $id[$p] =$retA['id']+$p; $p++;
										//$MontantPaye =$retA['MontantPaye'];
										$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
										$Ttotal+=$Ttotali;
									}$due+=$Ttotal;
							}	$numero =1;		// A revoir			
														
								$Arriveei=substr($Arrivee,8,2).'-'.substr($Arrivee,5,2).'-'.substr($Arrivee,0,4);
								$Sortiei=substr($Sortie,8,2).'-'.substr($Sortie,5,2).'-'.substr($Sortie,0,4);
							
								 $sql="SELECT numFactNorm,e_mecef.id_request FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = '".$codegrpe."' AND du ='".$Arriveei."' AND montant_ttc='".$due."' ";
								//echo $sql="SELECT numFactNorm,e_mecef.id_request FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = '".$codegrpe."' AND du ='".$Arriveei."' AND au ='".$Sortiei."' AND montant_ttc='".$due."' ";
								$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);	
								
								if(isset($dataR->numFactNorm))	{ $bgcouleur = "#f4debc";  } 
								
								//if(!isset($contactgrpe))$contactgrpe=NULL;
								
								$contactgrpe=!empty($contactgrpe)?$contactgrpe:NULL;
			
								echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$j.".</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$Rnumfiche."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$codegrpe."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$contactgrpe."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>";
								  for($b=0;$b<count($ListeNumfiche);$b++){	
									  $sql="SELECT DISTINCT nomch FROM chambre,fiche1,compte WHERE fiche1.numfiche=compte.numfiche AND compte.numch=chambre.numch AND fiche1.codegrpe='".$codegrpe."' 
									 AND Periode='".$ListePeriode[$k]."' AND etatsortie='OUI'";								  
									$s=mysqli_query($con,$sql);
										$v=0; //echo $ListeNumfiche[$b]."<br>";
										while($retV=mysqli_fetch_array($s))
											{  	 $v++; 
												//if($v<=5)
													{ echo $retV['nomch'];
													 if((count($ListeNumfiche) > 0)) 
														{  //if(count($ListeNumfiche)>1)
															//if($v != count($ListeNumfiche))
															echo "&nbsp;<span style='color:white;'>|</span>&nbsp;";
														}
													}
												//else echo "&nbsp;<span style='color:maroon;'>...</span>&nbsp;"; 
										
											}
									}  array_splice($ListeNumfiche,0);//Ici je supprime tous les éléments du tableau 
								echo "</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$Arriveei."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>".$Sortiei."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>";
								
								if($Ttotal>0){
									echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='#'> [+]<span>";
									//echo " <b style='color:red;'>[+]</b>";
								echo "<span>Détails sur le montant TTC &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;font-weight:bold;'>";
								//if($sal==1) 
									echo "Location de salle"; 
								//else echo "Hébergement"; 
								echo " :&nbsp;".$row2['due']." - Frais connexes :&nbsp;".$Ttotal;
								for($p=0;$p<count($ListeConnexe);$p++)
									{
									echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
									echo $p+1; echo "-&nbsp;&nbsp;".$ListeConnexe[$p]." :&nbsp;".$PrixConnexe[$p];
									echo "</center>";
									}
								echo "</span></a>";
								}
												
								echo $due ;	
								
								echo "</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff'>";
								//if($et!=1){
								 //if($val==1) {
								if(!isset($dataR->numFactNorm))
								{echo "<a class='info1'"; echo 'onclick="return confirmation1();"'; echo "href='encaissement2.php?menuParent=Consultation&solde=0&cham=1&impaye=1&numero=".$numero."&montant=".$due."&codegrpe=".$codegrpe."&Arrivee=".$Arrivee."&Sortie=".$Sortie."&ttc_fixe=".$ttc_fixe."&Periode=".$ListePeriode[$k];
								echo "'><img src='logo/cal.gif' alt='' title='' width='16' height='16' style='border:1px solid red;'><span style='font-size:0.9em;color:red;'>Normaliser sans <br/>Encaisser la facture</span> </a>";}
								
								echo "<a class='info2'";  if(!isset($dataR->numFactNorm)) echo 'onclick="return confirmation2();"'; else echo 'onclick="return confirmation3();"'; echo "href='encaissement2.php?menuParent=Consultation&"; if(!isset($dataR->numFactNorm)) echo "solde=1"; else echo "solde=2"; if(isset($dataR->numFactNorm)) { echo "&id_request=".$dataR->id_request; echo "&numFactNorm=".$dataR->numFactNorm; } echo "&cham=1&impaye=1&numero=".$numero."&montant=".$due."&codegrpe=".$codegrpe."&Arrivee=".$Arrivee."&Sortie=".$Sortie."&ttc_fixe=".$ttc_fixe."&Periode=".$ListePeriode[$k];
								echo "'>&nbsp;<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;color:maroon;'>"; 
								
								if(!isset($dataR->numFactNorm)) echo " Encaisser et <br/>Normaliser la facture"; else echo " Encaisser la <br/> Facture "; 
								
								echo "</span> </a>";
								
								echo " 	<a class='info2' href='"; echo "' >";
								echo "&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'>
								<span style='font-size:0.9em;'>Envoyer une lettre de relance </span></a>";
								}
							//	else
								//echo"fiche.php?menuParent=Consultation&numero=".$row['numero']."'>	<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;'>Faire valoir </span></a>";
							//}
								echo "</td> </tr> ";
				//$i++;
				} 
				}
			}
			}
			else {   
				$sql2=mysqli_query($con,"select DISTINCT fiche1.numfichegrpe AS numfichegrpe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND codegrpe<>''");
				$numfichegrpe=array("");
				$i=0;
				$cpteur=1;$j++;
				while($row=mysqli_fetch_array($sql2))
				{	$numfichegrpe[$i]=$row['numfichegrpe'];
					$query_Recordset1 =mysqli_query($con,"select sum(compte.due) AS due from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.numfichegrpe='$numfichegrpe[$i]'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{$due=$row1['due'];
					}

					$query_Recordset1 =mysqli_query($con,"select sum(compte.somme) AS somme from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.numfichegrpe='$numfichegrpe[$i]'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ $somme=$row1['somme'];
					}				
					
					$query_Recordset1 =mysqli_query($con,"select sum(compte.ttc_fixeR ) AS ttc_fixeR,,sum(compte.ttc_fixe ) AS  ttc_fixe from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.numfichegrpe='$numfichegrpe[$i]'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ //$ttc_fixe=$row1['ttc_fixe'];
					  if($row1['ttc_fixeR']>0) $ttc_fixe=$row1['ttc_fixeR']; else $ttc_fixe=$row1['ttc_fixe'];
					}

					$query_Recordset2 =mysqli_query($con,"select Periode,fiche1.numfichegrpe AS numero,fiche1.codegrpe AS codegrpe,groupe.contactgrpe AS contactgrpe,fiche1.datarriv1 AS Arrivee,fiche1.datsortie AS Sortie,
					compte.due AS due from fiche1,compte,client,chambre,groupe WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND groupe.code_reel=fiche1.numfichegrpe AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.numfichegrpe='$numfichegrpe[$i]'");
					while($row2=mysqli_fetch_array($query_Recordset2))
					{$numero=$row2['numero'];
					 $codegrpe=!empty($row2['codegrpe'])?$row2['codegrpe']:NULL;
					 $Sortie=$row2['Sortie'];
					 $contactgrpe=$row2['contactgrpe'];
					}
 					$query_Recordset1=mysqli_query($con,"select min(fiche1.datarriv1) AS Arrivee from fiche1,compte,client,chambre WHERE fiche1.numfiche=compte.numfiche AND etatsortie='OUI' AND fiche1.numcli_1=client.numcli  AND chambre.numch=compte.numch AND compte.due<0 AND fiche1.codegrpe='".$codegrpe."'");
					while($row1=mysqli_fetch_array($query_Recordset1))
					{ $Arrivee=$row1['Arrivee'];
					}
						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						}
						
						$Rnumfiche = $row2['numero'] ;
						if(!empty($row2['codegrpe'])){
							$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$row2['codegrpe']."'";
							$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
							$datap=mysqli_fetch_object($req0);
							$Rnumfiche = $datap->code_reel;
						}

						$s=mysqli_query($con,"SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."'");
						$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;
						if($nbreresult=mysqli_num_rows($s)>0)
							{	while($retA=mysqli_fetch_array($s))
									{ 	$ListeConnexe[$i]=$retA['code'];
										$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
										$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
										//$MontantPaye =$retA['MontantPaye'];
										$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
										$Ttotal+=$Ttotali;
									}$due+=$Ttotal;
							}
							

								//echo $sql="SELECT numFactNorm FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = '".$codegrpe."' AND du ='".$Arriveei."' AND au ='".$Sortiei."' AND montant_ttc='".$due."' ";
								//$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);									
								//if(isset($dataR->numFactNorm))	{ $bgcouleur = "#Ce5C5C";  }

								
						echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$j.".</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$numero."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$codegrpe."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$contactgrpe."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'> - </td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($Arrivee,8,2).'-'.substr($Arrivee,5,2).'-'.substr($Arrivee,0,4)."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".substr($Sortie,8,2).'-'.substr($Sortie,5,2).'-'.substr($Sortie,0,4)."</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>";
								
								if($Ttotal>0){
									echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='#'> [+]<span>";
									//echo " <b style='color:red;'>[+]</b>";
								echo "<span>Détails sur le montant TTC &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;font-weight:bold;'>";
								//if($sal==1) 
									echo "Location de salle"; 
								//else echo "Hébergement"; 
								echo " :&nbsp;".$row2['due']." - Frais connexes :&nbsp;".$Ttotal;
								for($i=0;$i<count($ListeConnexe);$i++)
									{
									echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
									echo $i+1; echo "-&nbsp;&nbsp;".$ListeConnexe[$i]." :&nbsp;".$PrixConnexe[$i];
									echo "</center>";
									}
								echo "</span></a>";
								}
												
								echo $due ;	
								
								echo "</td>";
								echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
								if($et!=1){
								echo " 	<a class='info2' href='";  if($val==1) {
									//echo"encaisse.php?menuParent=Consultation&numero=".$numero."&montant=".$due."&paye=".$somme."&groupe=".$codegrpe."&Arrivee=".$Arrivee."&Sortie=".$Sortie."&ttc_fixe=".$ttc_fixe;
								echo "'>
								<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;'>Encaisser </span></a>";}
								else
								echo"fiche.php?menuParent=Consultation&numero=".$numero."'>
								<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;'>Faire valoir </span></a>";}
								echo " 	</tr> ";
				$i++;
				}
			}

			?>
		</table>

		<br/>
		<br/>
			<table  width="1100" border="0" cellspacing="0" style="margin-top:40px;border-collapse: collapse;font-family:Cambria; border:0px solid white;">
			<tr>
				<td colspan='6'>
						<h3  style="text-decoration:none; font-family:Cambria;font-weight:bold;font-size:1.3em;color:#444739;"> <?php if($val==1) echo "Liste des montants impayés de Salle"; else echo "Liste des montants à faire valoir pour Salle";?></h3>
				</td>
			</tr>
			<tr style=" background-color:<?php if($val==1) echo "#008b8b"; else echo "#3EB27B";?>;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border: 2px solid #ffffff" align="center" >N° d'ordre</td>
				<td style="border: 2px solid #ffffff" align="center" >N° Fiche</td>
				<td style="border: 2px solid #ffffff" align="center" >Nom & Pr&eacute;noms</td>
				<td style="border: 2px solid #ffffff" align="center" >Contact</td>
				<td style="border: 2px solid #ffffff" align="center" >Désignation Salle</td>
				<td style="border: 2px solid #ffffff" align="center" >Date d'arrivée </td>
				<td style="border: 2px solid #ffffff" align="center" >Liberée le</td>
				<td style="border: 2px solid #ffffff" align="center" > Montant</td>
					<?php if($et!=1) echo "<td style='border: 2px solid #ffffff' align='center' >Actions</td>";?>
			</tr>
			<?php
				mysqli_query($con,"SET NAMES 'utf8'");$ans=date('Y');$mois=date('m');
				if($val==1)
				  $query_Recordset1 = "select Periode,ttva,trim(codegrpe) AS codegrpe,location.numcli AS numcli,ttc_fixeR,ttc_fixe,location.numfiche AS numero,client.Telephone AS Telephone,client.nomcli AS nom,client.prenomcli AS prenoms,salle.codesalle AS codesalle, location.datarriv1 AS Arrivee,location.datsortie AS Sortie,
				compte1.somme,compte1.due AS due from location,compte1,client,salle WHERE location.numfiche=compte1.numfiche AND etatsortie='OUI' AND (location.numcli = client.numcli OR location.numcli = client.numcliS)  AND salle.numsalle=compte1.numsalle AND compte1.due>0 ";
				else
			      $query_Recordset1 = "select Periode,ttva,trim(codegrpe) AS codegrpe,location.numcli AS numcli,ttc_fixeR,ttc_fixe,location.numfiche AS numero,client.Telephone AS Telephone,client.nomcli AS nom,client.prenomcli AS prenoms,salle.codesalle AS codesalle, location.datarriv1 AS Arrivee,location.datsortie AS Sortie,
				compte1.somme,compte1.due AS due from location,compte1,client,salle WHERE location.numfiche=compte1.numfiche AND etatsortie='OUI' AND (location.numcli = client.numcli OR location.numcli = client.numcliS)  AND salle.numsalle=compte1.numsalle AND compte1.due<0 ";
			    $Recordset_2 = mysqli_query($con,$query_Recordset1);
					$cpteur=1;$jj=1;
					$data="";
					while($row=mysqli_fetch_array($Recordset_2))
					{   $name=!empty($row['codegrpe'])?$row['codegrpe']:($row['nom'].' '.$row['prenoms']); $nom_p=$name;  //$nom_p=substr($name,0,15); 
						if($row['due']<0) $due=-$row['due']; else $due=$row['due'];
						if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						}
						
						$Rnumfiche = $row['numero'] ;
						if(!empty($row['codegrpe'])){
							$sql0="SELECT code_reel FROM groupe WHERE codegrpe='".$row['codegrpe']."'";
							$req0 = mysqli_query($con,$sql0) or die (mysqli_error($con));
							$datap=mysqli_fetch_object($req0);
							$Rnumfiche = isset($datap->code_reel)?$datap->code_reel:$Rnumfiche; 
							$name=isset($row['codegrpe'])?$row['codegrpe']:NULL;
						}
						$sql="SELECT * FROM fraisconnexe WHERE numfiche='".$Rnumfiche."'";
						$s=mysqli_query($con,$sql);
						$ListeConnexe=array(); $PrixConnexe=array(); $id=array();$i=0; $Ttotal=0;
						if($nbreresult=mysqli_num_rows($s)>0)
							{	while($retA=mysqli_fetch_array($s))
									{ 	$ListeConnexe[$i]=$retA['code'];
										$Unites =$retA['NbreUnites']; $MontantUnites =$retA['PrixUnitaire'];
										$PrixConnexe[$i]=$Unites*$MontantUnites; $id[$i] =$retA['id']+$i; $i++;
										//$MontantPaye =$retA['MontantPaye'];
										$NbreUnites =$retA['NbreUnites'];  $Ttotali = $NbreUnites * $MontantUnites ;
										$Ttotal+=$Ttotali;
									}$due+=$Ttotal;
							}
						
								$Arrivee=$row['Arrivee']; $Sortie=$row['Sortie'];
								$Arriveei=substr($Arrivee,8,2).'-'.substr($Arrivee,5,2).'-'.substr($Arrivee,0,4);
								$Sortiei=substr($Sortie,8,2).'-'.substr($Sortie,5,2).'-'.substr($Sortie,0,4);
							
								$sql="SELECT e_mecef.id_request,numFactNorm FROM reedition_facture,e_mecef WHERE reedition_facture.id_request=e_mecef.id_request AND reedition_facture.nom_client = addslashes('".$name."') AND du ='".$Arriveei."' AND au ='".$Sortiei."' AND montant_ttc='".$due."' ";
								$query=mysqli_query($con,$sql);$dataR=mysqli_fetch_object($query);	
								
								if(isset($dataR->numFactNorm))	{ $bgcouleur = "#f4debc";  } 
								
						echo " 	<tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$jj.".</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$row['numero']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$nom_p."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$row['Telephone']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$row['codesalle']."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$Arriveei."</td>"; 
								echo " 	<td align='center' style='border: 2px solid #ffffff; '>".$Sortiei."</td>";
								echo " 	<td align='center' style='border: 2px solid #ffffff;'>";				
																
								if($Ttotal>0){
									echo "<a class='info2' style='color:red;text-decoration:none;font-weight:bold;' href='#'> [+]<span>";
									//echo " <b style='color:red;'>[+]</b>";
								echo "<span>Détails sur le montant TTC &nbsp;&nbsp;&nbsp;<span style='color:red;margin-left:0%;font-size:1em;font-weight:bold;'>";
								//if($sal==1) 
									echo "Location de salle"; 
								//else echo "Hébergement"; 
								echo " :&nbsp;".$row['due']." - Frais connexes :&nbsp;".$Ttotal;
								for($i=0;$i<count($ListeConnexe);$i++)
									{
									echo "<hr style='margin-top:-3px;'/> <center style='font-size:1em;color:maroon'>";
									echo $i+1; echo "-&nbsp;&nbsp;".$ListeConnexe[$i]." :&nbsp;".$PrixConnexe[$i];
									echo "</center>";
									}
								echo "</span></a>";
								}
												
								echo $due ;								
								
								echo "</td>";
								if($et!=1){ 
								$Arrivee=$row['Arrivee'];
								$Sortie=$row['Sortie'];						
								$checkTVA=$row['ttva'];//A revoir dans le cas d'un groupe
									
								if(empty($row['codegrpe']))	 $file="encaissement"; else $file="encaissement2";										
												
									{  	
										if($row['ttc_fixeR']>0) $ttc_fixe=$row['ttc_fixeR']; else $ttc_fixe=$row['ttc_fixe'];
										 
										if($ttc_fixe!=0) $Nd=$row['due']/$ttc_fixe;
									
									}
								
								echo " 	<td align='center' style='border: 2px solid #ffffff'>";
								
								if(!isset($dataR->numFactNorm)) {
									echo " 	<a class='info1'";  echo "href='"; echo $file.".php?menuParent=Consultation&solde=0&sal=1&impaye=1&Nd=".$Nd."&Numclt=".$row['numcli']."&numero=".$row['numero']."&Mtotal=".$due."&groupe=".$row['codegrpe']."&Totalpaye=".$row['somme']."&ttc_fixe=".$row['ttc_fixe']."&Arrivee=".$Arrivee."&Sortie=".$Sortie."&montant=".$due."&codegrpe=".$row['codegrpe']."&checkTVA=".$checkTVA."&Connexe=".$Ttotal."&Periode=".$row['Periode'];
									echo "'";  echo 'onclick="return confirmation1();"'; echo "style='text-decoration:none;'>
									&nbsp;<img src='logo/cal.gif' alt='' title='' width='16' height='16' style='border:1px solid red;' ><span style='font-size:0.9em;color:red;'>Normaliser sans <br/>Encaisser la facture</span></a>";
								}
								echo " 	
								<a class='info2' href='";								
								echo $file.".php?menuParent=Consultation&sal=1&solde="; if(isset($dataR->numFactNorm)) echo 2; else echo 1;  if(isset($dataR->numFactNorm))  { echo "&id_request=".$dataR->id_request; echo "&numFactNorm=".$dataR->numFactNorm; } echo "&impaye=1&Nd=".$Nd."&Numclt=".$row['numcli']."&numero=".$row['numero']."&Mtotal=".$due."&groupe=".$row['codegrpe']."&Totalpaye=".$row['somme']."&ttc_fixe=".$row['ttc_fixe']."&Arrivee=".$Arrivee."&Sortie=".$Sortie."&montant=".$due."&codegrpe=".$row['codegrpe']."&checkTVA=".$checkTVA."&Connexe=".$Ttotal."&Periode=".$row['Periode'];
								//echo "encaisse.php?menuParent=Consultation&sal=1&numero=".$row['numero']."&montant=".$due."&somme=".$row['somme'];
								echo "'"; if(isset($dataR->numFactNorm)) echo 'onclick="return confirmation3();"'; else echo 'onclick="return confirmation2();"'; echo ">";
								echo "&nbsp;<img src='logo/more.png' alt='' title='' width='16' height='16' border='0' ><span style='font-size:0.9em;color:maroon;'>Encaisser ";
								if(!isset($dataR->numFactNorm)) echo "et <br/>Normaliser "; echo "la Facture</span></a> ";
								echo " 	<a class='info2' href='"; echo "' >";
								echo "&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'>
								<span style='font-size:0.9em;'>Envoyer une lettre de relance </span></a>";
								echo "</td> ";
								}
								echo "</tr> ";

					}
/* 					if(($trouver =='NON')&&($val==1))
					 { 	$jour=date("d");
					 		while($row=mysqli_fetch_array($reqselP))
							{	//if(($jour==20)||($jour==21)||($jour==22)||($jour==23)||($jour==24)||($jour==25)||($jour==26)||($jour==27)||($jour==28)||($jour==29)||($jour==30)||($jour==31))
								$mois=$row['mois_payement'];
								$annee=$row['annee_payement'];
								$montant_ttc=100000;
								$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
							if($cpteur == 1)
						{
							$cpteur = 0;
							$bgcouleur = "#acbfc5";
						}
						else
						{
							$cpteur = 1;
							$bgcouleur = "#dfeef3";
						}

					 echo " <tr class='rouge1' bgcolor='".$bgcouleur."'>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$j.".</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>L".$mois."".$annee."</td>";
								echo ' 	<td align="center" style="border-right: 2px solid #ffffff; border-top: 2px solid #ffffff">Congrégation "Les Filles de Padre Pio"</td>';
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>-</td>";
								echo " 	<td align='left' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>Restaurant"." <span style='color:white'>[".$moisT[$mois-1]." ".$annee."]</span></td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>-</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>-</td>";
								echo " 	<td align='center' style='border-right: 2px solid #ffffff; border-top: 2px solid #ffffff'>".$montant_ttc."</td>";
								echo " 	<td align='center' style='border-top: 2px solid #ffffff'>";
								if($et!=1) {
								echo " 	<a class='info2' href='encaisse_loyer.php?numero=L".$mois."".$annee."&mois=".$mois."&ans=".$annee."'>
								<img src='logo/more.png' alt='' title='' width='16' height='16' border='0'><span style='font-size:0.9em;'>Encaisser </span> </a>";
								echo " <a class='info2' target='_blank' href='"; echo"relance.php?numero=".$numero."&Sortie=".$Sortie."' style='text-decoration:none;'>
								&nbsp;<img src='logo/mail.png' alt='' title='' width='25' height='25' border='0' style='margin-bottom:-3px;'><span style='font-size:0.9em;'>Envoyer une lettre de relance </span></a>";
								}
								echo "</td>";
					echo " 	</tr> ";$j++;
							}
					} */
			?>
		</table>
	</div>
	</center>
	</form>
	</body>

</html>
