
<?php
include 'config.php'; 
$i = 1;
 $moisX=array("");
 $req9 = mysqli_query($con,"SELECT codesalle FROM salle ORDER BY numsalle ");
while($data9 = mysqli_fetch_array($req9))
{$moisX[$i] = $data9['codesalle'];
 $i++;
 }
 $totalRows_Recordset1 = mysqli_num_rows($req9)+1;
//mysqli_close($con);


$jours = array(1=>"Lu",2=>"Ma",3=>"Me",4=>"Je",5=>"Ve",6=>"Sa",0=>"Di");
if(isset($_GET['annee']) AND preg_match("#^[0-9]{4}$#",$_GET['annee'])){//si on souhaite afficher une autre année, on l'affiche si elle est correcte
	$annee=$_GET['annee'];
} else {
	$annee=date("Y");//si non, on affiche l'année actuelle
}

$NbrDeJour=[];
for($mois=1;$mois<=12;$mois++) {
	$NbrDeJour[$mois]=date("t",mktime(1,1,1,$mois,2,$annee));
	$PremierJourDuMois[$mois]=date("w",mktime(5,1,1,$mois,1,$annee));
}
$year=date('Y');  $mois=(!empty($_GET['mois']) && isset($_GET['mois']))? $mois=$_GET['mois'] : (int)(date('m')); //if($mois>=12) $mois=1;  if($mois<=1) $mois=12;
$moisT = array("","Janvier","Fevrier","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Decembre");
$titre="Planning de Réservation des Salles de <span style='color:green;'>".$nomHotel."</span> pour le mois de";

?>

<?php

$StyleTh="text-shadow: 1px 1px 1px #000;color:white;border-right:1px solid black;border-bottom:1px solid black;";

 ?>
 <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title><?php echo $title; ?></title>
		<link href="fontawesome/web-fonts-with-css/css/fontawesome-all.min.css" rel="stylesheet">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="Stylesheet" type="text/css" media="screen, print" href='css/style.css' /> 
		
		 <style type="text/css">
		div {
		width: 50px;
		overflow: hidden;
		}
		</style>
		<script type="text/javascript">  
		var timer1;
		function scrollDiv(divId, depl) {
		   var scroll_container = document.getElementById(divId);
		   scroll_container.scrollTop -= depl;
		   timer1 = setTimeout('scrollDiv("'+divId+'", '+depl+')', 20);
		}
		</script>
	</head>
	<body><a class='info'  href='menu.php?menuParent=Grille'><i class="fas fa-angle-double-left" style='font-size:1.2em;'></i><span style='color:black;'>Retour</span></a> 
<table cellpadding='0' cellspacing='0' style="width:100%;margin: auto;border:1px solid black;border-collapse:collapse;box-shadow: 10px 10px 5px #888888;">
	<caption style="font-size:18px;"> <h2 style='margin-top:-15px;margin-bottom:10px;'> <?php echo $titre ?>
	<a href="?mois=<?php if($mois==1) { } else echo $mois-1; if(!empty($_GET['annee'])) echo "&annee=".$_GET['annee']; ?>" style="font-size:50%;vertical-align:middle;text-decoration:none;">
	<?php echo $moisT[$mois-1]; ?></a>
	<?php echo $moisT[$mois]; ?> 
	<a href="?mois=<?php if($mois>=12)  {  }  else echo $mois+1; if(!empty($_GET['annee'])) echo "&annee=".$_GET['annee']; ?>" style="font-size:50%;vertical-align:middle;text-decoration:none;">
	<?php if($mois>=12)  {  } else  echo $moisT[$mois+1]; ?>
	</a>&nbsp;
	<a href="<?php if(!empty($_GET['mois'])) echo "?mois=".$_GET['mois']; ?>&annee=<?php echo $annee-1; ?>" style="font-size:50%;vertical-align:middle;text-decoration:none;"><?php echo $annee-1; ?></a> <?php echo $annee; ?> <a href="<?php if(!empty($_GET['mois'])) echo "?mois=".$_GET['mois']; ?>&annee=<?php echo $annee+1; ?>" style="font-size:50%;vertical-align:middle;text-decoration:none;"><?php echo $annee+1; ?>
	</a> 
		


		</h2>
</caption>
		<tr style=''>
			<th style="width: 51pt;<?php echo $StyleTh; ?>background:black"><?php echo "Liste des Salles"; ?></th>
          <?php   
		   	$m=$mois;
		    for($jour=1;$jour<=$NbrDeJour[$mois];$jour++){
					?>
					<th style="width: 17pt;<?php echo $StyleTh; ?>background:#FF9933"><?php echo $jour; ?></th>
				<?php 	
				} ?>
		 </tr>
</table>

