<?php
include_once'menu.php'; $c=!empty($_GET['c'])? $_GET['c']:NULL;$d=!empty($_GET['d'])? $_GET['d']:NULL;
//include 'difference.php';

if(isset($_POST['ok'])&& ($_POST['ok']=="OK")){
	 $debut=$_POST['ladate']; $fin=$_POST['ladate2'];
	   $debut1=str_replace("-","/",$_POST['ladate']);    $debut1=substr($debut1,8,2) ."/". substr($debut1,5,2) ."/". substr($debut1,0,4);
	   $fin1  =str_replace("-","/",$_POST['ladate2']);    $fin1=substr($fin1,8,2) ."/". substr($fin1,5,2) ."/". substr($fin1,0,4);

//$debut='2018-05-01';$fin='2018-05-30'; 	
 $Nbrejrs=1+nbJours($debut, $fin) ;  //Correspond à la différence entre $debut et $fin
$Query1=mysqli_query($con,"SELECT * FROM chambre WHERE EtatChambre='active'");
$NbreCh=$Nbrejrs*mysqli_num_rows($Query1); 

$Query1=mysqli_query($con,"SELECT sum(NbreLits) AS NbreLits FROM chambre WHERE EtatChambre='active'");
$data=mysqli_fetch_object($Query1); $NbreLits=$data->NbreLits; $NbreLits*=$Nbrejrs;

$Query2=mysqli_query($con, "SELECT * FROM fiche1,compte,chambre WHERE fiche1.numfiche=compte.numfiche AND compte.numch=chambre.numch AND fiche1.datarriv BETWEEN '$debut' AND '$fin' 
UNION
(SELECT * FROM fiche1,compte,chambre WHERE fiche1.numfichegrpe=compte.numfiche AND compte.numch=chambre.numch AND fiche1.datarriv BETWEEN '$debut' AND '$fin' )");
$NbreCh2=mysqli_num_rows($Query2); 

//$NbreClts1=0;
/* $Query3=mysqli_query($con, "SELECT * FROM `chambre` WHERE EtatChambre='Active' AND tarifdouble<>'' ");
$data=mysqli_fetch_assoc($Query3); $NbreClts1=$data['NbreLits']*mysqli_num_rows($Query3);  */

//$Query4=mysqli_query($con, "SELECT * FROM `chambre` WHERE EtatChambre='Active' AND tarifsimple<>'' AND tarifdouble=''");$NbreClts1+=mysqli_num_rows($Query4); 

}
$NbreCh=!empty($NbreCh)? $NbreCh : NULL;
$NbreCh2=!empty($NbreCh2)? $NbreCh2 : NULL;
$NbreLits=!empty($NbreLits)? $NbreLits : NULL;
$NbreClts2=!empty($NbreClts2)? $NbreClts2 : NULL;


		$ref=mysqli_query($con,"SELECT somme_paye FROM reedition_facture WHERE date_emission>='".$debut."' and date_emission<='".$fin."' ORDER BY date_emission");
		$montant0=0;$montant=0;
		while ($rerf=mysqli_fetch_array($ref))
		{ 	$montant0=$rerf['somme_paye'];
			$montant+=$montant0;				
		}$montant%=$montant/$Nbrejrs;$montant=round($montant,-1);
?>
<html>
	<head><link rel="Stylesheet" href='css/table.css' /></head>
	<body bgcolor='azure' >
		<div align="" style="font-family:Cambria;">
	<table  WIDTH="800" style='margin: -15px auto;background-color:#D0DCE0;' id="tab">
	<tr style=''><td colspan='4' align='center'><h3 style='margin-bottom:-15px;color:maroon;'>LES INDICATEURS DE PERFORMANCE DE LA PERIODE DU &nbsp; <?php	if(isset($debut1)) echo  $debut1 ."
&nbsp;AU &nbsp;".$fin1; ?> </h3></td></tr>
	<tr><td colspan='4'><hr style='color:maroon;'/><span style='font-weight:bold;color:teal;font-size:110%;'>&nbsp;&nbsp;Liste des données exploitées dans le calcul des différents ratios</span></td></tr>
		<tr>
			<td style=''>&nbsp;&nbsp;
			    Nombre de chambres disponibles :
			</td>
			<td style='color:#dc143c;'> <?php echo $NbreCh; ?>		
			</td>

			<td style=''>
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de chambres louées :
			</td>
			<td style='color:#dc143c;'> <?php echo $NbreCh2; ?>		
			</td>
		</tr>
		<tr>
			<td style=''>
			    &nbsp;&nbsp;&nbsp;Nombre de chambres libres :
			</td>
			<td style='color:#dc143c;'><?php echo $NbreL=$NbreCh-$NbreCh2; ?>		
			</td>

			<td style=''>
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre de Nuitées :
			</td>
			<td>212		
			</td>
		</tr>
				<tr>
			<td style=''>
			    &nbsp;&nbsp;&nbsp;Nombre de clients logeables :
			</td>
			<td style='color:#dc143c;'><?php echo $NbreLits; ?>			
			</td>

			<td style=''>
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chiffre d'affaires de l'hôtel :
			</td>
				<td style='color:#dc143c;'><?php echo $montant." ".$devise; ?>	</td>
			</tr>
				<tr>
			<td style=''>
			    &nbsp;&nbsp;&nbsp;Nombre de clients logés :
			</td>
			<td style='color:#dc143c;'>	
<?php
				 $req="SELECT sum(np) AS np FROM encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' ";
				$res=mysqli_query($con,$req);
				$rers1=mysqli_fetch_array($res) ; 
				echo $Nuite=$rers1['np'];
				
/* 				if($etat_taxe==2){
					if($typeoccup[$j]=="double")  $somme[$i]*=2;$i++;
				} */
?>			
			</td>

			<td style=''>
			    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre des arrivées :
			</td>
			<td>212		
			</td>
		</tr><tr><td colspan='4'><hr style='color:maroon;'/><span style='font-weight:bold;color:teal;font-size:110%;'>Les Indicateurs de Performance Commerciale</span></td></tr>
			<tr style='background-color:#DDEEDD;'><td align='center' colspan='4'>
			<table border='1' width='100%' style='margin-left:0px;border-left:black;'>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						(Nombre de chambres louées / Nombre de chambres disponibles) * 100</span>TAUX D'OCCUPATION  </a>
					</td> <td  style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreCh!=0) echo round(100*($NbreCh2/$NbreCh),2); ?> %</td>

					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						(Nombre de chambres libres / Nombre de chambres disponibles) * 100</span>TAUX DE DISPONIBILITE </a>
					</td><td style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreCh!=0) echo round(100*($NbreL/$NbreCh),2); ?> %</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						(Nombre de clients logés / Nombre de clients logeables) * 100</span>TAUX DE FREQUENTATION  </a>
					</td><td style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreLits!=0) echo round(100*($Nuite/$NbreLits),2); ?> %</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						(Nombre de clients logés / Nombre de chambres louées) * 100</span>INDICE DE FREQUENTATION </a>
					</td><td style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreCh2!=0) echo round(100*($Nuite/$NbreCh2),2); ?></td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						(Chiffre d'affaire de l'hôtel / Nombre de chambres louées) * 100</span>YIELD SIMPLE </a>
					</td><td style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreCh2!=0) echo round(100*($montant/$NbreCh2),2); ?>%</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						(Chiffre d'affaire de l'hôtel / Nombre de chambres disponibles) * 100</span>YIELD ELARGI </a>
					</td><td style='color:maroon;background-color:#fffff0;font-weight:bold;'>&nbsp;&nbsp;&nbsp;<?php if($NbreCh!=0) echo round(100*($montant/$NbreCh),2); ?>%</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						Nombre de nuitées / Nombre des arrivées</span>DUREE MOYENNE DE SEJOUR  </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						(Nombre de petits-déjeuner / Nombre de nuitées) * 100</span>TAUX DE CAPTAGE </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						C. A. Total réalisé en location / C. A. potentiel</span>REVENU MOYEN PAR CLIENT  </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						C. A. Location / Nombre de chambres louées </span>PRIX DE VENTE MOYEN D'UNE CHAMBRE </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						(Nbre de réservations non honorées sur une période / Nbre de nuités sur la période) * 100</span>TAUX DE NO SHOW  </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						C. A. Total réalisé en location / C. A. potentiel </span>TAUX DE REALISATION FINANCIERE EN HEBERGEMENT </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						((Rack Rate - Prix moyen chambre) / Rack Rate ) * 100</span>TAUX DE CAPTAGE  </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>

					<td align='' ><a href='' class='info' ><span style='color:#494039;'>
						C. A. Hébergement / Nbre de chambres disponibles </span>REVENU MOYEN PAR CHAMBRE DISPONIBLE </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
			</table>
			</td></tr>
			<tr><td colspan='4'><hr style='color:maroon;'/><span style='font-weight:bold;color:teal;font-size:110%;'>Les Indicateurs de Performance relatifs aux Côuts</span></td></tr>
				<tr><td align='center' colspan='4'>
					<table border='1' width='100%'>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						</span>COUT MATIERE  </a>
					</td> <td>&nbsp;&nbsp;&nbsp;457</td>

					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						</span>RENDEMENT PAR EMPLOYE </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
				<tr class='rouge1'>
					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						</span>TAUX DE PRODUCTIVITE  </a>
					</td> <td>&nbsp;&nbsp;&nbsp;457</td>

					<td align=''  ><a href='' class='info' ><span style='color:#494039;'>
						</span>RENDEMENT AU SERVICE ETAGE </a>
					</td><td>&nbsp;&nbsp;&nbsp;457</td>
				</tr>
					</table>
				</td>
			</tr>
			<tr><td align='center' colspan='4'>
			<table align='left'>
					<tr>
					<td><a class='info' href='#' style='color:black;'><br/>
					<span style='font-size:0.9em;font-style:normal;color:black;'>Imprimer</span>	 <i class='fas fa-print' aria-hidden='true' style='font-size:150%;'></i></a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;
					<a class='info' href='#' style='color:#1D702D;'>
					<span style='font-size:0.9em;font-style:normal;'>Exporter en Version Excel</span>	 <i class='fa fa-file-excel' aria-hidden='true' style='font-size:150%;'></i>
					&nbsp;&nbsp;<input type='submit' class="bouton2" name='EXPORTER' value='EXPORTER'/>	</a><br/>&nbsp;</td>
					</tr>

				</table>
				</td>
			</tr>	
	</table>

	</div>
	</body> 
</html>