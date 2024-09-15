<?php
session_start();
include 'connexion.php'; include 'chiffre_to_lettre.php';
//ob_start();
//$bdd= new PDO('mysql:host=localhost;dbname=codiam','root','');

require('html2pdf/html2pdf.class.php');
//require_once(dirname(__FILE__).'/html2pdf.class.php');
$req=mysqli_query($con,"DROP table SalleTempon");
function nbJours($debut, $fin) {
	//60 secondes X 60 minutes X 24 heures dans une journée
	$nbSecondes= 60*60*24;

	$debut_ts = strtotime($debut);
	$fin_ts = strtotime($fin);
	$diff = $fin_ts - $debut_ts;
	return round($diff / $nbSecondes);
}
$reqsel=mysqli_query($con,"SELECT tax  FROM tva");
$data=mysqli_fetch_assoc($reqsel);$tva=$data['tax'];

$res=mysqli_query($con,"SELECT valeurTaxe FROM taxes WHERE NomTaxe LIKE 'TVA'");
$ret=mysqli_fetch_assoc($res); $TvaD=$ret['valeurTaxe'];

$reqsel=mysqli_query($con,"SELECT * FROM autre_configuration");
	while($data=mysqli_fetch_array($reqsel))
		{  $Mtaxe=$data['taxe'];   $etat_taxe=$data['etat_taxe'];  $limitation=$data['limitation'];  $limite_jrs=$data['limite_jrs'];  $fond=$data['fond'];
		   $logo=$data['logo'];   $sitename=$data['sitename']; $favicon=$data['favicon'];$montantAuto=$data['montantAuto'];$AppliquerTaxe=$data['AppliquerTaxe'];//$numFacture='PF00001';
		}$objet="Location de salle";$typeDecompte="Hébergement";
$reqsel=mysqli_query($con,"SELECT * FROM configuration_facture");
while($data=mysqli_fetch_array($reqsel))
	{  $num_fiche=$data['num_fiche'];   $num_fact=$data['num_fact'];  $etat_facture=$data['etat_facture'];  $initial_grpe=$data['initial_grpe'];  $initial_reserv=$data['initial_reserv'];
	   $initial_fiche=$data['initial_fiche'];    $Nbre_char=$data['Nbre_char']; $limite_jrs=$data['limite_jrs'];$num_reserv=$data['num_reserv'];  $reimprimer=$data['reimprimer'];
	   $initial_proforma=$data['initial_proforma']; $num_proForma =$data['num_proForma'];
	}$date=date('Y');
	if(($num_proForma >=0)&&($num_proForma <=9))
			 $num_proForma='0000'.$num_proForma  ;
	else if(($num_proForma >=10)&&($num_proForma <=99))
			 $num_proForma='000'.$num_proForma  ;
	else if(($num_proForma >=100)&&($num_proForma <=999))
			$num_proForma='00'.$num_proForma  ;
	else if(($num_proForma >=1000)&&($num_proForma <=1999))
			 $num_proForma='0'.$num_proForma  ;
	else
			{}

	$num=$num_proForma."/".$date;

$req=mysqli_query($con,"SELECT DISTINCT du FROM facturepro  WHERE numFacture='".$_SESSION['numFacture']."'");
$nbre1=mysqli_num_rows($req);
if($nbre1==1) $debut=1;else $debut=2;
$req=mysqli_query($con,"SELECT DISTINCT au FROM facturepro  WHERE numFacture='".$_SESSION['numFacture']."'");
$nbre2=mysqli_num_rows($req);
if($nbre2==1) $fin=1;else $fin=2;

$req=mysqli_query($con,"SELECT DISTINCT min(du) AS min,max(au) AS max FROM facturepro  WHERE numFacture='".$_SESSION['numFacture']."'");
$data=mysqli_fetch_assoc($req);
$periode=substr($data['min'],8,2)."-".substr($data['min'],5,2)."-".substr($data['min'],0,4)." au ".substr($data['max'],8,2)."-".substr($data['max'],5,2)."-".substr($data['max'],0,4);

$reqsel=mysqli_query($con,"SELECT * FROM facturepro,factureproforma WHERE factureproforma.numFacture=facturepro.numFacture AND Designation LIKE 'C%'");
$nbre2=mysqli_num_rows($req);
$sql="SELECT count(*) AS nbre FROM facturepro,factureproforma WHERE factureproforma.numFacture=facturepro.numFacture AND Designation NOT LIKE 'C%'";
$reqsel=mysqli_query($con,$sql);$result=mysqli_fetch_assoc($reqsel); $nbre3=$result['nbre'];
//$nbre3=mysqli_num_rows($req);

