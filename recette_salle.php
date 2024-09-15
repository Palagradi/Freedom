<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>IRPP - RF</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>	
		<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
<body>
<?php 

		include 'connexion.php'; 
			if($_POST['excel']==1)
			{header("Content-type: application/vnd.ms-excel");
/* 			 echo "	<table align='center' style='margin-left:15%'>
				<tr>
					<td colspan='10' style='font-size:1.3em;'>
						<B>TABLEAU RECAPITULATIF DES RECETTES DE LA PERIODE du </B>&nbsp;&nbsp;".$_SESSION['se1']."/".$_SESSION['se2']."/".$_SESSION['se3']."&nbsp;&nbsp;<b>Au</b>&nbsp;&nbsp;".$_SESSION['se4']."/".$_SESSION['se5']."/".$_SESSION['se6']."
					</td>
				</tr>
					</table>"; */
			}
			
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
		$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
		
		$refA=mysql_query("SELECT codesalle,typesalle,tariffete,tarifreunion,numsalle FROM salle"); 
		$nbre_result=mysql_num_rows($refA);
		
		echo "<table align='center'  border='1' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 
				echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
					echo"<td rowspan='2' align='center' > DATE </td> ";
			
			echo"<td colspan='7' align='center' >MONTANT HT</td> ";
			
			echo"<td colspan='7' align='center' >TVA </td> ";
			
			echo"<td colspan='4' rowspan='2' align='center' >TOTAL </td> ";
		echo"</tr> "; 
		echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
			
			while ($rerfA=mysql_fetch_array($refA))
			{ echo"<td>".strtoupper($rerfA['codesalle'])."</td> ";
			}			
		
			echo"<td> TRIBUNE</td> ";
			echo"<td> GRANDE SALLE </td> ";
			echo"<td> REFECTOIRE </td> ";
			echo"<td> SALLE CLIMATISEE </td> ";	
			echo"<td> ESPACE </td> ";	
			echo"<td> Case Ronde </td> ";
			
		echo"</tr> ";		
		echo"<tr> "; 
			
		$ref=mysql_query("SELECT DISTINCT datencaiss,ref FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' AND typeoccup='' ORDER BY datencaiss"); 
		$somme=0;
		while ($rerf=mysql_fetch_array($ref))
		{		echo"<tr> "; 		
					echo"<td> "; echo 
					substr($rerf['datencaiss'],8,2).'-'.substr($rerf['datencaiss'],5,2).'-'.substr($rerf['datencaiss'],0,4);echo"</td> ";
						// tribune	
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='TB'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme1=round($rers['som'],4);}  else {echo '-';} $somme1=$somme+$somme1;echo"</td> "; 
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='GS'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme2=round($rers['som'],4);}  else {echo '-';} $somme2=$somme+$somme2; echo"</td> "; 
						// Refectoire
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='REF'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme3=round($rers['som'],4);$somme3=$somme+$somme3;} else {echo '-';} echo"</td> ";						
						// salles climatisee
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='SC'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme4=round($rers['som'],4);$somme4=$somme+$somme4;} else {echo '-';} echo"</td> "; 
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='ES'"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  Type_encaisse='Payement Loyer'"); 
						$rers1=mysql_fetch_array($res1);
						echo"<td> &nbsp; ";if($rers){echo $somme5=round($rers['som'],4)+$somme5=round($rers1['som'],4);$somme5=$somme+$somme5;} else {echo '-';} echo"</td> "; 
						// case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme6=round($rers['som'],4);$somme6=$somme+$somme6;} else {echo '-';} echo"</td> "; 						
						
						// TVA
						
						$ref1=mysql_query("SELECT DISTINCT numfiche FROM exonerer_tva  WHERE date='".$rerf['datencaiss']."' AND numfiche='".$rerf['ref']."'"); 
						$rerf1=mysql_fetch_array($ref1) ;  $numfiche=$rerf1['numfiche'];
						
						$ref_1=mysql_query("SELECT DISTINCT numfiche FROM exonerer_tva  WHERE date='".$rerf['datencaiss']."'"); 
						$rerf_1=mysql_fetch_array($ref_1) ;   $numfiche1=$rerf_1['numfiche'];
						
						//echo "SELECT DISTINCT numfiche FROM exonerer_tva  WHERE date='".$rerf['datencaiss']."' AND numfiche='".$rerf['ref']."'";
						
						// tribune	
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='TB'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche))
						{echo"<td>";if($rers){echo $somme7=round(0.18*$rers['tva'],4);}  else {echo '-';} $somme7=$somme7+$somme;echo"</td> "; }
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='TB' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td>";if($rers){echo $somme7=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme7=$somme7+$somme;echo"</td> ";
						}
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='GS'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche))
						{echo"<td> ";if($rers){echo $somme8=round(0.18*$rers['tva'],4);}  else {echo '-';} $somme8=$somme8+$somme; echo"</td> "; }
						else{
						$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='GS' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>  ";if($rers){ $somme8=0.18*$rers['tva']-(0.18*$rers2['tva']); echo"<span style='font-size:0.7em;'>TVA Exonérée</span>";}  else {echo '-';} $somme8=$somme8+$somme;echo"</td> ";
						}						
						
						// Refectoire
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='REF'");
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td>";if($rers){echo $somme9=round(0.18*$rers['tva'],4); $somme9=$somme9+$somme; } else {echo '-';} echo"</td> "; }
						else{
						$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='REF' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>  ";if($rers){ $somme9=0.18*$rers['tva']-(0.18*$rers2['tva']);echo"<span style='font-size:0.7em;'>TVA Exonérée</span>";}  else {echo '-';} $somme9=$somme9+$somme;echo"</td> ";
						}
						// salles climatisee
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='SC'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td>  ";if($rers){echo $somme10=round(0.18*$rers['tva'],4); $somme10=$somme10+$somme; } else {echo '-';} echo"</td> ";} 
						else{
						$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='SC' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>  ";if($rers){ $somme10=0.18*$rers['tva']-(0.18*$rers2['tva']); echo"<span style='font-size:0.7em;'>TVA Exonérée</span>";}  else {echo '-';} $somme10=$somme10+$somme;echo"</td> ";
						}// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='ES'"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  Type_encaisse='Payement Loyer'"); 
						$rers1=mysql_fetch_array($res1);
						if(empty($numfiche)){echo"<td> ";if($rers){echo $somme11=round(0.18*$rers['tva'],4)+round(0.18*$rers1['tva'],4);  $somme11=$somme11+$somme;} else {echo '-';} echo"</td> ";}	
						else{
						$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='ES' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>  ";if($rers){ $somme11=0.18*$rers['tva']-(0.18*$rers2['tva']);echo"<span style='font-size:0.7em;'>TVA Exonérée</span>";}  else {echo '-';} $somme11=$somme11+$somme;echo"</td> ";
						}//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td> ";if($rers){echo $somme12=round(0.18*$rers['tva'],4); $somme12=$somme12+$somme;} else {echo '-';} echo"</td> "; 	}					
						 else {$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CR' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td>  ";if($rers2){echo $somme12=0.18*$rers2['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme12=$somme12+$somme;echo"</td> ";
						 }
						//}
						echo"<td align='center'>";
					if(empty($numfiche1)) {echo $var=(int)($somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12);
					}	
					else 
					{echo $var=$somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
					}
					echo"</td>";
			}
				$somme=0;
				echo"</tr> "; 
				echo"<tr bgcolor='#5aff99' style='color:red; font-size:16px; '> "; 
					echo"<td align='center'> Total </td>"; 
						// tribune	
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='TB'"); 
						$rers=mysql_fetch_array($res);
						echo"<td align='center'>";if($rers){echo $somme1=round($rers['som'],4);$somme1=$somme1+$somme;} else {echo '-';} echo"</td> ";				
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='GS'"); 
						$rers=mysql_fetch_array($res);
						echo"<td align='center'> ";if($rers){echo $somme2=round($rers['som'],4);$somme2=$somme2+$somme;} else {echo '-';} echo"</td> ";		
						// refectoire
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='REF'"); 
						$rers=mysql_fetch_array($res);
						echo"<td align='center'>";if($rers){echo $somme3=round($rers['som'],4);$somme3=$somme3+$somme;} else {echo '-';} echo"</td> ";	
						// salle climatisee 
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='SC'"); 
						$rers=mysql_fetch_array($res);
						echo"<td align='center'>";if($rers){echo $somme4=round($rers['som'],4);$somme4=$somme4+$somme;} else {echo '-';} echo"</td> ";						
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='ES'"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  Type_encaisse='Payement Loyer'"); 
						$rers1=mysql_fetch_array($res1);
						echo"<td align='center'>";if($rers){echo $somme5=round($rers['som'],4)+round($rers1['som'],4);$somme5=$somme5+$somme;} else {echo '-';} echo"</td> ";
						//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td align='center'> ";if($rers){echo $somme6=round($rers['som'],4);$somme6=$somme6+$somme;} else {echo '-';} echo"</td> "; 

						
						// TVA						

						// Tribune
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='TB'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td align='center'>";if($rers){echo $somme7=round(0.18*$rers['tva'],4);$somme7=$somme7+$somme; } else {echo '-';} echo"</td> "; }
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='TB' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>";if($rers){echo $somme7=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme7=$somme7+$somme;echo"</td> ";
						}// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='GS'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td align='center'>";if($rers){echo $somme8=round(0.18*$rers['tva'],4);$somme8=$somme8+$somme; } else {echo '-';} echo"</td> "; }	
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='GS' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>";if($rers){echo $somme8=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme8=$somme8+$somme;echo"</td> ";
						}
						// refectoire
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='REF'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td align='center'>";if($rers){echo $somme9=round(0.18*$rers['tva'],4);$somme9=$somme9+$somme; } else {echo '-';} echo"</td> "; }						
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='REF' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>";if($rers){echo $somme9=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme9=$somme9+$somme;echo"</td> ";
						}
						//	salle climatisee 				
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='SC'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td align='center'>";if($rers){echo $somme10=round(0.18*$rers['tva'],4);$somme10=$somme10+$somme; } else {echo '-';} echo"</td> "; }
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='SC' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>";if($rers){echo $somme10=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme10=$somme10+$somme;echo"</td> ";
						}
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='ES'"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  Type_encaisse='Payement Loyer'"); 
						$rers1=mysql_fetch_array($res1);
						if(empty($numfiche)){echo"<td align='center'>";if($rers){echo $somme11=round(0.18*$rers['tva'],4)+round(0.18*$rers1['tva'],4);$somme11=$somme11+$somme; } else {echo '-';} echo"</td> "; }	
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='ES' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'>";if($rers){echo $somme11=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme11=$somme11+$somme;echo"</td> ";
						}
						//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						if(empty($numfiche)) {echo"<td align='center'>";if($rers){echo $somme12=round(0.18*$rers['tva'],4);$somme12=$somme12+$somme; } else {echo '-';} echo"</td> "; }	
						else
						{$res2=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CR' AND ref='$numfiche'"); 
						 $rers2=mysql_fetch_array($res2);
						 echo"<td align='center'> ";if($rers){echo $somme12=0.18*$rers['tva']-(0.18*$rers2['tva']);}  else {echo '-';} $somme12=$somme12+$somme;echo"</td> ";
						}
						echo"<td align='center'>";
					//if(empty($numfiche)) {
					//echo $var=(int)($somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12);
					//}
					//else
					// {
					 echo $var=$somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
					// }
					echo"</td>";											 
				echo"</tr> "; 
		echo"</table> "; 
				$ref3=mysql_query("SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND objet NOT IN ('Hébergement','Hebergement','Facture de groupe')");
		$data=mysql_fetch_assoc($ref3);$remise=$data['Remise'];
		
		if(!empty($remise)) {echo"<br/><span style='font-size:1.1em;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;Total des Remises accordées durant la période :&nbsp;<b> ".$remise."&nbsp;F CFA</b> </span>";}
?>
<script type='text/javascript'>
   var bouton = document.getElementById('button-imprimer');
bouton.onclick = function(e) {
  e.preventDefault();
  print();
}
 </script>
 </body>
  </html>