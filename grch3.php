<?php
    $sal=!empty($_GET['sal'])?$_GET['sal']:NULL;
	$trie=!empty($_GET['trie'])?$_GET['trie']:NULL;
	include 'menu.php'; 
	//echo $_SESSION['exhonerer_tva'];
	unset($_SESSION['numresch']); unset($_SESSION['remise']);unset($_SESSION['exhonerer_aib']);unset($_SESSION['exhonerer_tva']);unset($_SESSION['aIb']);unset($_SESSION['tVa']);
	$moisT = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aôut","Septembre","Octobre","Novembre","Décembre");
echo '<html>
	<head> 
		<link rel="Stylesheet" type="text/css" media="screen, print" href="style.css" /> 
	</head>
	<body bgcolor="azure"" style="">
	<div align="" style="">';
	
	$query=mysqli_query($con,"DELETE FROM  reservationch WHERE numresch =''");
	$query=mysqli_query($con,"DELETE FROM  reserverch WHERE numresch =''");
	$query=mysqli_query($con,"DELETE FROM  reservationsal WHERE numresch =''");
	$query=mysqli_query($con,"DELETE FROM  reserversal WHERE numresch =''");
	
	//Défalcation automatique si le client ayant reservé ne vient pas ou ne demande pas une modification de sa reservation
		$datej=date('Y-m-d');
		$i = 1; $reserv=array("");
		$sql=mysqli_query($con,"SELECT num_reserv FROM reservation_tempon");
		$nbre=mysqli_num_rows($sql);
		while($result = mysqli_fetch_array($sql))
		{$reserv[$i] = $result['num_reserv'];
		 $i++;
		 }
		$or="SELECT distinct reservationch.numresch,chambre.typech,reservationch.nomdemch,reservationch.datarrivch,reservationch.prenomdemch,reservationch.codegrpe,reserverch.avancerc,reserverch.typeoccuprc  FROM chambre,reservationch,reserverch WHERE reservationch.numch=chambre.numch AND reservationch.numresch=reserverch.numresch and reservationch.datarrivch='".date('Y-m-d')."' AND reservationch.numresch NOT IN(SELECT num_reserv FROM reservation_tempon)";
		$or1=mysqli_query($con,$or);
		if($or1)
		{ while ($roi= mysqli_fetch_array($or1))
			{  $numresch=$roi['numresch'];   $typech=$roi['typech'];   $avancerc=$roi['avancerc'];   $typeoccuprc=$roi['typeoccuprc']; 	  $date=$roi['datarrivch'];
			  $d=substr($date,8,2);	  $m=substr($date,5,2);	  $y=substr($date,0,4);	  $day=date("Y-m-d");   $dat=date('H:i'); 
			   //if($dat>='23:58') 
				//{	 echo "<br/>".$dat;
				// for($j=0;j<$nbre;$j++)
						//{
						//if(($numresch)!=($reserv[$i]))
							//{   
							if(($typeoccuprc=='individuelle')&&($typech=='V'))
									{//$ri=mysqli_query("UPDATE reservationch SET avancerc=avancerc-7500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query("UPDATE reserverch SET avancerc=avancerc-7500 WHERE numresch='$numresch'");
									 $defalquer=7500;
									}
								 if(($typeoccuprc=='individuelle')&&($typech=='CL'))
									{//$ri=mysqli_query("UPDATE reservationch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query("UPDATE reserverch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 $defalquer=12000;
									}
								if(($typeoccuprc=='double')&&($typech=='V'))
									{//$ri=mysqli_query("UPDATE reservationch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 //$ri=mysqli_query("UPDATE reserverch SET avancerc=avancerc-9500 WHERE numresch='$numresch'");
									 $defalquer=9500;
									}
								if(($typeoccuprc=='double')&&($typech=='CL'))
									{//$ri=mysqli_query("UPDATE reservationch SET avancerc=avancerc-14000 WHERE numresch='$numresch'");
									 //$ri=mysqli_query("UPDATE reserverch SET avancerc=avancerc-14000 WHERE numresch='$numresch'");
									 $defalquer=14000;
									}
							//}
							//$ret="INSERT INTO reservation_tempon2 VALUES('$day','$numresch','$defalquer','NON')"; 
							//$req=mysqli_query($ret);
						//}		
				//}
			}
		}
		$date_jour=date("Y-m-d");
		$heure=date('H:i');
		$or="SELECT * FROM reservation_tempon2";
		$or1=mysqli_query($con,$or);
		if($or1)
		{ while ($roi= mysqli_fetch_array($or1))
			{   $date=$roi['jour'];
				$d=substr($date,8,2);
				$m=substr($date,5,2);
				$y=substr($date,0,4);
				//$date=($y.'-'.$m.'-'.$d);
			    $num_reserv=$roi['num_reserv'];
			    $defalquer=isset($roi['defalquer'])?$roi['defalquer']:0;
				$Etat=isset($roi['Etat'])?$roi['Etat']:0;
			    $date_suivant=date("Y-m-d", mktime(0,0,0,$m,$d+1,$y));
				if($date!=$date_jour)
					{	if(($heure>'11:59')&&($date_jour==$date_suivant)) 
							{	//if($Etat=='NON')
									{ 		$or="SELECT * FROM reservation_tempon WHERE num_reserv='$num_reserv'";
											$or1=mysqli_query($con,$or);$nbre=mysqli_num_rows($or1);
											if($nbre<=0)
											{ $or1=mysqli_query($con,"SELECT avancerc FROM reservationch WHERE numresch='$num_reserv'");
												 while($roi= mysqli_fetch_array($or1))
												 {  $avancerc=(int)$avancerc=$roi['avancerc'];
													 if($avancerc>0)
													 { $ri=mysqli_query($con,"UPDATE reservationch SET avancerc=avancerc-'$defalquer' WHERE numresch='$num_reserv'");
													   $ri=mysqli_query($con,"UPDATE reserverch SET avancerc=avancerc-'$defalquer',nuite_payee=-1+nuite_payee WHERE numresch='$num_reserv'");
													   $ri=mysqli_query($con,"UPDATE reservation_tempon2 SET jour='$date_jour',Etat='OUI' WHERE num_reserv='$num_reserv'");
													 }
												 }
											}
									}
							}
					}
				
			}


		}
	$mois=!empty($_GET['mois'])?$_GET['mois']:NULL;
	$annee=!empty($_GET['annee'])?$_GET['annee']:NULL;	
	if(empty($annee)) $ans_courant=date('Y');else $ans_courant=$annee;
	//echo  $ans_courant;
	$mois_courant=date('m');	
	$mois_precedent=$mois_courant-1;if(substr($mois_courant,0,1)==0)  $mois_courant=substr($mois_courant,1,1);	if(empty($mois)) $mois_courant=$mois_courant; else $mois_courant=$mois;
	//echo $mois_courant;
	mysqli_query($con,"SET NAMES 'utf8' ");
	if($sal==1) {echo"<table align='center' width='90%'><tr>
		<td>
			<hr noshade size=3 > <div align='CENTER'>
			<span style='font-style:italic;'><a class='info' href='grch3.php?menuParent=Consultation&sal=1&mois=";  $mois_courant=$mois_courant-1; if($mois_courant==0)  $mois_courant=12;   if($mois_courant==12)  $ans_courant=$ans_courant-1; $etat=1; echo $mois_courant; echo"&annee="; echo $ans_courant; echo"' title='' style='font-style:italic;color:blue;text-decoration:none;'><span style='color:teal;'>Liste des réservations précédentes</span> [Mois précédent]</a></span><B>
			<FONT SIZE=6 COLOR='Maroon'> &nbsp; &nbsp;LISTE DES RESERVATIONS DE SALLES </FONT></B>
			<B> <span style='font-style:italic;'>(Pour le mois "; $Mmois=!empty($_GET['mois'])?$_GET['mois']:NULL; if (empty($Mmois)) echo "courant"; else echo "de ".$moisT[$Mmois-1]." ".$_GET['annee']; echo ") </span>
			<span style='font-style:italic;'>&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href='grch3.php?menuParent=Consultation&sal=1&mois=";   if(!empty($_GET['mois'])) $mois_courant=$_GET['mois']+1; else $mois_courant++; if($mois_courant>=13)  $mois_courant=1;   if($mois_courant==1)  $ans_courant=$ans_courant+1;echo $mois_courant; echo"&annee="; echo $ans_courant; echo"' title='' style='font-style:italic;color:blue;text-decoration:none;'></B><span style='color:teal;'>Liste des réservations suivantes</span> [Mois suivant]</a></span>
			<FONT SIZE=4 COLOR='0000FF'> </FONT> </div> <hr noshade size=3>
		</td>
	</tr>";
	echo "</table>";} 
	else {echo"<table align='center' width='90%'><tr>
		<td>
			<hr noshade size=3> <div align='center'>
			<span style='font-style:italic;'><a class='info' href='grch3.php?menuParent=Consultation&mois=";  $mois_courant=$mois_courant-1; if($mois_courant==0)  $mois_courant=12;   if($mois_courant==12)  $ans_courant=$ans_courant-1; $etat=1; echo $mois_courant; echo"&annee="; echo $ans_courant; echo"' title='' style='font-style:italic;color:blue;text-decoration:none;'><span style='color:teal;'>Liste des réservations précédentes</span> [Mois précédent]</a></span><B>
			<FONT SIZE=6 COLOR='Maroon'> &nbsp; &nbsp;LISTE DES RESERVATIONS DE CHAMBRES </FONT></B>
			<B> <span style='font-style:italic;'>(Pour le mois "; $Mmois=!empty($_GET['mois'])?$_GET['mois']:NULL; if (empty($Mmois)) echo "courant"; else echo "de ".$moisT[$Mmois-1]." ".$_GET['annee']; echo ") </span>
			<span style='font-style:italic;'>&nbsp;&nbsp;&nbsp;&nbsp;<a class='info' href='grch3.php?menuParent=Consultation&mois=";  if(!empty($_GET['mois'])) $mois_courant=$_GET['mois']+1; else $mois_courant=$mois_courant+1; if($mois_courant==13)  {$mois_courant=1;  if(isset($_GET['annee'])) $ans_courant=$_GET['annee']+1;  $etat=1; }echo $mois_courant; echo"&annee="; echo $ans_courant; echo"' title='' style='font-style:italic;color:blue;text-decoration:none;'></B><span style='color:teal;'>Liste des réservations suivantes</span> [Mois suivant]</a></span>
			</</B>
			<FONT SIZE=4 COLOR='0000FF'> </FONT> </div> <hr noshade size=3>
		</td>
	</tr></table>";}
	if($sal!=1) 
	{ if(empty($trie))
		{//$mois_courant++;
		if(!empty($_GET['mois'])) 
		$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER By chambre.nomch ASC") or die (mysql_error());	
		else
			{$ans_courant=date('Y'); $mois_courant=date('m');if(substr($mois_courant,0,1)==0)  $mois_courant=substr($mois_courant,1,1);	
			//echo "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER By chambre.nomch ASC";
			$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER By chambre.nomch ASC") or die (mysql_error());
			}
		}
		else
		{ if(!empty($_GET['etat']) && $_GET['etat']==1) 
			{//$mois_courant++;
			if(!empty($_GET['mois'])) 
				{//echo "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER BY $trie ASC";
				$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER BY $trie ASC") or die (mysql_error());	
				}
			else
				{$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER BY $trie ASC") or die (mysql_error());
				//echo "SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER BY $trie ASC";
			}
			
			}			
			else
			{//$mois_courant++;
			if(!empty($_GET['mois'])) 
				$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER BY $trie ASC") or die (mysql_error());	
			else
				{$mois_courant--;
				$re=mysqli_query($con,"SELECT * FROM reservationch,chambre where reservationch.numch=chambre.numch AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER BY $trie DESC") or die (mysql_error());}
			}
		}
			
	}
	else 
	{if(empty($trie))
	 { //$mois_courant++;
		if(!empty($_GET['mois'])) 
		$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER By salle.numsalle ASC") or die (mysql_error());	
	   else 
		{$ans_courant=date('Y'); $mois_courant=date('m');if(substr($mois_courant,0,1)==0)  $mois_courant=substr($mois_courant,1,1);	
		$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '$mois_courant' AND annee='$ans_courant'") or die (mysql_error());
		}
	}
	 else
	 {if(!empty($_GET['etat']) && $_GET['etat']==1) 
			{//$mois_courant++;
			if(!empty($_GET['mois'])) 
				$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER BY $trie ASC") or die (mysql_error());	
			else
				{$mois_courant--;
				$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER BY $trie ASC") or die (mysql_error());
				}
			}			
			else
			{//$mois_courant++;
			if(!empty($_GET['mois'])) 
				$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '".$_GET['mois']."' AND annee='".$_GET['annee']."' ORDER BY $trie ASC") or die (mysql_error());	
			else
				{$mois_courant--;
				$re=mysqli_query($con,"SELECT * FROM reservationsal,salle where reservationsal.numsalle=salle.numsalle AND mois LIKE '$mois_courant' AND annee='$ans_courant' ORDER BY $trie DESC") or die (mysql_error());}
			}
		}	 
	}
	echo "<table border='1' align='center' align='center' width='90%'  cellpadding='0' cellspacing='0' style='border:2px solid;font-family:Cambria;'>"; 
	echo " <a href='' ><tr class='' bgcolor='#3EB27B' style='font-weight:bold;color:white;'>"; 
	if($sal!=1)
		{ echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=numresch' style='text-decoration:none;color:white;' title='Trie par Réference"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "&nbsp;ordre décroissant "; else echo "&nbsp;ordre croissant"; echo "'> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant la Numéro</span> NUMERO <a></td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=dateresch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant la date de réservation</span>DATE RESERVATION<a></td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=datarrivch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant la date d'arrivée</span>DATE D'ARRIVEE<a></td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=datdepch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.8em;'>Trier suivant la date de départ</span> DATE DE DEPART<a> </td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=nomdemch' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant Nom & prénoms</span>NOM & PRENOMS<a></td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=codegrpe' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant le groupe</span>GROUPE<a> </td>"; 
		  echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=contactdemch' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant le contact</span>CONTACT<a></td>"; 
		}
		else
		{echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=numresch' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant la réference</span>NUMERO <a></td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=dateresch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant la date de réservation</span>DATE RESERVATION<a></td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=datarrivch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant la date d'arrivée</span>DATE D'ARRIVEE<a></td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=datdepch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant la date de départ</span> DATE DE DEPART<a> </td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=nomdemch' style='text-decoration:none;color:white;' title=' '><span style='font-size:0.9em;font-weight:normal;'>Trier suivant Nom & prénoms</span> NOM & PRENOMS<a></td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=codegrpe' style='text-decoration:none;color:white;' title=''> <span style='font-size:0.9em;font-weight:normal;'>Trier suivant le groupe</span>GROUPE<a> </td>"; 
		 echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=contactdemch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant le contact</span> CONTACT<a></td>"; 
		}
if($sal!=1)		
		{echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=chambre.numch' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant le type de chambre</span>CHAMBRE N°<a></td>"; }
else
		{echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=salle.numsalle' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant le type de Salle</span>DESIGNATION SALLE<a></td>"; }
		if($sal!=1)
		{echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&trie=avancerc' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant l'avancd</span> AVANCE <a></td>"; }
		else
		{echo"<td align='center'><a class='info1' href='grch3.php?menuParent=Consultation&mois="; if(!empty($_GET['mois']))  echo $_GET['mois']; else echo $mois_courant; echo "&annee="; if(!empty($_GET['annee'])) echo $_GET['annee']; else echo $ans_courant; echo "&"; if(!empty($_GET['etat'])&& $_GET['etat']==1) echo "etat=0"; else echo "etat=1"; echo "&sal=1&trie=avancerc' style='text-decoration:none;color:white;' title=''><span style='font-size:0.9em;font-weight:normal;'>Trier suivant l'avance</span> AVANCE <a></td>"; }
		if($sal!=1)
		echo "</tr></a>";
		$cpteur=1; $i=0;
	while ($rez=mysqli_fetch_array($re))
	{  if($cpteur == 1)
		{
			$cpteur = 0;
			$bgcouleur = "#DDEEDD";
		}
		else
		{
			$cpteur = 1;
			$bgcouleur = "#F5F5DC";
		}
		$grpe=$rez['codegrpe']; if(($grpe=='Default')||($grpe=='')) $grpe='-';$agenten="Agent ayant fait la réservation&nbsp;<span style='color:red;'>".ucfirst($rez['agenten'])."</span>";
		echo " <tr class='rouge1' bgcolor='".$bgcouleur."'>"; 
		echo"<td align='center'>"; if($_SESSION['poste']=="agent") {
			echo " <a id='container'  class='info'"; 		//Commentaires du 19.09.2020 ! Revoir la partie Encaissement pour réservation
			//echo "href='encaissement.php?menuParent=Consultation&numresch=".$rez['numresch']."&avancerc=".$rez['avancerc']; 
		echo "href='#";	// ici je ne quitte plus la page en cours
		if($sal==1) echo"&sal=1"; echo "'title='' > ";} echo $rez['numresch']; if($_SESSION['poste']=="agent") echo "<span>  Encaisser pour&nbsp;:&nbsp;&nbsp;<span style='color:red;'>".$rez['nomdemch']."&nbsp;".$rez['prenomdemch']." </span>   </span>
		
		</a>"; echo "</td>"; 
		echo"<td align='center'><a class='info' href=''>".$rez['dateresch']."<span style='color:maroon;'>".$agenten."</span></a></td>"; 
		echo"<td align='center'>".
		substr($rez['datarrivch'],8,2).'-'.substr($rez['datarrivch'],5,2).'-'.substr($rez['datarrivch'],0,4)."</td>"; 
		echo"<td align='center'>".substr($rez['datdepch'],8,2).'-'.substr($rez['datdepch'],5,2).'-'.substr($rez['datdepch'],0,4)."</td>"; 
		echo"<td align=''>&nbsp;&nbsp;&nbsp;&nbsp;". $rez['nomdemch']."&nbsp;&nbsp;&nbsp; ".$rez['prenomdemch']."</td>"; 
		echo"<td align='center'>". $grpe."</td>"; 
		echo"<td align='center'>".$rez['contactdemch']."</td>"; 
if($sal!=1)
		echo"<td align='center'>". $rez['nomch']."</td>"; 
else
		echo"<td align='center'>". $rez['codesalle']."</td>"; 
		echo"<td align='center'>". $rez['avancerc']."</td>"; 
		echo "</tr>"; 
	}
	echo " </table>
		</div>
	</body>
</html> "; 
?>