$req=mysqli_query($con,"SELECT * FROM facturepro  WHERE numFacture='".$_SESSION['numFacture']."' AND du <>'0000-00-00' AND au <> '0000-00-00' ");
$nbreA=mysqli_num_rows($req);
 if($nbreA<= 0) $periode="A déterminer";

 	$resT=mysqli_query($con,"SELECT * FROM  hotel");
	$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo'];
	$telephone1=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb'];

		$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
	$tz = new DateTimeZone('Africa/Porto-Novo');
	$date->setTimezone($tz);
	$Date_actuel= $date->format("d") ."/". $date->format("m")."/". $date->format("Y");

$reqsel=mysqli_query($con,"SELECT * FROM factureproforma");
while($data=mysqli_fetch_array($reqsel))
	{  //$NomClient=$data['nomDemandeur'];
	$codegrpe=$data['codegrpe']; if(!empty($codegrpe)) $NomClient=$codegrpe ; else $NomClient =$data['nomDemandeur'] ;
	if(($debut==1)&& ($fin==1)){
	$du=substr($data['du'],8,2).'-'.substr($data['du'],5,2).'-'.substr($data['du'],0,4);   $au=substr($data['au'],8,2).'-'.substr($data['au'],5,2).'-'.substr($data['au'],0,4);
	}
	 $numdemandeur=$data['TelephoneDemandeur'];
	}//if(empty($du)) $periode="A déterminer";else $periode=$du." au ".$au;
	 //echo $nbre1."<br/>".$nbre2;
