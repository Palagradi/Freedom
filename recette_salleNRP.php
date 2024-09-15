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
			}
		$exec=mysql_query("UPDATE encaissement SET tarif='21186.4407' WHERE numch ='CRL'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='8474.5763' WHERE numch ='CR'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='29661.0169' WHERE numch ='ES'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='16949.1526' WHERE numch ='TB'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='50847.4577' WHERE numch ='SC'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='25423.7888' WHERE numch ='REF' AND ttc_fixe='30000'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='39830.5085' WHERE numch ='REF' AND ttc_fixe='47000'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='35593.2204' WHERE numch ='GS' AND ttc_fixe='42000'"); 
		$exec=mysql_query("UPDATE encaissement SET tarif='55084.7458' WHERE numch ='GS' AND ttc_fixe='65000'"); 
		
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
		$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
		mysql_query("SET NAMES 'utf8' ");
		$refA=mysql_query("SELECT codesalle,typesalle,tariffete,tarifreunion,numsalle FROM salle"); 
		$nbre_result=mysql_num_rows($refA);
		
		echo "<table align='center'  border='1' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 
				echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
					echo"<td rowspan='2' align='center' > DATE </td> ";
			
			echo"<td colspan='".$nbre_result."' align='center' >MONTANT HT</td> ";
			
			echo"<td colspan='".$nbre_result."' align='center' >TVA </td> ";
			
			echo"<td colspan='4' rowspan='2' align='center' >TOTAL </td> ";
		echo"</tr> "; 
		echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
			
			echo"<td> TRIBUNE</td> ";
			echo"<td> GRANDE SALLE </td> ";
			echo"<td> REFECTOIRE </td> ";
			echo"<td> SALLE CLIMATISEE </td> ";	
			echo"<td> ESPACE </td> ";	
			echo"<td> Case Ronde </td> ";
			echo"<td> Case Ronde CL</td> ";	
			echo"<td> SALLE CLIM BR</td> ";				
		
			echo"<td> TRIBUNE</td> ";
			echo"<td> GRANDE SALLE </td> ";
			echo"<td> REFECTOIRE </td> ";
			echo"<td> SALLE CLIMATISEE </td> ";	
			echo"<td> ESPACE </td> ";	
			echo"<td> Case Ronde </td> ";
			echo"<td> Case Ronde CL</td> ";	
				echo"<td> SALLE CLIM BR</td> ";	
			
		echo"</tr> ";		
		echo"<tr> "; 
			
		$ref=mysql_query("SELECT DISTINCT datencaiss FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss"); 
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
						echo"<td> ";if($rers){echo $somme5=round($rers['som'],4)+round($rers1['som'],4);$somme5=$somme+$somme5;} else {echo '-';} echo"</td> "; 
						// case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme6=round($rers['som'],4);$somme6=$somme+$somme6;} else {echo '-';} echo"</td> "; 
						// case Ronde CL
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CRL'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme66=round($rers['som'],4);$somme66=$somme+$somme66;} else {echo '-';} echo"</td> "; 

	// Salle Clim BR      
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='BR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somm77=round($rers['som'],4);$somme77=$somme+$somme77;} else {echo '-';} echo"</td> "; 						
						
						$ref1=mysql_query("SELECT DISTINCT numfiche FROM exonerer_tva  WHERE date='".$rerf['datencaiss']."' AND numfiche='".$rerf['ref']."'"); 
						$rerf1=mysql_fetch_array($ref1) ; echo $numfiche=$rerf1['numfiche'];
						
						
						// TVA						
						// tribune	
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='TB' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme7=round(0.18*$rers['tva'],4);}  else {echo '-';} $somme7=$somme7+$somme;echo"</td> ";
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='GS' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme8=round(0.18*$rers['tva'],4);}  else {echo '-';} $somme8=$somme8+$somme; echo"</td> "; 						
						// Refectoire
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='REF' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme9=round(0.18*$rers['tva'],4); $somme9=$somme9+$somme; } else {echo '-';} echo"</td> "; 
						// salles climatisee
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='SC' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme10=round(0.18*$rers['tva'],4); $somme10=$somme10+$somme; } else {echo '-';} echo"</td> "; 
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='ES' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  Type_encaisse='Payement Loyer' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers1=mysql_fetch_array($res1);
						echo"<td>  ";if($rers){echo $somme11=round(0.18*$rers['tva'],4)+round(0.18*$rers1['tva'],4);  $somme11=$somme11+$somme;} else {echo '-';} echo"</td> ";	
						//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CR' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme12=round(0.18*$rers['tva'],4); $somme12=$somme12+$somme;} else {echo '-';} echo"</td> "; 						
						//  case Ronde CL
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='CRL' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme122=round(0.18*$rers['tva'],4); $somme122=$somme122+$somme;} else {echo '-';} echo"</td> "; 
					
						
						
	//  Salle Clim BR  
					
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND  numch='BR' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme222=round(0.18*$rers['tva'],4); $somme222=$somme222+$somme;} else {echo '-';} echo"</td> "; 
						
						
						echo"<td align='center'>";
						
					$resT=mysql_query("SELECT sum(tarif*np) as VTA  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle')AND ref IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss='".$rerf['datencaiss']."') "); 
					$rersT=mysql_fetch_assoc($resT);$sVTT=round(0.18*$rersT['VTA'],4);
					
						$resT=mysql_query("SELECT sum(tarif*np) as VTA  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle')AND ref IN(SELECT numfiche FROM exonerer_aib WHERE  datencaiss='".$rerf['datencaiss']."') "); 
					$rersT=mysql_fetch_assoc($resT); $aib=round((0.01*$rersT['VTA']),4);
					
					$res=mysql_query("SELECT sum(ttc_fixe*np) as var  FROM  encaissement WHERE  datencaiss='".$rerf['datencaiss']."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle')"); 
					$rers=mysql_fetch_array($res);$var=$rers['var'];if($sVTT>0) $var-=$sVTT;if($aib>0) $var-=$aib;
					if(is_int($rers['var']))
						echo $var;
					else
						echo round($var,4);
					echo"</td>";
			}
				$somme=0;
				echo"</tr> "; 
					echo"<tr bgcolor='' style='font-weight:bold; font-size:16px; '> "; 
					echo"<td align='center'> Total </td>"; 
						// tribune	
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='TB'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme1=round($rers['som'],4);$somme1=$somme1+$somme;} else {echo '-';} echo"</td> ";				
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='GS'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme2=round($rers['som'],4);$somme2=$somme2+$somme;} else {echo '-';} echo"</td> ";		
						// refectoire
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='REF'"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme3=round($rers['som'],4);$somme3=$somme3+$somme;} else {echo '-';} echo"</td> ";	
						// salle climatisee 
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='SC'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme4=round($rers['som'],4);$somme4=$somme4+$somme;} else {echo '-';} echo"</td> ";						
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='ES'"); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  Type_encaisse='Payement Loyer'"); 
						$rers1=mysql_fetch_array($res1);
						echo"<td>";if($rers){echo $somme5=round($rers['som'],4)+round($rers1['som'],4);$somme5=$somme5+$somme;} else {echo '-';} echo"</td> ";
						//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme6=round($rers['som'],4);$somme6=$somme6+$somme;} else {echo '-';} echo"</td> "; 
						//  case Ronde CL
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CRL'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme66=round($rers['som'],4);$somme66=$somme66+$somme;} else {echo '-';} echo"</td> "; 
						
						
	//  Salle CLIM BR
						$res=mysql_query("SELECT sum(tarif*np) as som  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='BR'"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme666=round($rers['som'],4);$somme666=$somme666+$somme;} else {echo '-';} echo"</td> ";
						
						
						// TVA						

						// Tribune
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='TB' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme7=round(0.18*$rers['tva'],4);$somme7=$somme7+$somme; } else {echo '-';} echo"</td> "; 
						// Grande salle
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='GS' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme8=round(0.18*$rers['tva'],4);$somme8=$somme8+$somme; } else {echo '-';} echo"</td> "; 	
						// refectoire
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='REF' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme9=round(0.18*$rers['tva'],4);$somme9=$somme9+$somme; } else {echo '-';} echo"</td> "; 						
						//	salle climatisee 				
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='SC' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme10=round(0.18*$rers['tva'],4);$somme10=$somme10+$somme; } else {echo '-';} echo"</td> "; 
						// ESPACE
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='ES' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  Type_encaisse='Payement Loyer' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers1=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme11=round(0.18*$rers['tva'],4)+round(0.18*$rers1['tva'],4);$somme11=$somme11+$somme; } else {echo '-';} echo"</td> "; 	
						//  case Ronde
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CR' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme12=round(0.18*$rers['tva'],4);$somme12=$somme12+$somme; } else {echo '-';} echo"</td> "; 	
						//  case Ronde CL
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='CRL' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme122=round(0.18*$rers['tva'],4);$somme122=$somme122+$somme; } else {echo '-';} echo"</td> ";
		
		
		//  Salle clim BR
						$res=mysql_query("SELECT sum(tarif*np) as tva  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND  numch='BR' AND ref NOT IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme1222=round(0.18*$rers['tva'],4);$somme1222=$somme1222+$somme; } else {echo '-';} echo"</td> ";
						echo"<td align='center'>";

						
					$resV=mysql_query("SELECT sum(tarif*np) as VTA  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle')AND ref IN(SELECT numfiche FROM exonerer_tva WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."') "); 
					$rersV=mysql_fetch_assoc($resV);$sVTA=round(0.18*$rersV['VTA'],4); 
					
						$resT=mysql_query("SELECT sum(tarif*np) as VTA  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle')AND ref IN(SELECT numfiche FROM exonerer_aib WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."') "); 
					$rersT=mysql_fetch_assoc($resT); $aib=round((0.01*$rersT['VTA']),4);
					
					$res=mysql_query("SELECT sum(ttc_fixe*np) as var  FROM  encaissement WHERE  datencaiss>='".$debut."' and datencaiss<='".$fin."' AND Type_encaisse IN ('Reservation salle','Location salle','Payement Loyer','Encaissement salle') "); 
					$rers=mysql_fetch_array($res);$var=$rers['var'];if($sVTA>0) $var-=$sVTA;if($aib>0) $var-=$aib;
					if(is_int($var))
						echo $var;
					else
						echo round($var,4);
					echo"</td>";
											 
				echo"</tr> "; 
		echo"</table> ";
		
				
		if(!empty($sVTA)) {echo"<br/>Total TVA Exoneré au cours de la période :&nbsp;<b> ".$sVTA." </b> ";}
		
		if(!empty($aib)) {echo"<br/>Total AIB Exoneré au cours de la période :&nbsp;<b> ".$aib." </b> ";}
		
		$ref3=mysql_query("SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND objet NOT IN ('Hébergement','Hebergement','Facture de groupe')");
		$data=mysql_fetch_assoc($ref3);$remise=$data['Remise'];
		
		if(!empty($remise)) {echo"<br/><span style=''>
		Total des Remises accordées durant la période :&nbsp;<b> ".$remise."&nbsp;F CFA</b> </span>";}
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