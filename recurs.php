<?php
	session_start(); 
	//convertion de chiffre en lettre 
	include 'connexion.php';	include 'configuration.php'; 
	function chifre_en_lettre($montant, $devise1='', $devise2='')
{
    if(empty($devise1)) $dev1='Dinars';
    else $dev1=$devise1;
    if(empty($devise2)) $dev2='';
    else $dev2=$devise2;
    $valeur_entiere=intval($montant);
    $valeur_decimal=intval(round($montant-intval($montant), 2)*100);
    $dix_c=intval($valeur_decimal%100/10);
    $cent_c=intval($valeur_decimal%1000/100);
    $unite[1]=$valeur_entiere%10;
    $dix[1]=intval($valeur_entiere%100/10);
    $cent[1]=intval($valeur_entiere%1000/100);
    $unite[2]=intval($valeur_entiere%10000/1000);
    $dix[2]=intval($valeur_entiere%100000/10000);
    $cent[2]=intval($valeur_entiere%1000000/100000);
    $unite[3]=intval($valeur_entiere%10000000/1000000);
    $dix[3]=intval($valeur_entiere%100000000/10000000);
    $cent[3]=intval($valeur_entiere%1000000000/100000000);
	
    $chif=array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix sept', 'dix huit', 'dix neuf');
        $secon_c='';
        $trio_c='';
    for($i=1; $i<=3; $i++){
        $prim[$i]='';
        $secon[$i]='';
        $trio[$i]='';
        if($dix[$i]==0){
            $secon[$i]='';
            $prim[$i]=$chif[$unite[$i]];
        }
        else if($dix[$i]==1){
            $secon[$i]='';
            $prim[$i]=$chif[($unite[$i]+10)];
        }
        else if($dix[$i]==2){
            if($unite[$i]==1){
            $secon[$i]='vingt et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==3){
            if($unite[$i]==1){
            $secon[$i]='trente et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='trente';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==4){
            if($unite[$i]==1){
            $secon[$i]='quarante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='quarante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==5){
            if($unite[$i]==1){
            $secon[$i]='cinquante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='cinquante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==6){
            if($unite[$i]==1){
            $secon[$i]='soixante et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='soixante';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==7){
            if($unite[$i]==1){
            $secon[$i]='soixante et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='soixante';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        else if($dix[$i]==8){
            if($unite[$i]==1){
            $secon[$i]='quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]];
            }
            else {
            $secon[$i]='quatre-vingt';
            $prim[$i]=$chif[$unite[$i]];
            }
        }
        else if($dix[$i]==9){
            if($unite[$i]==1){
            $secon[$i]='quatre-vingts et';
            $prim[$i]=$chif[$unite[$i]+10];
            }
            else {
            $secon[$i]='quatre-vingts';
            $prim[$i]=$chif[$unite[$i]+10];
            }
        }
        if($cent[$i]==1) $trio[$i]='cent';
        else if($cent[$i]!=0 || $cent[$i]!='') $trio[$i]=$chif[$cent[$i]] .' cents';
    }
     
     
$chif2=array('', 'dix', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'soixante-dix', 'quatre-vingts', 'quatre-vingts dix');
    $secon_c=$chif2[$dix_c];
    if($cent_c==1) $trio_c='cent';
    else if($cent_c!=0 || $cent_c!='') $trio_c=$chif[$cent_c] .' cents';
     
    if(($cent[3]==0 || $cent[3]=='') && ($dix[3]==0 || $dix[3]=='') && ($unite[3]==1))
        echo $trio[3]. '  ' .$secon[3]. ' ' . $prim[3]. ' million ';
    else if(($cent[3]!=0 && $cent[3]!='') || ($dix[3]!=0 && $dix[3]!='') || ($unite[3]!=0 && $unite[3]!=''))
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3]. ' millions ';
    else
        echo $trio[3]. ' ' .$secon[3]. ' ' . $prim[3];
     
    if(($cent[2]==0 || $cent[2]=='') && ($dix[2]==0 || $dix[2]=='') && ($unite[2]==1))
        echo ' mille ';
    else if(($cent[2]!=0 && $cent[2]!='') || ($dix[2]!=0 && $dix[2]!='') || ($unite[2]!=0 && $unite[2]!=''))
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2]. ' milles ';
    else
        echo $trio[2]. ' ' .$secon[2]. ' ' . $prim[2];
     
    echo $trio[1]. ' ' .$secon[1]. ' ' . $prim[1];
     
    echo ' '. $dev1 .' ' ;
     
    /*if(($cent_c=='0' || $cent_c=='') && ($dix_c=='0' || $dix_c==''))
        echo ' et z&eacute;ro '. $dev2;
    else
        echo $trio_c. ' ' .$secon_c. ' ' . $dev2;*/
}
	
?>
<html>
	<head>	<link rel="Stylesheet" type="text/css" media="screen, print" href='style.css' /> 
	<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
	<body>
		<table align='center' border='1'> 
			<tr>
				<td>
					<table align='center' >
						<tr>
							<td width=''><font size='5' align='center'>ARCHEVECHE DE COTONOU</font >  </td>
						<td align='right'> Cotonou le,<?php echo date('d/m/Y');  ?>  </td>
						</tr>
						<tr>
							<td align='center'> <img src='<?php echo $logo; ?>' width='50px' height='50px'></td>
						</tr>
						<tr>
							<td align='center' colspan='2'><font size='4'> Reçu: <i><?php echo $_SESSION['numresch'];?> </i></font></td>
						</tr>
						<tr>
							<td colspan='2' > <font size='5'>Client:</font> <?php echo $_SESSION['nom']." ".$_SESSION['prenom'];?> </td>
						</tr>
						<tr>
							<td> Objet: Réservation de Salle: </td>
							<td> Période du : <?php echo $_SESSION['debut'];  ?>  au  <?php echo $_SESSION['fin'];  ?>
							<?php 
								//$d=date("d/m/Y", mktime(0,0,0,date("m"),date("d")+$_SESSION['np'],date("Y")));
								echo $_SESSION['fi']; 
							?></td>
						</tr>
						<tr>
							<td colspan='2' align='center'>
								<table border='1' align='center' width='100%' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>
									<tr> 
										<td> Désignation</td>
										<td> Tarif </td>
										<td> Durée </td> 
										<td> Montant </td>
									</tr>
									<tr> 
										<?php
											$ret=mysql_query('SELECT * FROM reserversal WHERE numressal="'. $_SESSION['numresch'].'"');
											while ($ret1=mysql_fetch_array($ret))
											{ 
													echo "<td>"; echo($ret1[1]); echo "</td>"; 
													echo "<td>"; echo($ret1[2]); echo "</td>"; 
													echo "<td>"; echo($ret1[3]); echo "</td>"; 
													echo "<td>"; echo($ret1[4]); echo "</td>";  
											}
										?>
									</tr>
									<tr>
										<td> Montant </td>
										<td colspan='3' align='right'> <?php echo $_SESSION['mt'];?> </td>
									</tr>
									<tr>
										<td><b> Somme Payée</b></td>
										<td colspan='3' align='right'><b> <?php echo $_SESSION['av'];?>  </b></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr> 
							<td colspan='2'><font size='4'>Arreté le présent Reçu à la somme de: 
							<?php 
								$p=chifre_en_lettre($_SESSION['mt'], $devise1='Francs CFA', $devise2=''); 
								// echo $p; 
								//echo strtolower($p);
							?></font> </td>
						</tr>
						<tr>
							<td align='right' colspan='2'>Signature,</td>
						</tr>
						<tr> 
							<td align='right' colspan='2'>&nbsp; </td>
						</tr><tr> 
							<td align='right' colspan='2'>&nbsp;</td>
						</tr>
						<tr> 
							<td align='right' colspan='2'>Le Réceptioniste</td>
						</tr>
						<tr>
							<td colspan='2'> <font size='2'>01 BP 429 TEL 21 30 37 27 / 21 15 37 81 E-mail: codiamsa@gmail.com Compte Bancaire B.O.A N°</font></td>
						</tr>
						<tr>
							<td colspan='2'><font size='2'>09784420021 CODIAM HOTEL SARL (ARCHEVECHE DE COTONOU ) REPUBLIQUE DU BENIN</font></td>
						</tr>
							<br> <tr><td>	</td></tr>
					</table><a href="javascript:window.print()"><img src="" style="margin-left:250px;"></a>
				</td>
			</tr>
<?php 
		echo "<table align='center' border='0' style='background-color:white;'> 
			<tr>
				<td>
				<a href=''><img src='logo/im10.jpg' width='80' id='button-imprimer' class='noprt' style='clear:both;'></a>
				</td>
			</tr>
		</table>";	
?>
<script type="text/javascript">
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>

	</body>
</html>