echo '<page backtop="5%" backbottom="5%" backleft="5%" backright="5%">
	<table style="width:100%;" >
					<tr>
						<td><font size="4" align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$nomHotel.'</font ></td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cotonou le, '.$Date_actuel.' </td>
					</tr>
					<tr>
						<td align="left"> <img src="'.$logo.'" width="150" height="75"></td>
						<td align="left"> </td>
					</tr>
	</table>
	<h3 style="text-align:center;font-family:arial;"><u>FACTURE PRO FORMA</u>&nbsp;N°'.$num.'</h3>
	<table>
		<tr>
			<td width=""><u>Client </u>:</td >
			<td width=""><span style="">'.$NomClient.'</span> </td >
		</tr>
		<tr>
			<td width=""><br/><u>Objet </u>:</td >
			<td width=""><br/><span style="">';$objet="";
			if($nbre2>0)			//if($_SESSION['objet']==1)
				 $objet="Hébergement";
			if($nbre3>0){
				if($nbre2>0)  $objet.=" & ";
					 $objet.="Location de salle";
			}
			echo $objet;
			//if($_SESSION['objet']==3)

			//else echo $objet="Location de salle";
			echo '</span> </td >
		</tr>
		<tr>
			<td width=""><br/><u>Période </u>:</td >
			<td><br/>'.$periode.' </td >
		</tr>
		<tr>
			<td width=""><br/><u>N° Téléphone</u> : </td >
			<td width=""><br/> '.$numdemandeur.' </td >
		</tr>
	</table><br/><h4 style="text-align:center;">Décomptes &nbsp;';
			//if(($nbre2>0)&&($nbre3>0))
				echo $objet;

	echo '</h4>
			<table border="1" align="center"  style="width:100%;border-collapse: collapse;" >
			<tr>';

 			// if(($debut!=1) || ($fin!=1)){
			// 	echo '
			// <td ROWSPAN=2 align="center">Dates</td>';
			// }

			echo '
			<td style="width:20%;" ROWSPAN=2 align="center">Désignation</td>
			<td style="width:10%;" ROWSPAN=2 align="center">Nbre <br/>de<br/> chambres</td>
			<td style="width:10%;" ROWSPAN=2 align="center">Nbre <br/>de<br/> nuitées</td>
			<td style="width:10%;" ROWSPAN=2 align="center">Prix Unitaire<br/> TTC</td>
			<td style="width:50%;" COLSPAN=3 align="center">'; echo 'MONTANTS'; echo '</td>
		</tr>

		<tr>
			<td align="center">Montant <br/>HT</td>
			<td align="center">Taxe <br/>de séjour</td>
			<td align="center">Montant <br/>TTC</td>
		</tr>';

			//$req=$bdd->query("SELECT numcli,nomcli,prenomcli FROM client LIMIT 100");
			mysqli_query($con,"SET NAMES 'utf8'");
			$sql="SELECT Designation,occupation,PrixUnitaire,Nbre,Type,tva,DATEDIFF(facturepro.au,facturepro.du) AS Nbre_jrs FROM facturepro,factureproforma  WHERE factureproforma.numFacture=facturepro.numFacture AND facturepro.numFacture='".$_SESSION['numFacture']."'";
			$req=mysqli_query($con,$sql);
			//while($data=$req->fetch())
			$TMontantHT=0;$TmontantTVA=0;$Ttaxe=0;$TmontantTTC=0;$Global=0;$i=0;
			while($data=mysqli_fetch_array($req))
			{	 echo '<tr>';   $i++;
 				if(($debut!=1) || ($fin!=1)){
					//if($data['du']!=$data['au'])
					//	echo "<td align='center'> <i>Du </i> " .substr($data['du'],8,2).'-'.substr($data['du'],5,2).'-'.substr($data['du'],0,4). "<br/><i> &nbsp;au </i> " .substr($data['au'],8,2).'-'.substr($data['au'],5,2).'-'.substr($data['au'],0,4)." &nbsp;</td>";
				//	else
					//echo '<td align="center">'.substr($data['du'],8,2).'-'.substr($data['du'],5,2).'-'.substr($data['du'],0,4).'</td>';
					}
					echo '<td>'.$data['Designation'].' '.$data['Type'];
					if(!empty($data['occupation']))
						echo " <br/>".$data['occupation'];
					echo '</td>';
					echo '<td align="center">'.$data['Nbre'].'</td>';

					//$sql="SELECT * FROM facturepro,factureproforma  WHERE factureproforma.numFacture=facturepro.numFacture AND facturepro.numFacture='".$_SESSION['numFacture']."'";
					//$req1=mysqli_query($con,$sql);

					//$nbre_jrs=nbJours($data['du'], $data['au']);
					$nbre_jrs=$data['Nbre_jrs']; 	if(substr($data['Designation'],0,1)!="C") $nbre_jrs++; //Pour les salles

					// if(substr($data['Designation'], 0,7)=="Chambre"){
					// 	if($nbre_jrs==0)$nbre_jrs++;
					// }
					// else $nbre_jrs++;
/* 					if($data['occupation']=="individuelle") $taxe=$Mtaxe*$nbre_jrs*$data['Nbre'];
					else {if (($etat_taxe==2)&&(substr($data['Designation'], 0,7)=="Chambre")) $taxe=$Mtaxe*$nbre_jrs*$data['Nbre']*2;  else $taxe=0;} */

					//if($i==1) $nbre_jrs=1; else $nbre_jrs=2;

					echo '<td align="center">'.$nbre_jrs;   echo '</td>';

					$tarif=$data['PrixUnitaire'];

					if($tarif<=20000) $taxe = 500; else if(($tarif>20000) && ($tarif<=100000))	$taxe = 1500; else $taxe = 2500;

					if($data['tva']==0) {
						$montantTVA=0; 	$MontantHT=($tarif-$taxe)*$nbre_jrs*$data['Nbre'];
				 }else {
					 $MontantHT=($tarif-$taxe)/(1+$TvaD)*$nbre_jrs*$data['Nbre'];
					 $montantTVA=round($MontantHT*$TvaD);
				 } $TmontantTVA+=$montantTVA;

				 $taxe=$taxe*$nbre_jrs*$data['Nbre']; $Ttaxe+=$taxe;
					//$PuTTC=(int)($data['PrixUnitaire']+($data['PrixUnitaire']*$tva))+$taxe;
					//$montantTTC=$data['PrixUnitaire']*$nbre_jrs*$data['Nbre'];
					$tarif=$tarif*$nbre_jrs*$data['Nbre'];
					$TmontantTTC+=$tarif;

					 $TMontantHT+=round($MontantHT);
					echo '<td align="center">'.$data['PrixUnitaire'].'</td>';
					echo '<td align="center">'.round($MontantHT).'</td>';
					//echo '<td align="center">'.round($montantTVA).'</td>';
					echo '<td align="center">'; if($taxe==0) echo $taxe='-'; else echo $taxe; echo '</td>';
					echo '<td align="center">'.$tarif.'</td>';
				echo '</tr>';
			}
			echo '
				<tr>';
				if(($debut!=1) || ($fin!=1))
					echo '<td COLSPAN=5 align="center">SOUS TOTAUX</td>';
				else
					echo '<td COLSPAN=4 align="center">SOUS TOTAUX</td>';
					echo '<td  align="center">'.$TMontantHT.'</td>';
					//echo '<td  align="center">'.$TmontantTVA.'</td>';
					echo '<td  align="center">'.$Ttaxe.'</td>
					<td  align="center">'.$TmontantTTC.'</td>'; $Global+=$TmontantTTC;
				echo '</tr>
				<tr>';
				// if(($debut!=1) || ($fin!=1))
				// 	echo '<td COLSPAN=8 align="center">TOTAL GLOBAL</td>';
				// else
				// 	echo '<td COLSPAN=7 align="center">TOTAL GLOBAL</td>
				  //<td  align="center">'.$Global.'</td>';
					echo '
				</tr>';

	echo '</table> ';

	echo "<table align='right'>
	<tr>
		<td align='right'><br/><br/><br/><br/><br/><br/>
			Le promoteur,
		<br/><br/><br/><br/><br/>
			Sylvestre SEGOUN
		</td>
	</tr>
	<tr>
		<td>

		</td>
	</tr>
