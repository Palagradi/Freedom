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
			 echo "	<table align='center' style='margin-left:15%'>
				<tr>
					<td colspan='10' style='font-size:1.3em;'>
						<B>TABLEAU RECAPITULATIF DES RECETTES DE LA PERIODE du </B>&nbsp;&nbsp;".$_SESSION['se1']."/".$_SESSION['se2']."/".$_SESSION['se3']."&nbsp;&nbsp;<b>Au</b>&nbsp;&nbsp;".$_SESSION['se4']."/".$_SESSION['se5']."/".$_SESSION['se6']."
					</td>
				</tr>
					</table>";
			}
		$debut=$_POST['se3'].'-'.$_POST['se2'].'-'.$_POST['se1'];	
			$fin=$_POST['se6'].'-'.$_POST['se5'].'-'.$_POST['se4'];	
		
		echo "<table align='center'  border='1' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 
				echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
					echo"<td rowspan='2' align='center' > DATE </td> ";
			
			echo"<td colspan='4' align='center' >CHAMBRES</td> ";
			
			/*$te=mysql_query('SELECT count(typesalle) FROM salle');
			$ter=mysql_fetch_array($te);*/
			echo"<td colspan='5' align='center' >SALLES </td> ";
			
			echo"<td colspan='4' align='center' >TAXE SUR NUITE	 </td> ";
			echo"<td rowspan='2' align='center' >TOTAL </td> ";
		echo"</tr> "; 
		echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
			
			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";	
		
			echo"<td> TRIBUNE</td> ";
			echo"<td> GRANDE </td> ";
			echo"<td> REFECTOIRE </td> ";
			echo"<td> CLIMATISEE </td> ";	
			echo"<td> ESPACE </td> ";	
			
			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";
		echo"</tr> ";		
		echo"<tr> "; 
		
		 $i = 0;
		$date=array("");
		$ref=mysql_query("SELECT DISTINCT datencaiss FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss"); 
		while($rerf= mysql_fetch_array($ref))
		{$date[$i] = $rerf['datencaiss'];
		 $i++;
		 }
		 $nbre=mysql_num_rows($ref);
 $somme0=0;
		//while ($rerf=mysql_fetch_array($ref))
		for($i=0;$i<$nbre;$i++)
		{		echo"<tr> "; 		
					echo"<td> "; echo 
					substr($date[$i],8,2).'-'.substr($date[$i],5,2).'-'.substr($date[$i],0,4);echo"</td> ";
						// chambres ventilles simple
						$res=mysql_query("SELECT sum(tarif*np) as som FROM encaissement WHERE datencaiss='".$date[$i]."'  and typeoccup='individuelle'"); 					$rers=mysql_fetch_array($res);
						echo"<td> &nbsp; ";if($rers){echo $somme1=$rers['som']+$rers1['som']+$rers2['som'];}  else {echo '-';} $somme1=$somme0+$somme1;echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$date[$i]."' and typech='V' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$date[$i]."' and typech='V' and typeoccup='double'"); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$date[$i]."' and chambre.typech='V' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme2=$rers['som']+$rers1['som']+$rers2['som'];}  else {echo '-';} $somme2=$somme0+$somme2; echo"</td> "; 					
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$date[$i]."' and typech='CL' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$date[$i]."' and typech='CL' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$date[$i]."' and chambre.typech='CL' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme3=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';}$somme3=$somme0+$somme3;  echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='CL' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$date[$i]."' and typech='CL' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$date[$i]."' and chambre.typech='CL' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme4=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme4=$somme0+$somme4; echo"</td> "; 
						
						// tribune
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."' and typesalle='TB'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."'and salle.typesalle='TB' "); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $rers['sommen']+$rers2['sommen'];} else {echo '-';} echo"</td> "; 
						// grande salle
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."' and typesalle='GS' "); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."'and salle.typesalle='GS' "); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme5=$rers['sommen']+$rers2['sommen'];} else {echo '-';} echo"</td> "; 
						// refectoire
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."' and typesalle='REF'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."'and salle.typesalle='REF' "); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme6=$rers['sommen']+$rers2['sommen'];} else {echo '-';} echo"</td> "; 
						// SALLE CLIMATISE
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."' and typesalle='SL'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."'and salle.typesalle='SL' "); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme7=$rers['sommen']+$rers2['sommen'];} else {echo '-';} echo"</td> "; 
						// ESPACE
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."' and typesalle='ES'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss='".$rerf['datencaiss']."'and salle.typesalle='ES' "); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme8=$rers['sommen']+$rers2['sommen'];} else {echo '-';} echo"</td> "; 							

						//  taxe nuite chambres ventilles simple
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='V' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='V' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme9=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='V' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='V' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme10=2*$rers['som']+2*$rers1['som']+2*$rers2['som'];} else {echo '-';} echo"</td> "; 
						// chambres climatise simple
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='CL' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='CL' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme11=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='CL' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and typech='CL' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme12=2*$rers['som']+2*$rers1['som']+2*$rers2['som'];} else {echo '-';} echo"</td> "; 
						echo"<td> &nbsp; ";  
						echo $somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
						echo"</td> ";
			}
				echo"</tr> "; 
				echo"<tr bgcolor='#5aff99' style='color:red; font-size:16px; '> "; 
					echo"<td align='center'> Total </td>"; 
							$somme0=0;
					// chambres ventilles simple
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'and typech='V' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'and typech='V' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch  and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme1=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme1=$somme0+$somme1; echo"</td> ";				
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typech='V' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'and typech='V' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch  and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme2=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme2=$somme0+$somme2;echo"</td> ";					
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typech='CL' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typech='CL' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch  and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme3=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme3=$somme0+$somme3;echo"</td> ";						
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typech='CL' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(tarif*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typech='CL' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch  and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme4=2*$rers['som']+2*$rers1['som']+2*$rers2['som'];} else {echo '-';} $somme4=$somme0+$somme4;echo"</td> "; 
						
						// tribune						
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='TB'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='TB'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme5=$rers['sommen']+$rers2['sommen'];} else {echo '-';} $somme5=$somme0+$somme5;echo"</td> "; 
						// grande salle
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='GS' "); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='GS'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme6=$rers['sommen']+$rers2['sommen'];} else {echo '-';} $somme6=$somme0+$somme6;echo"</td> "; 
						// refectoire
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='REF' "); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='REF'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme7=$rers['sommen']+$rers2['sommen'];} else {echo '-';} $somme7=$somme0+$somme7;echo"</td> ";  
						// SALLE CLIMATISE
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='SC'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='SC'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme8=$rers['sommen']+$rers2['sommen'];} else {echo '-';} $somme8=$somme0+$somme8;echo"</td> "; 
						// PAILLOTE
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='SR'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='SR'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme9=$rers['sommen']+$rers2['sommen'];} else {echo '-';} $somme9=$somme0+$somme9;echo"</td> "; 
						// ESPACE
						$res=mysql_query("SELECT sum(tarif) as sommen  FROM location,salle, encaissement,compte1 WHERE  encaissement.ref=location.numfiche and  location.numfiche=compte1.numfiche and compte1.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and typesalle='ES'"); 
						$rers=mysql_fetch_array($res);
						$res2=mysql_query("SELECT sum(tarifrc*nuite_payee) as sommen FROM salle, encaissement,reserversal WHERE  encaissement.ref=reserversal.numresch and reserversal.numsalle=salle.numsalle and datencaiss>='".$debut."' and datencaiss<='".$fin."' and salle.typesalle='ES'"); 
						$rers2=mysql_fetch_array($res2);
						//echo"<td> &nbsp; ";if($rers){echo $rers['sommen'];} else {echo '-';} echo"</td> "; 
						
						
						//  taxe nuite chambres ventilles simple
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='V' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='V' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme10=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme10=$somme0+$somme10;echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='V' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='V' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme11=2*$rers['som']+2*$rers1['som']+2*$rers2['som'];} else {echo '-';} $somme11=$somme0+$somme11;echo"</td> "; 
						// chambres climatise simple
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='CL' and typeoccup='individuelle' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='CL' and typeoccup='individuelle' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and reserverch.typeoccuprc='individuelle'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme12=$rers['som']+$rers1['som']+$rers2['som'];} else {echo '-';} $somme12=$somme0+$somme12;echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(ttax*np) as som FROM fiche1,compte,chambre, encaissement WHERE  encaissement.ref=fiche1.numfiche and fiche1.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='CL' and typeoccup='double' "); 
						$rers=mysql_fetch_array($res);
						$res1=mysql_query("SELECT sum(ttax*np) as som FROM view_fiche2,compte,chambre, encaissement WHERE  encaissement.ref=view_fiche2.numfiche and view_fiche2.numfiche=compte.numfiche and compte.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."'  and typech='CL' and typeoccup='double' "); 
						$rers1=mysql_fetch_array($res1);
						$res2=mysql_query("SELECT sum(1000*nuite_payee) as som FROM chambre, encaissement,reserverch WHERE  encaissement.ref=reserverch.numresch and reserverch.numch=chambre.numch and datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and reserverch.typeoccuprc='double'"); 
						$rers2=mysql_fetch_array($res2);
						echo"<td> &nbsp; ";if($rers){echo $somme13=2*$rers['som']+2*$rers1['som']+2*$rers2['som'];} else {echo '-';} $somme13=$somme0+$somme13;echo"</td> "; 
						echo"<td align='center'>";
						echo $somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
						echo"</td>"; 
					 
				echo"</tr> "; 
		echo"</table> ";
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