<?php 
include 'connexion.php';
//ob_start();
//$bdd= new PDO('mysql:host=localhost;dbname=codiam','root','');

// http://demo.html2pdf.fr/examples/pdf/about.pdf
//http://borntocode.fr/php-creer-ses-devis-au-format-pdf-avec-html2pdf/

require('html2pdf/html2pdf.class.php');
$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
$mois= date("m");

$reqsel=mysql_query("SELECT * FROM autre_configuration");
	while($data=mysql_fetch_array($reqsel))
		{  $Mtaxe=$data['taxe'];   $etat_taxe=$data['etat_taxe'];  $limitation=$data['limitation'];  $limite_jrs=$data['limite_jrs'];  $fond=$data['fond'];
		   $logo=$data['logo'];   $sitename=$data['sitename']; $favicon=$data['favicon'];$montantAuto=$data['montantAuto'];$AppliquerTaxe=$data['AppliquerTaxe'];//$numFacture='PF00001'; 
			$signataireLrelance=$data['signataireLrelance'];  $devise=$data['devise'];
		}
		
	$resT=mysql_query("SELECT * FROM  hotel"); 
	$reXt=mysql_fetch_assoc($resT); $nomHotel=$reXt['nomHotel'];$NumUFI=$reXt['NumUFI'];$Apostale=$reXt['Apostale'];$NomLogo=$reXt['logo'];
	$telephone1=$reXt['telephone1'];$telephone2=$reXt['telephone2'];$Email=$reXt['Email'];$NumBancaire=$reXt['NumBancaire']; $Siteweb=$reXt['Siteweb'];
		
		$date = new DateTime("now"); // 'now' n'est pas nécéssaire, c'est la valeur par défaut
	$tz = new DateTimeZone('Africa/Porto-Novo');
	$date->setTimezone($tz);
	$Date_actuel= $date->format("d") ."/". $date->format("m")."/". $date->format("Y");
	
$groupe=$_GET['groupe'];$NomClient=$_GET['nom'];$sexe=$_GET['sexe'];$adresse=$_GET['adresse'];$Sortie=$_GET['Sortie'];$Arrivee=$_GET['Arrivee'];$montant=$_GET['montant'];
$mois2=substr($Sortie,5,2); $DateEtablie=substr($Sortie,8,2).' '.$moisT[$mois2-1].' '.substr($Sortie,0,4);
$mois3=substr($Arrivee,5,2); $DateEtablie2=substr($Arrivee,8,2).' '.$moisT[$mois3-1].' '.substr($Arrivee,0,4);
if($sexe=="M") $civilite="Monsieur"; else if(empty($groupe)) $civilite="Madame"; else $civilite="Personne responsable du groupe";
$periode="<b>".$DateEtablie2."</b> au <b>".$DateEtablie."</b>.";
$objet="Location de salle"; $numdemandeur="67-48-42-12";$typeDecompte="Hébergement";
echo '<page backtop="5%" backbottom="5%" backleft="5%" backright="5%">
	<table style="width:100%;:1px solid black;" >';
						echo '<tr>';
							echo '<td width=""><font size"4" align="center"></font > 
							<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</td>';
						    echo '<td align="right">
							Cotonou le, '.date('d')." ".$moisT[$mois-1]." ".date('Y') .'</td>
						</tr>';
 						echo '<tr>
							<td align="left">'; if(!empty($nomHotel))
							echo $nomHotel;    echo '<br>';
							if(!empty($Apostale)) 
							echo $Apostale."&nbsp;&nbsp;"; 
							if((!empty($telephone1))||(!empty($telephone2))) 
							{ echo "TEL: ".$telephone1;} 
							echo '<br>';
							if(!empty($Email))
							echo "E-mail: ".$Email."&nbsp;&nbsp;";
							echo '<br>';
								if(!empty($NumBancaire))
							echo "Compte Bancaire: ".$NumBancaire; 	
							echo '<br>';						
							if(!empty($NumUFI))
							echo "N° IFU: ".$NumUFI."&nbsp;&nbsp;";
							echo '<br>REPUBLIQUE DU BENIN</td>
						</tr>'; 
 						echo '<tr>
							<td align="left"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A <br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
							if(!empty($NomClient)) echo $NomClient; else echo $NomClient= $groupe;
							echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							&nbsp;&nbsp;&nbsp;&nbsp;'.$adresse.'<br>
							
							<u>Objet:</u> Lettre de relance</td>
						</tr>'; 
						 echo '<tr>
								<td align="center"><br>&nbsp;&nbsp;'.$civilite.' &nbsp;'.$NomClient.', </td>
							 </tr>'; 
	echo '</table>';
	echo '<p style="text-align:justify;">Nous vous avons établi le, <b>'.$DateEtablie.'</b> une facture d\'un montant de <b>'.$montant.'</b> '.$devise.' Cette facture correspond au tarif de votre l\'hébergement dans notre hôtel dans la période du '.$periode.' 
	Sauf erreur ou omission de notre part, la facture rappelée en référence, reste impayée à ce jour. Afin de conserver nos excellentes relations, nous vous demandons de bien vouloir régulariser cette situation dans les meilleurs délais.
	Si toutefois, vous aviez procédé à un règlement, nous vous demandons de ne pas tenir compte de ce courrier.
	Dans cette attente, nous vous prions d\'agréer, Madame, Monsieur, nos salutations distinguées.</p>';
	echo "<table align='right' style='margin-top:100px;'>
		<tr>
			<td>
				Signature,
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
				<tr>
			<td>
				&nbsp;
			</td>
		</tr>
				<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		
		<tr>
			<td >";
				echo $signataireLrelance;
			echo "</td>
		</tr>
	</table>";	
	/* 	 echo "<page_footer><hr/>
			<p style=\"font-size: 11px; text-align: center;\">(CODIAM HOTEL SARL) - 01 BP 429 TEL: 21 30 37 27 / 21 15 37 81 - N° RCCMRB/COT/13B 10160
			<br/>  E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N° 09784420021  N° IFU 3201300800616  <br/> REPUBLIQUE DU BENIN</p>
	</page_footer>"; */
	echo "<page_footer><hr/>
			<p style=\"font-size: 11px; text-align: center;\"> REPUBLIQUE DU BENIN</p>
	</page_footer>";
echo "</page>";
$content = ob_get_clean();

$pdf = new HTML2PDF('P','A4','fr','true','UTF-8');
$pdf->writeHTML($content);
$pdf->Output('liste.pdf');


?>