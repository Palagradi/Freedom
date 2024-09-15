<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
	<head>
		<title>SYGHOC</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" media="screen" type="text/css" title="design" href="design.css"/>	
		<style type="text/css">
		@media print { .noprt {display:none} }
	</style>
	</head>
<body>
<?php 
		//header("Content-type: application/vnd.ms-excel");
		//session_start();
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
		$_SESSION['debut']=$debut;$_SESSION['fin']=$fin;
		$_SESSION['se1']=$_POST['se1'];$_SESSION['se2']=$_POST['se2'];
		$_SESSION['se3']=$_POST['se3'];$_SESSION['se4']=$_POST['se4'];
		$_SESSION['se5']=$_POST['se5'];$_SESSION['se6']=$_POST['se6'];
		echo "<table align='center'  border='1' cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'> "; 
				echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
				echo"<td rowspan='2' align='center' > DATE </td> ";
			
			echo"<td colspan='4' align='center' >MONTANT HT</td> ";
			
			echo"<td colspan='4' align='center' >TVA </td> ";
			
			echo"<td colspan='4' align='center' >TAXE SUR NUITE	 </td> ";
			echo"<td colspan='4' rowspan='2' align='center' >TOTAL </td> ";
		echo"</tr> "; 
		echo"<tr bgcolor='#eeee99' style='color:purple; font-size:16px; '> ";
			
			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";	
		
			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";
			
			echo"<td align='CENTER'> VENTILLE SIMPLE</td> ";
			echo"<td align='CENTER'> VENTILLE DOUBLE </td> ";
			echo"<td align='CENTER'>CLIMATISE SIMPLE</td> ";
			echo"<td align='CENTER'>CLIMATISE DOUBLE </td> ";
		echo"</tr> ";		
		echo"<tr> "; 
		
		$ref=mysql_query("SELECT DISTINCT datencaiss FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."' ORDER BY datencaiss ");		
		$somme0=0;$somme1=0;$somme2=0;$somme3=0;$somme4=0;$somme5=0;$somme6=0;$somme7=0;$somme8=0;$somme9=0;$somme10=0;$somme11=0;$somme12=0;
		//echo "SELECT compte.N_reel,compte.np FROM fiche1,compte WHERE fiche1.numfiche=compte.numfiche AND compte.numfiche=encaissement.ref AND fiche1.datarriv >='".$debut."' AND fiche1.datarriv <='".$fin."' ORDER BY fiche1.datarriv";
		$var=0;
		while ($rerf=mysql_fetch_array($ref))
		{		echo"<tr> "; 		
					echo"<td> "; echo 
					substr($rerf['datencaiss'],8,2).'-'.substr($rerf['datencaiss'],5,2).'-'.substr($rerf['datencaiss'],0,4);echo"</td> ";
						// chambres ventilles simple
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='individuelle'  AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
							echo"<td> ";if($rers){echo $somme1=round($rers['som'],4);}  else {echo '-';} $var+=$somme1;echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='double'  AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
							echo"<td> ";if($rers){echo $somme2=round($rers['som'],4);}  else {echo '-';} $var+=$somme2; echo"</td> "; 					
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='individuelle'  AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
							echo"<td> ";if($rers){echo $somme3=round($rers['som'],4);} else {echo '-';} $var+=$somme3;echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
							echo"<td>";if($rers){echo $somme4=round($rers['som'],4);} else {echo '-';} $var+=$somme4; echo"</td> "; 
						$datencaiss=$rerf['datencaiss']; $exoneree_tva=0;
						
						// TVA
						// chambres ventilles simple
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");  
						$rerf1=mysql_fetch_array($ref1) ;  $tva=$rerf1['tva'];	$somme5=$tva-$exonerer_tva;	$somme5=round($somme5,4); 					
							echo"<td align=''>  ";if($somme5>0){echo $somme5;}  else {echo 0;} $var+=$somme5;echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);   $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");  
						$rerf1=mysql_fetch_array($ref1) ;   $tva=$rerf1['tva'];	$somme6=$tva-$exonerer_tva;	$somme6=round($somme6,4); 
							echo"<td> ";if($somme6>0){echo $somme6;}  else {echo 0;} $var+=$somme6; echo"</td> "; 					
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");  
						$rerf1=mysql_fetch_array($ref1) ;  $tva=$rerf1['tva'];$somme7=$tva-$exonerer_tva;	$somme7=round($somme7,4);  
							echo"<td>  ";if($somme7>0){echo $somme7;} else {echo 0;} $var+=$somme7;echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");  
						$rerf1=mysql_fetch_array($ref1) ;  $tva=$rerf1['tva'];$somme8=$tva-$exonerer_tva;	$somme8=round($somme8,4); 
							echo"<td> ";if($somme8>0){echo $somme8;} else {echo 0;} $var+=$somme8;echo"</td> ";				
								
						//  taxe nuite chambres ventilles simple
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme9=1000*$rers['np'];} else {echo '-';} $var+=$somme9;echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>";if($rers){echo $somme10=2000*$rers['np'];} else {echo '-';} $var+=$somme10;echo"</td> "; 
						// chambres climatise simple
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td> ";if($rers){echo $somme11=1000*$rers['np'];} else {echo '-';} $var+=$somme11;echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss='".$rerf['datencaiss']."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme12=2000*$rers['np'];} else {echo '-';} $var+=$somme12;echo"</td> "; 

						//$var=$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
						$res=mysql_query("SELECT * FROM encaissement WHERE datencaiss='".$rerf['datencaiss']."'"); 
						while ($ret=mysql_fetch_array($res)) 
							{			$var0=$ret['ttc_fixe']*$ret['np'].''; 
							}
						
						$res=mysql_query("SELECT * FROM exonerer_tva WHERE date='".$rerf['datencaiss']."'"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=$rers['date']; 
						$res=mysql_query("SELECT * FROM exonerer_aib WHERE date='".$rerf['datencaiss']."'"); 
						$rers=mysql_fetch_array($res);  $exonerer_aib=$rers['date']; 
						
						if(empty($exonerer_tva)&& empty($exonerer_aib))
							{echo"<td align=''>"; echo $var0=(int)($var); echo"</td> ";}
						else
							{echo"<td align=''> "; echo $var0=round($var,4); echo"</td> ";}
				
				$var=0;
			} 
				echo"</tr> "; 
				$somme0=0;
				echo"<tr bgcolor='' style='font-weight:bold; font-size:16px; '> "; 
					echo"<td align='center'>  Total </td>"; 
					// chambres ventilles simple
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme1=round($rers['som'],4);$somme1=($somme0+$somme1);} else {echo '-';} echo"</td> ";				
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme2=round($rers['som'],4);$somme2=($somme0+$somme2);} else {echo '-';}echo"</td> ";					
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme3=round($rers['som'],4);$somme3=($somme0+$somme3);} else {echo '-';} echo"</td> ";						
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as som,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')");
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme4=round($rers['som'],4);$somme4=($somme0+$somme4);} else {echo '-';} echo"</td> "; 
						
						$exoneree_tva=0;
						// TVA	
						// chambres ventilles simple						
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rerf1=mysql_fetch_array($ref1) ;  $tva=round($rerf1['tva'],4); $somme5=round($tva-$exonerer_tva,4); 
						echo"<td>  ";if($somme5>0){echo $somme5; $somme5=($somme0+$somme5);} else {echo 0;} echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rerf1=mysql_fetch_array($ref1) ;  $tva=round($rerf1['tva'],4); $somme6=round($tva-$exonerer_tva,4); 
						echo"<td>  ";if($somme6>0){echo $somme6; $somme6=($somme0+$somme6);} else {echo 0;} echo"</td> "; 
						// chambres climatise simple
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rerf1=mysql_fetch_array($ref1) ;  $tva=round($rerf1['tva'],4); $somme7=round($tva-$exonerer_tva,4); 
						echo"<td>  ";if($somme7>0){echo $somme7; $somme7=($somme0+$somme7);} else {echo 0;} echo"</td> ";  
						// chambres climatise double
						$res=mysql_query("SELECT sum(tarif*np) as tva FROM encaissement,chambre,exonerer_tva WHERE encaissement.ref =exonerer_tva.numfiche AND chambre.numch=encaissement.numch AND date>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=round(0.18*$rers['tva'],4); 
						$ref1=mysql_query("SELECT sum(0.18*tarif*np) as tva,sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rerf1=mysql_fetch_array($ref1) ;  $tva=round($rerf1['tva'],4); $somme8=round($tva-$exonerer_tva,4); 
						echo"<td>  ";if($somme8>0){echo $somme8; $somme8=($somme0+$somme8);} else {echo 0;} echo"</td> "; 
						
						//  taxe nuite chambres ventilles simple
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe') ");  
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme9=1000*$rers['np'];$somme9=($somme0+$somme9);} else {echo '-';} echo"</td> "; 
						// chambres ventilles double
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='V' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme10=2000*$rers['np'];$somme10=($somme0+$somme10);} else {echo '-';} echo"</td> "; 
						// chambres climatise simple
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='individuelle' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme11=1000*$rers['np'];$somme11=($somme0+$somme11);} else {echo '-';} echo"</td> "; 
						// chambres climatise double
						$res=mysql_query("SELECT sum(np) AS np FROM encaissement,chambre WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' and chambre.typech='CL' and encaissement.typeoccup='double' AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						$rers=mysql_fetch_array($res);
						echo"<td>  ";if($rers){echo $somme12=2000*$rers['np'];$somme12=($somme0+$somme12);} else {echo '-';} echo"</td> "; 
						echo"<td>";
						
						
						$res=mysql_query("SELECT * FROM exonerer_tva WHERE date>='".$debut."' and date<='".$fin."'"); 
						$rers=mysql_fetch_array($res);  $exonerer_tva=$rers['date']; 
						$res=mysql_query("SELECT * FROM exonerer_aib WHERE date>='".$debut."' and date<='".$fin."'"); 
						$rers=mysql_fetch_array($res);  $exonerer_aib=$rers['date']; 
						
				    $var=$somme1+$somme2+$somme3+$somme4+$somme5+$somme6+$somme7+$somme8+$somme9+$somme10+$somme11+$somme12;
						$res=mysql_query("SELECT sum(ttc_fixe*np) AS ttc_fixe FROM encaissement WHERE datencaiss>='".$debut."' and datencaiss<='".$fin."'AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
						while ($ret=mysql_fetch_array($res)) 
							{			//$var=$ret['ttc_fixe']; 
							}
					if(empty($exonerer_tva)&& empty($exonerer_aib))
							{echo $var=(int)($var);}
						else
							{ echo $var=round($var,4);}
					
					echo"</td>"; 					 
				echo"</tr> "; 
		echo"</table> ";$aib=0;
		//$ref1=mysql_query("SELECT sum(tarif*np*0.01) as aib FROM exonerer_aib,encaissement,chambre  WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' AND numfiche=encaissement.ref AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
	    $ref1=mysql_query("SELECT DISTINCT encaissement.numch AS numch,encaissement.typeoccup AS typeoccup,np AS np FROM exonerer_aib,encaissement,chambre  WHERE chambre.numch=encaissement.numch AND datencaiss>='".$debut."' and datencaiss<='".$fin."' AND numfiche=encaissement.ref AND Type_encaisse IN ('Entree chambre','Encaissement chambre','Sortie chambre','Impayee fiche individuelle','Facture de groupe')"); 
		while($row_1=mysql_fetch_array($ref1))
			{  $numch=$row_1['numch'];
			   $typeoccup=$row_1['typeoccup'];
			   $np=$row_1['np'];
			   if($typeoccup=='individuelle')
			   { $ref2=mysql_query("SELECT tarifsimple FROM chambre  WHERE numch='$numch'");
					while($row_2=mysql_fetch_array($ref2))
						{$tarifsimple=$np*$row_2['tarifsimple'];
						}
			   }
			   else
			   { $ref2=mysql_query("SELECT tarifdouble FROM chambre  WHERE numch='$numch'");
					while($row_2=mysql_fetch_array($ref2))
						{$tarifdouble=$np*$row_2['tarifdouble'];
						}
			   }
			   $aib=$tarifsimple+$tarifdouble;
			}			
			$aib=round((0.01*$aib),4);	
		if(!empty($aib)) {echo"<br/><span style='font-size:1.1em;'>Total AIB Exoneré au cours de la période :&nbsp;<b> ".$aib." </b> </span> ";}
		
		$ref3=mysql_query("SELECT SUM(Remise) AS Remise FROM reedition_facture WHERE  date_emission>='".$debut."' and date_emission<='".$fin."' AND objet IN ('Hébergement','Hebergement','Facture de groupe')");
		$data=mysql_fetch_assoc($ref3);$remise=$data['Remise'];
		
		if(!empty($remise)) {echo"<br/><span style='font-size:1.1em;'>Total des Remises accordées durant la période :&nbsp;<b> ".$remise."&nbsp;F CFA</b> </span>";}
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