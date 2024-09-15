<?php 
include 'connexion.php';
//ob_start();
//$bdd= new PDO('mysql:host=localhost;dbname=codiam','root','');

require('html2pdf/html2pdf.class.php');
//session_start();

	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	if(!empty($trie))
		 $Req="SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye' ORDER BY $trie ASC";
	else 
		$Req="SELECT *  FROM payement_loyer,loyer  WHERE loyer.Numero=payement_loyer.Numero AND Etat='Npaye'";
	$reqselP=mysqli_query($con,$Req);
	
	
$reqsel=mysqli_query($con,"SELECT * FROM autre_configuration");
	while($data=mysqli_fetch_array($reqsel))
		{  $Mtaxe=$data['taxe'];   $etat_taxe=$data['etat_taxe'];  $limitation=$data['limitation'];  $limite_jrs=$data['limite_jrs'];  $fond=$data['fond'];
		   $logo=$data['logo'];   $sitename=$data['sitename']; $favicon=$data['favicon'];$montantAuto=$data['montantAuto'];$AppliquerTaxe=$data['AppliquerTaxe'];//$numFacture='PF00001'; 
		}
		
	$resT=mysqli_query($con,"SELECT * FROM  hotel"); 
	$reXt=mysqli_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo'];
	$telephone1=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb'];
		
		$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
	$tz = new DateTimeZone('Africa/Porto-Novo');
	$date->setTimezone($tz);
	$Date_actuel= $date->format("d") ."/". $date->format("m")."/". $date->format("Y");
	echo '<page backtop="5%" backbottom="5%" backleft="5%" backright="5%">';
	echo '<table >
			<tr>
				<td><font size="4" align="center">'.$nomHotel.'</font ></td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Cotonou le, '.$Date_actuel.' </td>
			</tr>
			<tr>
				<td align="center"> <img src="'.$logo.'" width="150" height="75"></td>
				<td align="right"> </td>
			</tr>
	</table>';
	echo '<h2 style="text-align:left;text-decoration:none;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:green;">Liste des locations mensuelles</h2>'; 
	echo "<table style=''>";
			//echo '<caption style="text-align:left;text-decoration:none;font-weight:bold;font-size:1.3em;margin-bottom:5px;color:green;">Liste des locations mensuelles</caption>';
			echo '<tr style="background-color:#E96D55;color:white;font-size:1.2em; padding-bottom:5px;">
				<td style="border-right: 0px solid #ffffff" align="center" > N°&nbsp;&nbsp;</td>
				<td style="border-right: 0px solid #ffffff" align="center" > N° Enreg.</td>
				<td style="border-right: 0px solid #ffffff" align="center" > Nom du locataire</td>
				<td style="border-right: 0px solid #ffffff" align="center" >Contact&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="border-right: 0px solid #ffffff" align="center" >Désignation de la location&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="border-right: 0px solid #ffffff" align="center" > Date Payement&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td style="border-right: 0px solid #ffffff" align="center" >Montant&nbsp;&nbsp;&nbsp;&nbsp;</td>';
			echo '</tr>';
			
				//mysqli_query("SET NAMES 'utf8'");
					$ans=date('Y');$mois=date('m');
					$jour=date('d'); $j=1;$cpteur = 1;
					 while($row=mysqli_fetch_array($reqselP))
						{		
							$mois=$row['mois_payement'];
							$annee=$row['annee_payement'];
							$montant_ttc=$row['Montant'];
							$moisT = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Aôut','Septembre','Octobre','Novembre','Décembre');
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

					 echo '<tr  bgcolor="'.$bgcouleur.'">';
								echo '<td>'.$j.'.</td>';
								echo '<td>'.$row['Numero'].'</td>';
								echo '<td>'.$row['NomLoc'].'</td>';
								echo '<td>'.$row['ContactLoc'].'</td>';
								echo '<td>'.$row['Designation'].'</td>';
								echo '<td>'.substr($row['DatePayement'],0,2).' '.$moisT[$mois-1].' '.$annee.'</td>';
								echo '<td>'.$montant_ttc.'</td>';
					echo '</tr>';	$j++;					
			}
				
		echo '</table>';
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