</table>";
//unset($_SESSION['objet']);  unset($_SESSION['objetC']); unset($_SESSION['objetS']);
	/* echo "<br/><br/><br/><br/><b><u>NB:</u> Une avance de 50 % et un bon de commande sont exig&eacute;s avant toute r&eacute;servation.</b>";
	 //echo "<br/><br/>Arret&eacute; la pr&eacute;sente facture proforma &agrave; la somme de :   ";
	 	//echo '<B>';
			//chiffre_en_lettre($Global, $devise1='francs CFA', $devise2='');
		//echo'</B>';

		echo "<table align='right'>
		<tr>
			<td align='right'><br/>
				Le promoteur,
			<br/><br/><br/><br/><br/>
				Sylvestre SEGOUN,
			</td>
		</tr>
		<tr>
			<td>

			</td>
		</tr>
	</table>";
	//echo "<br/><br/><br/><br/><b><u>NB:</u> Une avance de 50 % et un bon de commande sont exig&eacute;s avant toute r&eacute;servation.</b>";
 	 echo "<page_footer><hr/>
			<p style=\'font-size: 11px; text-align: center;\'>";
				if(!empty($Apostale))
					echo $Apostale."&nbsp;&nbsp;";
				if((!empty($telephone1))||(!empty($telephone2)))
					{ echo "TEL: ".$telephone1."/".$telephone2."&nbsp;";}
					if(!empty($Email))
						echo "&nbsp;&nbsp;E-mail: ".$Email."&nbsp;&nbsp;";
					if(!empty($Siteweb ))
						echo "&nbsp;&nbsp;Site web: ".$Siteweb."&nbsp;&nbsp;";
					if(!empty($NumBancaire))
						echo "Compte Bancaire: ".$NumBancaire;
					if(!empty($NumUFI))
						echo "&nbsp;&nbsp;N° IFU: ".$NumUFI."&nbsp;&nbsp;";
					if(!empty($nomHotel))
					  echo $nomHotel;
				echo "<br/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				REPUBLIQUE DU BENIN
			</p>
	</page_footer>"; */
	 	 echo "<page_footer><hr/>
			<p style=\'font-size: 11px; text-align: center;\'>";
				if(!empty($Apostale))
					echo $Apostale."&nbsp;&nbsp;";
				if((!empty($telephone1))||(!empty($telephone2)))
					{ echo "TEL: ".$telephone1."/".$telephone2."&nbsp;";}
					if(!empty($Email))
						echo "&nbsp;&nbsp;E-mail : ".$Email."&nbsp;&nbsp;";
					if(!empty($Siteweb ))
						echo "&nbsp;&nbsp;Site web : ".$Siteweb."&nbsp;&nbsp;";
					if(!empty($NumBancaire))
						echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Compte Bancaire : ".$NumBancaire;
					if(!empty($NumUFI))
						echo "&nbsp;&nbsp;N° IFU : ".$NumUFI."&nbsp;&nbsp;";
					if(!empty($nomHotel))
					  echo $nomHotel;
				echo " |
				REPUBLIQUE DU BENIN
			</p>
	</page_footer>";
echo '</page>';
$content = ob_get_clean();
try
{
	$pdf = new HTML2PDF('P','A4','fr','true','UTF-8');
	$pdf->writeHTML($content);
	$pdf->Output('liste.pdf');
	$pdf->pdf->SetDisplayMode('fullpage');
    die();
}
catch(HTML2PDF_exception $e)
{
    die($e.''. __LINE__ );
}




?>
