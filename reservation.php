<?php
	$_SESSION['avc']=$_POST['edit5'];
	$_SESSION['numresch']=$_POST['edit2'];
	
	$_SESSION['sommeDue']=$_POST['edit3'];$_SESSION['update']=1; 
	
	
	if(isset($_POST['exhonerer_aib']))
		{ $_SESSION['exhonerer_aib']=$_POST['exhonerer_aib'];	
		  $tu=mysql_query("INSERT INTO exonerer_aib VALUES ('".date('Y-m-d')."','".$_SESSION['numresch']."')");
		}
	if(isset($_POST['exhonerer_tva']))
		{ 	$_SESSION['exhonerer_tva']=$_POST['exhonerer_tva'];
			$tu=mysql_query("INSERT INTO exonerer_tva VALUES ('".date('Y-m-d')."','".$_SESSION['numresch']."')");
		}
	if(empty($_POST['pourcent']))
		{ //$somme=$_POST['edit5'];
		  $edit5=$_POST['edit5'];
		}
	else
		{//echo $somme=$_POST['edit5']+$_POST['remise'];	
		 $edit5=$_POST['edit5']+$_POST['remise'];
		 
		}
	$_SESSION['remise']=$_POST['remise'];

	$s=mysql_query("SELECT du,au FROM reeditionfacture2,reedition_facture WHERE reeditionfacture2.numfiche='".$_POST['edit2']."' AND reeditionfacture2.numrecu=reedition_facture.numrecu");
	while($ez=mysql_fetch_array($s))
	{//$_SESSION['mtht']=$ez['tarifrc'];					
	
	}
	
	$s=mysql_query("SELECT sum(montantrc*nuiterc) AS tarifrc FROM reservationch WHERE numresch='".$_POST['edit2']."'");
	while($ez=mysql_fetch_array($s))
	{$_SESSION['mtht']=$ez['tarifrc'];
	 $_SESSION['tva']=0.18*$ez['tarifrc'];
	}
	
	$s=mysql_query("SELECT nuiterc AS nuiterc FROM reservationch WHERE numresch='".$_POST['edit2']."'");
	while($ez=mysql_fetch_array($s))
	{ $nuiterc=$ez['nuiterc'];
	}
	
	$s=mysql_query("SELECT sum(ttc) AS ttc FROM reserverch WHERE numresch='".$_POST['edit2']."'");
	while($ez=mysql_fetch_array($s))
	{$_SESSION['mtttc']=$ez['ttc']*$nuiterc;
	}
	$_SESSION['taxe']=0;$i=0; $taxe=array("");
	$s=mysql_query("SELECT typeoccuprc AS typeoccuprc FROM reserverch WHERE numresch='".$_POST['edit2']."'");
	$nbre_rows=mysql_num_rows($s);
	while($ez=mysql_fetch_array($s))
	{	$typeoccuprc=$ez['typeoccuprc'];
		if($typeoccuprc=='individuelle')
			$taxe[$i]=1000*$nuiterc;
		else
			$taxe[$i]=2000*$nuiterc;
	$i++;					
	}
	$_SESSION['taxe']=array_sum($taxe);					
	$s=mysql_query("SELECT * FROM reservationsal,salle,reserversal WHERE salle.numsalle=reservationsal.numsalle AND reservationsal.numresch= reserversal.numresch and reserversal.numresch='".$_POST['edit2']."'");
	$nbre=mysql_num_rows($s);
		while($ez=mysql_fetch_array($s))
		{ $montant=(int)(0.1+$ez['tarifrc']);
			$codegrpe=$ez['codegrpe'];
			if(!empty($codegrpe))
			$_SESSION['client']=$codegrpe; 
			else $_SESSION['client']=$ez['nomdemch'].' '.$ez['prenomdemch']; 
		$tarifrc=$ez['mtrc']; 
		}						
	if($nbre==0)
	{	$s=mysql_query("SELECT * FROM reservationch,reserverch WHERE reservationch.numresch=reserverch.numresch and reserverch.numresch='".$_POST['edit2']."'");
		$nbre=mysql_num_rows($s);
		$nbre1=mysql_num_rows($s);
		while($ez=mysql_fetch_array($s))
		{ 	$_SESSION['numresch']=$_POST['edit2'];
			$codegrpe=$ez['codegrpe'];
			if(!empty($codegrpe))
			$_SESSION['client']=$codegrpe; 
			else $_SESSION['client']=$ez['nomdemch'].' '.$ez['prenomdemch']; 
			$tva=0.18*$ez['tarifrc'];
			$_SESSION['debut']=substr($ez['datarrivch'],8,2).'/'.substr($ez['datarrivch'],5,2).'/'.substr($ez['datarrivch'],0,4);
			$_SESSION['fin']=substr($ez['datdepch'],8,2).'/'.substr($ez['datdepch'],5,2).'/'.substr($ez['datdepch'],0,4);
			//$edit5=$_POST['edit5'];							
			
		}	
if(($_SESSION['mtttc']==$edit5))
{  $np=$_SESSION['nuite'];
   $ret=mysql_query('SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'.$_POST['edit2'].'"');
	while ($ret1=mysql_fetch_array($ret))
	 {  $numch=$ret1['numch'];
		$ttc=$ret1['ttc']; $ttc1=$ret1['ttc']*$np;    
		$typeoccuprc=$ret1['typeoccuprc'];
		$tarifrc=$ret1['tarifrc'];
		$tr1="UPDATE reserverch SET  avancerc=avancerc+'$ttc1', nuite_payee='$np' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
		$tre_1=mysql_query($tr1);
		$tr="UPDATE reservationch SET  avancerc=avancerc+'$ttc1' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
		$tre=mysql_query($tr);
		//echo $tr1."<br/>".$tr;
		$_SESSION['mt']=$_POST['edit3']; 
		$_SESSION['av']=$_POST['edit4']; 
		mysql_query("SET NAMES 'utf8' ");
		
		if (($_POST['edit5']!=0))
		{ 	$tu=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
			$tu=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit1']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
			$res=mysql_query("DROP TABLE `table_tempon`");
			header('location:recurc2.php');
		}
	  }
	if (($_POST['edit5']!=0))
		{	//$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
			$res=mysql_query("DROP TABLE `table_tempon`");
			header('location:recurc2.php');
		}
}				
else{ 
$ret=mysql_query('SELECT numch,ttc,typeoccuprc,tarifrc FROM reserverch WHERE  numresch="'.$_POST['edit2'].'"');
while ($ret1=mysql_fetch_array($ret))
	 { 	  $numch=$ret1['numch'];
		  $ttc=$ret1['ttc'];   
		  $typeoccuprc=$ret1['typeoccuprc'];
		  $tarifrc=$ret1['tarifrc'];	
		 // if((is_int($_POST['edit5']/$ttc))||((($_POST['edit5']!='')||($_POST['edit5']!=0))&&(is_int($ttc/$_POST['edit5'])))||($_POST['edit5']==0))
if((is_int($edit5/$ttc))||(is_int($ttc/$edit5)))
  {		if($ttc>0)
		{if($edit5>=$ttc) $np=(int)($edit5/$ttc);else $np=(int)($ttc/$edit5);}
		$tr1="UPDATE reserverch SET  avancerc=avancerc+'".$_POST['edit5']."', nuite_payee=nuite_payee+'$np' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
		$tre_1=mysql_query($tr1);
		$tr="UPDATE reservationch SET  avancerc=avancerc+'".$_POST['edit5']."' WHERE numresch='".$_POST['edit2']."' AND numch='$numch'";
		//echo $tr1."<br/>".$tr;
		$tre=mysql_query($tr);						
	
		$n_p=1;
		$_SESSION['mt']=$_POST['edit3']; 
		$_SESSION['av']=$_POST['edit4']; 
		$tre=mysql_query($tr1);
		if (($_POST['edit5']!=0))
		{ 	//$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
			$tu=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
			$tu=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation chambre','$numch','$typeoccuprc','$tarifrc','$ttc','$np')");
			$res=mysql_query("DROP TABLE `table_tempon`");
			header('location:recurc2.php');
			if ($_POST['edit_7']!=0)
			{	$retA=mysql_query('SELECT sum(tarifrc) AS tarifrc FROM reserversal WHERE reserversal.numresch="'.$_POST['edit2'].'"');
				$resultA=mysql_fetch_assoc($retA);$ttc=(int)($resultA['tarifrc']+0.1);	$np_sal=$edit5/$ttc;
				$ret=mysql_query('SELECT salle.typesalle,reserversal.codesalle,reserversal.tarifrc  FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND  numresch="'.$_POST['edit2'].'"');
				while ($ret1=mysql_fetch_array($ret))
				{ $codesalle=$ret1['codesalle']; 
				  $typesalle=$ret1['typesalle']; 					
				  $tarifrc=$ret1['tarifrc'];	
				  $ttc1=(int)($tarifrc+0.1);
				  //$np_sal=$_POST['edit5']/$ttc1;
				  $_SESSION['np_sal']=$np_sal-1;
				}		
		$tr1="UPDATE reserversal SET  avancerc='".$_POST['edit_7']."', nuite_payee ='$np_sal' WHERE numresch='".$_POST['edit2']."'";
		$tre1=mysql_query($tr1);
		$tr="UPDATE reservationsal SET  avancerc=avancerc+'".$_POST['edit_7']."' WHERE numresch='".$_POST['edit2']."'";
		$tu=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$tarifrc','$ttc1','$np_sal')");
		$tu1=mysql_query("INSERT INTO mensuel_encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$_SESSION['avc']."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$tarifrc','$ttc1','$np_sal')");	
			} 
			if(!$tu)
			{echo "<script language='javascript'> alert('Encaissement non effectué.'); </script>"; 
			}
		}
		else	
		{header('location:encaissement.php');}
		exit();
	}
}
}					
}
if(($nbre!=0)&&($nbre1==0))  //Nbre de salles supérieur à 0 et chambres=0
{ if (($_POST['edit5']!=0))
{ 	$_SESSION['chambre']=0;	
	$res=mysql_query("SELECT numfiche  FROM exonerer_tva WHERE numfiche='".$_POST['edit2']."'");
	while ($ret=mysql_fetch_array($res)) 
		{$numfiche_1=$ret['numfiche'];
		}
$res=mysql_query("SELECT nuiterc AS nuiterc FROM reservationsal WHERE numresch='".$_POST['edit2']."'");
while ($ret=mysql_fetch_array($res)) 
	{$nuiterc=$ret['nuiterc'];
	}
if(empty($numfiche_1))
$res=mysql_query("SELECT sum((0.18*mtrc)+mtrc+0.1) AS somme FROM reserversal WHERE reserversal.numresch='".$_POST['edit2']."'");
else
$res=mysql_query("SELECT sum(mtrc) AS somme FROM reserversal WHERE  reserversal.numresch='".$_POST['edit2']."'");
while ($ret=mysql_fetch_array($res)) 
	{if(empty($numfiche_1)) $total=(int) ($ret['somme']*$nuiterc);else $total=$ret['somme']*$nuiterc;
	}
$due=$total-$avancerc;
$_SESSION['total']=$total;
	//$edit5=$_POST['edit5'];
	$retA=mysql_query('SELECT sum(tarifrc) AS tarifrc FROM reserversal WHERE reserversal.numresch="'.$_POST['edit2'].'"');
	$resultA=mysql_fetch_assoc($retA);$ttc=(int)($resultA['tarifrc']+0.1);	$np_sal=$edit5/$ttc;
	$ret=mysql_query('SELECT DISTINCT salle.numsalle,reservationsal.datarrivch,salle.typesalle,reserversal.codesalle,reserversal.tarifrc,reserversal.mtrc FROM reservationsal,reserversal,salle WHERE reserversal.numresch=reservationsal.numresch   AND reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
	while ($ret1=mysql_fetch_array($ret))
	{ $codesalle=$ret1['codesalle']; 
	  $typesalle=$ret1['typesalle']; 					
	  $tarifrc=$ret1['tarifrc'];	
	  $ttc1=(int)($tarifrc+0.1);
	 // $mtttc=(int)($tarifrc+0.1);
	  $mtttc1=(int)((($ret1['mtrc']*0.18)+$ret1['mtrc'])+0.1);
	  //$mtttc*=$nuiterc;
	  $debut=$ret1['datarrivch']; 
	  $fin=$ret1['datarrivch']; 
	  $numsalle=$ret1['numsalle'];
	  $_SESSION['np_sal']=$np_sal-1;
	  $nuite_payee=1;
	 // do {	
		//$nuite_payee++; //$mtttc=$mtttc*$nuite_payee;
		$edit5-=$mtttc;
	  //} while($edit5<=0);
	  //echo $nuite_payee=(int)($edit5/$mtttc);
	  $mtttc=$mtttc1*$np_sal;
	  //$mtttc*=$nuiterc;
	  if($nuite_payee>0)
		{	$tr1="UPDATE reserversal SET  avancerc=avancerc+'$mtttc1', nuite_payee=nuite_payee+'".$np_sal."' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
			$tre_1=mysql_query($tr1);
			$tr="UPDATE reservationsal SET  avancerc=avancerc+'$mtttc' WHERE numresch='".$_POST['edit2']."' AND numsalle='$numsalle'";
			$tre=mysql_query($tr);
			$etat=1;
		}
		
	}
	
	$ret=mysql_query('SELECT sum(mtrc) AS mtrc,sum(tarifrc) AS tarifrc  FROM reserversal,salle WHERE reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
	while ($ret1=mysql_fetch_array($ret))
	{ $mtrc=$ret1['mtrc']; 
	  $tarifrc=$ret1['tarifrc'];
	}
	$_SESSION['mtht']=$mtrc;
	$_SESSION['mtttc']=(int)(($tarifrc)*$nuiterc);

	$_SESSION['debut']=substr($debut,8,2).'/'.substr($debut,5,2).'/'.substr($debut,0,4);$mois=substr($debut,5,2);$ans=substr($debut,0,4);$jour=substr($debut,8,2);
	$nuiterc--; // pour les salles
	$_SESSION['fin']=date("d/m/Y", mktime(0, 0, 0,date($mois),date($jour)+$nuiterc,date($ans)));
	//$_SESSION['fin']=substr($fin,8,2).'/'.substr($fin,5,2).'/'.substr($fin,0,4);
	
	$ret=mysql_query('SELECT DISTINCT salle.numsalle,reservationsal.datarrivch,salle.typesalle,reserversal.codesalle,reserversal.tarifrc,reserversal.mtrc,reserversal.avancerc,reserversal.nuite_payee FROM reservationsal,reserversal,salle WHERE reserversal.numresch=reservationsal.numresch   AND reserversal.numsalle=salle.numsalle AND reserversal.numresch="'.$_POST['edit2'].'"');
	while ($ret1=mysql_fetch_array($ret))
	{ $codesalle=$ret1['codesalle']; 
	  $typesalle=$ret1['typesalle']; 					
	  $tarifrc=$ret1['tarifrc'];	
	  $nuite_payee=$ret1['nuite_payee'];	
	  $ttc1=$ret1['avancerc']* $nuite_payee;$mtrc=$ret1['mtrc']* $nuite_payee; 
	  if($nuite_payee>0)
		$tu=mysql_query("INSERT INTO encaissement VALUES ('','".date('Y-m-d')."','".date('H:i:s')."','".$_POST['edit2']."','".$ttc1."','".$_SESSION['login']."','Reservation salle','".$typesalle."','','$mtrc','$tarifrc','$nuite_payee')");
	}
	  //$update=mysql_query("UPDATE configuration_facture SET num_fact=num_fact+1 ");
	  $res=mysql_query("DROP TABLE `table_tempon`");
	  header('location:recurc2.php');
}			
}
?>