<?php
 $jour-=1; ;
 //echo "Merci http://www.solucior.com/fr/13-Scroll_div_avec_javascript.html";
  
$req8 = mysqli_query($con,"DELETE FROM reserversal where numsalle='0' ");
$Recordset = mysqli_query($con,"DELETE FROM reservationsal  WHERE numsalle='0'");
$query_Recordset1 = "SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND salle.EtatSalle='active' AND annee like $annee AND mois like $mois  ORDER BY position ASC";
$Recordset1 = mysqli_query($con,$query_Recordset1) or die(mysqli_error($con));
$cpt = 0;$ListeReserv = array(array());
while($row_Recordset1 = mysqli_fetch_array($Recordset1)){
	$ListeReserv[$cpt][0] = $row_Recordset1['codesalle'];
	$ListeReserv[$cpt][1] = $row_Recordset1['debut'];
	$ListeReserv[$cpt][2] = $row_Recordset1['fin'];
	$ListeReserv[$cpt][3] = !empty($row_Recordset1['codegrpe'])?$row_Recordset1['codegrpe']:$row_Recordset1['nomdemch'];
	$cpt++; 
}
$Recordset1 = mysqli_query($con,"CREATE OR REPLACE VIEW reservation AS SELECT salle.codesalle,reservationsal.debut,reservationsal.fin,reservationsal.position,reservationsal.prenomdemch,reservationsal.nomdemch,reservationsal.codegrpe  FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND salle.EtatSalle='active' AND annee like $annee AND mois like $mois  ORDER BY position ASC") or die(mysqli_error($con));

$StyleTh1="color:#DAEEEC;background:#DAEEEC;";

echo "<div id='MyDiv' style='width: 100%; height: 100%; border: 1px solid; overflow: hidden'>
<table cellpadding='0' cellspacing='0' style='border-collapse: collapse;'>";
		for($i=1;$i < $totalRows_Recordset1;$i++) { 
			$JourReserve=0;		
				echo "<tr style=''>
					<td style='background:#1A1D26;border:1px solid white;color:white;'>".ucfirst($moisX[$i])."</td>";
				for($mois=1;$mois<=$jour;$mois++) { 
				
					?>
						
						<td style="<?php echo $JourReserve==1?"background:#FF9933;":"background:#DAEEEC;"; ?>border-bottom:1px solid #eee;">
						<?php 
 /* 						for($j=0;$j<count($ListeReserv);$j++) { 
							if($ListeReserv[$j][0]==$moisX[$i]){
								if(($mois>=$ListeReserv[$j][1])&&($mois<=$ListeReserv[$j][2]))
									{$StyleTh1="color:#FF9933;background:#FF9933;";
									}
								//else
									//$StyleTh1="color:#DAEEEC;background:#DAEEEC;";
								
							}else   $StyleTh1="color:#DAEEEC;background:#DAEEEC;";

						}  */
						$query_Recordset1 = "SELECT * FROM reservation where codesalle='".$moisX[$i]."' AND '".$mois."' BETWEEN debut AND fin";
						$Recordset1 = mysqli_query($con,$query_Recordset1) or die(mysqli_error($con));
						if(mysqli_num_rows($Recordset1)>0) {
							while($data=mysqli_fetch_array($Recordset1)){
							$debut=$data['debut'];$fin=$data['fin'];
							if($debut!=$fin) $periode= $debut ."/".$m."/".$annee." au ".$fin."/".$m."/".$annee; else $periode=$fin."/".$m."/".$annee;
							$demandeur = !empty($data['codegrpe'])?$data['codegrpe']:$data['nomdemch'];
							}
							echo "<table  cellpadding='0' cellspacing='0' style='border:0px solid black;'>
								<tr>
									<td style='color:#FF9933;background:#C82605; width: 35pt;height: 10pt;'>
									<a class='info' href='#' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:bold;color:red;'>
									Client: ".$demandeur."<br/><span style='color:#5C110F;'> Période d'occupation envisagée: ".$periode."</span></span>
									<font style='color:#C82605;'>p</font>								
									
									</a>
									</td>
								</tr>
						</table>"; 
						}
						else 
							echo "<table  style='border:1px solid black;'>
								<tr>
									<td style='color:#DAEEEC;background:#DAEEEC; width: 35pt;height: 10pt;'></td>
								</tr>
							</table>"; 
						?>
						</td>
				<?php
				
			
				}
				echo "</tr>";
		}
		?>
</table></div>
<table id="recap" style=''>
	<tr>
		<td style="background:#C82605;width:15px;height:15px;"></td><td>Réservé</td>
	</tr>
	<tr>
		<td style="background:#DAEEEC;width:15px;height:15px;border:1px solid black;"></td><td>Disponible</td>
	</tr>
</table>
</body></html>